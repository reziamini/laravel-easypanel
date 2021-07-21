<?php

namespace EasyPanel\Parsers;

use EasyPanel\Parsers\HTMLInputs\BaseInput;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StubParser
{

    public $texts = [];
    private $inputName;
    private $parsedModel;

    private $fields;
    private $inputs;
    private $validationRules;
    private $hasAuth;
    private $store;

    public function __construct($inputName, $parsedModel)
    {
        $this->inputName = $inputName;
        $this->parsedModel = $parsedModel;
    }

    public function setValidationRules($rules)
    {
        $this->validationRules = $rules;
    }

    public function setStore($store)
    {
        $this->store = $store;
    }

    public function setAuthType(bool $hasAuth){
        $this->hasAuth = $hasAuth;
    }

    public function setFields(array $fields){
        $this->fields = $fields;
    }

    public function setInputs(array $inputs){
        $this->inputs = $inputs;
    }

    public function replaceModel($stub)
    {
        $modelNamespace = $this->parsedModel;
        $modelName = $this->getModelName($modelNamespace);

        $array = [
            '{{ modelName }}' => ucfirst($modelName),
            '{{ modelNamespace }}' => $modelNamespace,
            '{{ uploadFile }}' => $this->uploadCodeParser(),
            '{{ model }}' => strtolower($modelName),
            '{{ properties }}' => $this->parseProperties(),
            '{{ rules }}' => $this->parseValidationRules(),
            '{{ fields }}' => $this->parseActionInComponent(),
            '{{ setProperties }}' => $this->parseSetPropertiesValue(),
        ];

        return str_replace(array_keys($array), array_values($array), $stub);
    }

    /**
     * Make Locale files
     */
    public function setLocaleTexts()
    {
        $this->texts[ucfirst($this->inputName)] = ucfirst($this->inputName);
        $this->texts[ucfirst(Str::plural($this->inputName))] = ucfirst(Str::plural($this->inputName));
        $files = File::glob(resource_path('lang').'/*_panel.json');

        foreach ($files as $file) {
            $decodedFile = json_decode(File::get($file), 1);
            $texts = $this->texts;
            foreach ($texts as $key => $text) {
                if (array_key_exists($key, $decodedFile)){
                    unset($texts[$text]);
                }
            }
            $array = array_merge($decodedFile, $texts);
            File::put($file, json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Get model name from namespace
     */
    public function getModelName($modelNamespace)
    {
        $array = explode('\\', $modelNamespace);

        return end($array);
    }

    /**
     * Parse properties in Livewire component
     */
    public function parseProperties()
    {
        $fields = array_keys($this->inputs);
        $str = '';

        if(in_array($this->inputName, $fields)){
            $this->error("Model name must not equal to column names, fix it and rerun command with -f flag");
            die;
        }

        foreach ($fields as $field) {
            $str .= 'public $'.$field.";".$this->makeTab(1);
        }

        return $str;
    }

    /**
     * Parse Uploading Code
     */
    public function uploadCodeParser()
    {
        $filesInput = array_keys($this->inputs, 'file');
        $str = '';
        foreach ($filesInput as $file) {
            // We get store path which has been defined in crud's config file
            $storePath = $this->store[$file] ?? "{$file}";

            // We get property value then store file in $storePath
            // A PHP Code for upload as a string will be created here
            $str .= $this->makeTab(2).'if($this->getPropertyValue(\''.$file.'\') and is_object($this->'.$file.')) {'.$this->makeTab(3);
            $str .= '$this->'.$file.' = $this->getPropertyValue(\''.$file.'\')->store(\''.$storePath.'\');'.$this->makeTab(2);
            $str .= '}'.PHP_EOL;
        }

        return $str;
    }

    /**
     * parse values for mount method in Livewire
     */
    public function parseSetPropertiesValue()
    {
        $fields = array_keys($this->inputs);
        $str = '';
        $action = $this->inputName;
        foreach ($fields as $field) {
            $str .= '$this->'.$field.' = $this->'.$action.'->'.$field.';'.$this->makeTab(2, end($fields) != $field);
        }

        return $str;
    }

    /**
     * Parse Validation rules
     */
    public function parseValidationRules()
    {
        $str = '';

        foreach ($this->validationRules as $key => $rule) {
            $str .= "'$key' => '$rule',".$this->makeTab(2, $rule != end($this->validationRules));
        }

        return $str;
    }

    /**
     * Create an array of properties in Livewire component for actions
     */
    public function parseActionInComponent()
    {
        $str = '';

        foreach ($this->inputs as $key => $field) {
            $newLine = ($field != end($this->inputs) or $this->hasAuth);
            $str .=  "'$key' => " . '$this' . "->$key,".$this->makeTab(3, $newLine);
        }

        if($this->hasAuth){
            $str .= "'user_id' => auth()->id(),";
        }

        return $str;
    }

    /**
     * Create Blade from stub
     */
    public function parseBlade($stub){
        $modelName = $this->getModelName($this->parsedModel);

        $array = [
            '{{ model }}' => strtolower($modelName),
            '{{ modelName }}' => ucfirst($modelName),
            '{{ data }}' => $this->parseDataInBlade(),
            '{{ titles }}' => $this->parseTitlesInBlade(),
            '{{ inputs }}' => $this->parseInputsInBlade(),
            '{{ routeName }}' => crud(strtolower($modelName))->route,
        ];

        $this->setLocaleTexts();

        return str_replace(array_keys($array), array_values($array), $stub);
    }

    /**
     * Parse <td> tags for data
     */
    public function parseDataInBlade()
    {
        $fields = $this->fields;
        $str = '';
        $modelName = strtolower($this->getModelName($this->parsedModel));
        foreach ($fields as $value) {
            if (!is_array($value)) {
                if(!in_array($value, ['image', 'photo', 'profile', 'banner'])) {
                    $str .= '<td> {{ $' . $modelName . '->' . $value . " }} </td>" . $this->makeTab(1, end($fields) != $value);
                } else {
                    $str .= '<td><a target="_blank" href="{{ asset($' . $modelName . '->' . $value . ') }}"><img class="rounded-circle img-fluid" width="50" height="50" src="{{ asset($' . $modelName . '->' . $value . ') }}" alt="'.$value.'"></a></td>' . $this->makeTab(1, end($fields) != $value);
                }
            } else {
                $relationName = array_key_first($value);
                $str .= '<td> {{ $' . $modelName . '->' . $relationName . '->'. $value[array_key_first($value)] .' }} </td>' . $this->makeTab(1, end($fields) != $value);
            }
        }

        return $str;
    }

    /**
     * Parse <td> tags for head
     */
    public function parseTitlesInBlade()
    {
        $fields = $this->fields;
        $str = '';
        foreach ($fields as $field) {
            if (!is_array($field)) {
                $sortName = $field;
                $field = ucfirst($field);
                $str .= "<td style='cursor: pointer' wire:click=\"sort('$sortName')\"> <i class='fa @if(".'$sortType'." == 'desc' and ".'$sortColumn'." == '$sortName') fa-sort-amount-down ml-2 @elseif(".'$sortType == '."'asc' and ".'$sortColumn'." == '$sortName') fa-sort-amount-up ml-2 @endif'></i> {{ __('$field') }} </td>".$this->makeTab(6, end($fields) != $field);
            } else {
                $relationName = array_key_first($field);
                $field = ucfirst($relationName). ' ' . ucfirst($field[array_key_first($field)]);
                $str .= "<td> {{ __('$field') }} </td>".$this->makeTab(6, end($fields) != $field);
            }
            $this->texts[$field] = $field;
        }

        return $str;
    }

    /**
     * Create inputs HTML
     */
    public function parseInputsInBlade()
    {
        $str = '';
        foreach ($this->inputs as $name => $type) {
            $title = ucfirst($name);
            $this->texts[$title] = ucfirst($name);
            $str .= (new BaseInput($name, $type, $this->inputName))->render();
        }

        return $str;
    }

    /**
     * Tab Maker (Each tabs mean 4 space)
     */
    public function makeTab($count, $newLine = true){
        $count = $count * 4;
        $tabs = str_repeat(' ', $count);

        return $newLine ? "\n".$tabs : $tabs;
    }

}
