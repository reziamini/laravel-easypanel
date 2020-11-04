<?php


namespace AdminPanel\Commands\Actions;


use InvalidArgumentException;

trait StubParser
{
    protected function replaceModel($stub)
    {
        $modelNamespace = $this->parseModel($this->getConfig('model'));
        $modelName = $this->getModelName($modelNamespace);

        $array = [
            '{{ modelName }}' => $modelName,
            '{{ modelNamespace }}' => $modelNamespace,
            '{{ model }}' => strtolower($modelName),
            '{{ properties }}' => $this->parseProperties(),
            '{{ rules }}' => $this->parseValidationRules(),
            '{{ fields }}' => $this->parseFields(),
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
            '{{ titles }}' => $this->parseTitlesInBlade($modelName),
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

        return config('admin_panel.actions.'.$action.'.'.$key);
    }

    protected function getModelName($modelNamespace)
    {
        $array = explode('\\', $modelNamespace);

        return end($array);
    }

    protected function parseProperties()
    {
        $fields = $this->getConfig('fields');
        $fields = array_keys($fields);

        $str = '';
        foreach ($fields as $field) {
            $str .= 'public $'.$field.";\n    ";
        }

        return $str;
    }

    protected function parseValidationRules()
    {
        $fields = $this->getConfig('validation');
        $str = '';
        foreach ($fields as $key => $field) {
            $str .= $field != end($fields) ? "'$key' => '$field',\n        " : "'$key' => '$field',";
        }

        return $str;
    }

    protected function parseFields()
    {
        $fields = $this->getConfig('fields');
        $str = '';
        foreach ($fields as $key => $field) {
            $str .= $field != end($fields) ?
                "'$key' => ".'$this'."->$key,\n            "
                : "'$key' => ".'$this'."->$key,";
        }

        return $str;
    }

    protected function parseDataInBlade($modelName)
    {
        $fields = $this->getConfig('fields');
        $str = '';
        foreach ($fields as $key => $field) {
            $str .= '<td> $'.$modelName.'->'.$key.' </td>\n';
        }

        return $str;
    }

    protected function parseTitlesInBlade($modelName)
    {
        $fields = $this->getConfig('fields');
        $str = '';
        foreach ($fields as $key => $field) {
            $key = ucfirst($key);
            $str .= "<td> $key </td>\n";
        }

        return $str;
    }
}
