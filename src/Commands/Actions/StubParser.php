<?php


namespace EasyPanel\Commands\Actions;


use InvalidArgumentException;
use Symfony\Component\Console\Exception\CommandNotFoundException;

trait StubParser
{

    protected function getDefaultNamespace($rootNamespace)
    {
        $name = ucfirst($this->getNameInput());
        $this->path = parent::getDefaultNamespace($rootNamespace)."\\Http\\Livewire\\Admin\\$name";

        return $this->path;
    }

    protected function replaceModel($stub)
    {
        $fields = $this->getConfig('fields');
        if(!$fields) {
            throw new CommandNotFoundException("There is no `field` in your config file");
        }

        $modelNamespace = $this->parseModel($this->getConfig('model'));
        $modelName = $this->getModelName($modelNamespace);

        $array = [
            '{{ modelName }}' => $modelName,
            '{{ modelNamespace }}' => $modelNamespace,
            '{{ model }}' => strtolower($modelName),
            '{{ properties }}' => $this->parseProperties($fields),
            '{{ rules }}' => $this->parseValidationRules(),
            '{{ fields }}' => $this->parseFields($fields),
            '{{ setProperties }}' => $this->parsePropertiesValue($fields),
        ];

        return str_replace(array_keys($array), array_values($array), $stub);
    }

    protected function parseBlade($stub){
        $modelNamespace = $this->parseModel($this->getConfig('model'));
        $modelName = $this->getModelName($modelNamespace);
        $array = [
            '{{ model }}' => strtolower($modelName),
            '{{ modelName }}' => $modelName,
            '{{ data }}' => $this->parseDataInBlade($modelName),
            '{{ titles }}' => $this->parseTitlesInBlade(),
            '{{ inputs }}' => $this->parseInputsInBlade(),
        ];

        return str_replace(array_keys($array), array_values($array), $stub);
    }

    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

    protected function getConfig($key){
        $action = $this->getNameInput();
        if(config('easy_panel.actions.'.$action.'.'.$key)){
            return config('easy_panel.actions.'.$action.'.'.$key);
        }

        throw new CommandNotFoundException("There is no {$action} in config file");
    }

    protected function getModelName($modelNamespace)
    {
        $array = explode('\\', $modelNamespace);

        return end($array);
    }

    protected function parseProperties($fields)
    {
        $fields = array_keys($fields);
        $str = '';
        foreach ($fields as $field) {
            $str .= 'public $'.$field.";\n    ";
        }

        return $str;
    }

    protected function parsePropertiesValue($fields)
    {
        $fields = array_keys($fields);
        $str = '';
        $action = $this->getNameInput();
        foreach ($fields as $field) {
            $str .= '$this->'.$field.' = $this->'.$action.'->'.$field.';'."\n    ";
        }

        return $str;
    }

    protected function parseValidationRules()
    {
        $rules = $this->getConfig('validation');

        $str = '';
        foreach ($rules as $key => $rule) {
            $str .= $rule != end($rules) ? "'$key' => '$rule',\n        " : "'$key' => '$rule',";
        }

        return $str;
    }

    protected function parseFields($fields)
    {
        $str = '';
        foreach ($fields as $key => $field) {
            $str .= $field != end($fields) ? "'$key' => " . '$this' . "->$key,\n            " : "'$key' => " . '$this' . "->$key,";
        }

        return $str;
    }

    protected function parseDataInBlade($modelName)
    {
        $fields = $this->getConfig('fields');
        $str = '';
        $modelName = strtolower($modelName);
        foreach ($fields as $key => $field) {
            $str .= '<td> {{ $'.$modelName.'->'.$key." }} </td>\n";
        }

        return $str;
    }

    protected function parseTitlesInBlade()
    {
        $fields = $this->getConfig('fields');
        $str = '';
        foreach ($fields as $key => $field) {
            $key = ucfirst($key);
            $str .= "<td> $key </td>\n";
        }

        return $str;
    }

    protected function parseInputsInBlade()
    {
        $fields = $this->getConfig('fields');

        $str = '';
        foreach ($fields as $key => $type) {
            $str .= '<div class="form-group"><label for="input'.$key.'" class="col-sm-2 control-label">'.ucfirst($key).'</label>'.PHP_EOL;
            $str = $this->inputsHTML($type, $key, $str).PHP_EOL;
            $str .='@error("'.$key.'") <div class="invalid-feedback">{{ $message }}</div> @enderror</div>'.PHP_EOL;
        }

        return $str;
    }

    protected function inputsHTML($type, $key, string $str): string
    {
        $array = [
            'text' => '<input type="text" wire:model.lazy="' . $key . '" class="form-control @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">'.PHP_EOL,
            'file' => '<input type="file" wire:model="' . $key . '" class="form-control-file @error(\''.$key.'\')is-invalid @enderror" id="input' . $key . '"">'.PHP_EOL,
            'textarea' => '<textarea wire:model="' . $key . '" class="form-control @error(\''.$key.'\')is-invalid @enderror"></textarea>'.PHP_EOL,
            'password' => '<input type="password" wire:model.lazy="' . $key . '" class="form-control  @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">'.PHP_EOL,
        ];
        $str .= $array[$type];

        return $str;
    }
}
