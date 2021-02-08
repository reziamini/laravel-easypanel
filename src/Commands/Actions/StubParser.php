<?php

namespace EasyPanel\Commands\Actions;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use InvalidArgumentException;

trait StubParser
{

    private $texts = [];

    public function getDefaultNamespace($rootNamespace)
    {
        $name = ucfirst($this->getNameInput());
        $this->path = parent::getDefaultNamespace($rootNamespace)."\\Http\\Livewire\\Admin\\$name";

        return $this->path;
    }

    public function replaceModel($stub)
    {
        $fields = $this->getConfig('fields');

        $modelNamespace = $this->parseModel($this->getConfig('model'));
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
        $this->texts[ucfirst($this->getNameInput())] = ucfirst($this->getNameInput());
        $this->texts[ucfirst(Str::plural($this->getNameInput()))] = ucfirst(Str::plural($this->getNameInput()));
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
        $modelNamespace = $this->parseModel($this->getConfig('model'));
        $modelName = $this->getModelName($modelNamespace);
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

    public function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

    public function getConfig($key, $action = null){
        $action = $action ?? $this->getNameInput();

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

        if(in_array($this->getNameInput(), $fields)){
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
            $storePath = $this->getConfig('store')[$file] ?? "{$file}";
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
        $action = $this->getNameInput();
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

        $model = $this->getNameInput();
        if(config("easy_panel.crud.$model.extra_values")){
            $str .= $this->parseExtraValues();
        }

        return $str;
    }

    public function parseExtraValues(){
        $str = '';

        $values = $this->getConfig('extra_values');
        foreach ($values as $key => $value) {
            $str .= $this->makeTab(3, end($values) != $values)."'$key' => $value,";
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
                    $str .= '<td><a target="_blank" href="{{ asset($' . $modelName . '->' . $value . ') }}"><img class="rounded-circle img-fluid" width="50" height="50" src="{{ asset($' . $modelName . '->' . $value . ') }}" alt="'.$value.'"></td></a>' . $this->makeTab(1, end($fields) != $value);
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
                $field = ucfirst($field);
            } else {
                $relationName = array_key_first($field);
                $field = ucfirst($relationName). ' ' . ucfirst($field[array_key_first($field)]);
            }
            $this->texts[$field] = $field;
            $str .= "<td> {{ __('$field') }} </td>".$this->makeTab(6, end($fields) != $field);
        }

        return $str;
    }

    public function parseInputsInBlade()
    {
        $fields = $this->getConfig('fields');

        $str = '';
        foreach ($fields as $key => $type) {
            $str .= '<div class="form-group">'.$this->makeTab(4);
            $title = ucfirst($key);
            $this->texts[$title] = $title;
            $str .= '<label for="input'.$key.'" class="col-sm-2 control-label">'.__($title).'</label>'.$this->makeTab(4);
            $str = $this->inputsHTML($type, $key, $str).$this->makeTab(4);
            $str .= '@error("'.$key.'") <div class="invalid-feedback">{{ $message }}</div> @enderror'.$this->makeTab(3);
            $str .= '</div>'.$this->makeTab(3);
        }

        return $str;
    }

    public function inputsHTML($type, $key, string $str): string
    {
        $mode = config('easy_panel.lazy_mode') ? 'wire:model.lazy' : 'wire:model';
        $array = [
            'text' => '<input type="text" '. $mode .'="' . $key . '" class="form-control @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">',
            'email' => '<input type="email" '. $mode .'="' . $key . '" class="form-control @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">',
            'number' => '<input type="number" '. $mode .'="' . $key . '" class="form-control @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">',
            'file' => '<input type="file" wire:model="' . $key . '" class="form-control-file @error(\''.$key.'\')is-invalid @enderror" id="input' . $key . '">',
            'textarea' => '<textarea '.$mode.'="' . $key . '" class="form-control @error(\''.$key.'\')is-invalid @enderror"></textarea>',
            'password' => '<input type="password" '. $mode .'="' . $key . '" class="form-control  @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">',
            'ckeditor' => '<div wire:ignore><textarea class="form-control ckeditor" id="editor" wire:model="'. $key .'"></textarea></div>'."<script>ClassicEditor.create(document.querySelector('#editor'), {}).then(editor => {editor.model.document.on('change:data', () => {@this.content = editor.getData()});});</script>",
        ];
        $str .= $array[$type];

        return $str;
    }

    public function makeTab($count, $newLine = true){
        $count = $count * 4;
        $tabs = str_repeat(' ', $count);

        return $newLine ? "\n".$tabs : $tabs;
    }

}
