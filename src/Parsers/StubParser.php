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

    public function __construct($inputName, $parsedModel)
    {
        $this->inputName = $inputName;
        $this->parsedModel = $parsedModel;
    }

    public function replaceModel($stub)
    {
        $fields = $this->getConfig('fields');

        $modelNamespace = $this->parsedModel;
        $modelName = $this->getModelName($modelNamespace);

        $array = [
            '{{ modelName }}' => $modelName,
            '{{ modelNamespace }}' => $modelNamespace,
            '{{ uploadFile }}' => $this->uploadCodeParser($fields),
            '{{ model }}' => strtolower($modelName),
            '{{ properties }}' => $this->parseProperties($fields),
            '{{ rules }}' => $this->parseValidationRules(),
            '{{ fields }}' => $this->parseFields($fields),
            '{{ setProperties }}' => $this->parsePropertiesValue($fields),
        ];

        return str_replace(array_keys($array), array_values($array), $stub);
    }

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

    public function parseBlade($stub){
        $modelName = $this->getModelName($this->parsedModel);

        $array = [
            '{{ model }}' => strtolower($modelName),
            '{{ modelName }}' => $modelName,
            '{{ data }}' => $this->parseDataInBlade($modelName),
            '{{ titles }}' => $this->parseTitlesInBlade(),
            '{{ inputs }}' => $this->parseInputsInBlade(),
        ];

        $this->setLocaleTexts();

        return str_replace(array_keys($array), array_values($array), $stub);
    }

    public function getConfig($key, $action = null){
        $action = $action ?? $this->inputName;

        return config("easy_panel.crud.$action.$key") ?: [];
    }

    public function getModelName($modelNamespace)
    {
        $array = explode('\\', $modelNamespace);

        return end($array);
    }

    public function parseProperties($fields)
    {
        $fields = array_keys($fields);
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

    public function uploadCodeParser($fields)
    {
        $filesInput = array_keys($fields, 'file');
        $str = '';
        foreach ($filesInput as $file) {
            // We get store path which has been defined in crud's config file
            $storePath = $this->getConfig('store')[$file] ?? "{$file}";

            // We get property value then store file in $storePath
            // A PHP Code for upload as a string will be created here
            $str .= $this->makeTab(2).'if($this->getPropertyValue(\''.$file.'\') and is_object($this->'.$file.')) {'.$this->makeTab(3);
            $str .= '$this->'.$file.' = $this->getPropertyValue(\''.$file.'\')->store(\''.$storePath.'\');'.$this->makeTab(2);
            $str .= '}'.PHP_EOL;
        }

        return $str;
    }

    public function parsePropertiesValue($fields)
    {
        $fields = array_keys($fields);
        $str = '';
        $action = $this->inputName;
        foreach ($fields as $field) {
            $str .= '$this->'.$field.' = $this->'.$action.'->'.$field.';'.$this->makeTab(2, end($fields) != $field);
        }

        return $str;
    }

    public function parseValidationRules()
    {
        $rules = $this->getConfig('validation');

        $str = '';
        foreach ($rules as $key => $rule) {
            $str .= "'$key' => '$rule',".$this->makeTab(2, $rule != end($rules));
        }

        return $str;
    }

    public function parseFields($fields)
    {
        $str = '';
        foreach ($fields as $key => $field) {
            $str .= $field != end($fields) ? "'$key' => " . '$this' . "->$key,".$this->makeTab(3) : "'$key' => " . '$this' . "->$key,";
        }

        $model = $this->inputName;
        if(config("easy_panel.crud.$model.extra_values")){
            $str .= $this->parseExtraValues();
        }

        return $str;
    }

    public function parseExtraValues(){
        $str = '';

        $values = $this->getConfig('extra_values');
        foreach ($values as $key => $value) {
            $str .= $this->makeTab(3, end($values) != $values)."'$key' => '$value',";
        }

        return $str;
    }

    public function parseDataInBlade($modelName)
    {
        $fields = $this->getConfig('show');
        $str = '';
        $modelName = strtolower($modelName);
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

    public function parseTitlesInBlade()
    {
        $fields = $this->getConfig('show');
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

    public function parseInputsInBlade()
    {
        $fields = $this->getConfig('fields');

        $str = '';
        foreach ($fields as $name => $type) {
            $title = ucfirst($name);
            $this->texts[$title] = ucfirst($name);
            $str .= (new BaseInput($name, $type))->render();
        }

        return $str;
    }

    public function makeTab($count, $newLine = true){
        $count = $count * 4;
        $tabs = str_repeat(' ', $count);

        return $newLine ? "\n".$tabs : $tabs;
    }

}
