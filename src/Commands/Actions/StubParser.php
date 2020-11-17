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

        throw new CommandNotFoundException("There is no {$key} in {$action} config.");
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
            $str .= 'public $'.$field.";".$this->makeTab(1);
        }

        return $str;
    }

    protected function parsePropertiesValue($fields)
    {
        $fields = array_keys($fields);
        $str = '';
        $action = $this->getNameInput();
        foreach ($fields as $field) {
            $str .= '$this->'.$field.' = $this->'.$action.'->'.$field.';'.$this->makeTab(2);
        }

        return $str;
    }

    protected function parseValidationRules()
    {
        $rules = $this->getConfig('validation');

        $str = '';
        foreach ($rules as $key => $rule) {
            $str .= $rule != end($rules) ? "'$key' => '$rule',".$this->makeTab(2) : "'$key' => '$rule',";
        }

        return $str;
    }

    protected function parseFields($fields)
    {
        $str = '';
        foreach ($fields as $key => $field) {
            $str .= $field != end($fields) ? "'$key' => " . '$this' . "->$key,".$this->makeTab(3) : "'$key' => " . '$this' . "->$key,";
        }

        $model = $this->getNameInput();
        if(config("easy_panel.actions.$model.extra_values")){

            $str .= $this->parseExtraValues();
        }

        return $str;
    }

    protected function parseExtraValues(){
        $str = '';

        foreach ($this->getConfig('extra_values') as $key => $value) {
            $str .= "'$key' => $value,".$this->makeTab(3);
        }

        return $str;
    }

    protected function parseDataInBlade($modelName)
    {
        $fields = $this->getConfig('show');
        $str = '';
        $modelName = strtolower($modelName);
        foreach ($fields as $value) {
            $str .= '<td> {{ $'.$modelName.'->'.$value." }} </td>".$this->makeTab(1);
        }

        return $str;
    }

    protected function parseTitlesInBlade()
    {
        $fields = $this->getConfig('show');
        $str = '';
        foreach ($fields as $field) {
            $field = ucfirst($field);
            $str .= "<td> $field </td>".$this->makeTab(6);
        }

        return $str;
    }

    protected function parseInputsInBlade()
    {
        $fields = $this->getConfig('fields');

        $str = '';
        foreach ($fields as $key => $type) {
            $str .= '<div class="form-group">'.$this->makeTab(4);
            $str .= '<label for="input'.$key.'" class="col-sm-2 control-label">'.ucfirst($key).'</label>'.$this->makeTab(4);
            $str = $this->inputsHTML($type, $key, $str).$this->makeTab(4);
            $str .='@error("'.$key.'") <div class="invalid-feedback">{{ $message }}</div> @enderror'.$this->makeTab(3);
            $str .= '</div>'.$this->makeTab(3);
        }

        return $str;
    }

    protected function inputsHTML($type, $key, string $str): string
    {
        $array = [
            'text' => '<input type="text" wire:model.lazy="' . $key . '" class="form-control @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">',
            'email' => '<input type="email" wire:model.lazy="' . $key . '" class="form-control @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">',
            'number' => '<input type="number" wire:model.lazy="' . $key . '" class="form-control @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">',
            'file' => '<input type="file" wire:model="' . $key . '" class="form-control-file @error(\''.$key.'\')is-invalid @enderror" id="input' . $key . '">',
            'textarea' => '<textarea wire:model="' . $key . '" class="form-control @error(\''.$key.'\')is-invalid @enderror"></textarea>',
            'password' => '<input type="password" wire:model.lazy="' . $key . '" class="form-control  @error(\''.$key.'\') is-invalid @enderror" id="input' . $key . '">',
        ];
        $str .= $array[$type];

        return $str;
    }

    private function makeTab($count){
        $count = $count * 4;
        $tabs = str_repeat(' ', $count);

        return "\n".$tabs;
    }

}
