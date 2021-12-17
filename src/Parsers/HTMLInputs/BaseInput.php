<?php

namespace EasyPanel\Parsers\HTMLInputs;

abstract class BaseInput
{
    protected $name;
    protected $action;

    public function __construct($name, $action)
    {
        $this->name = $name;
        $this->action = $action;
    }

    public function render()
    {
        $mode = config('easy_panel.lazy_mode') ? 'wire:model.lazy' : 'wire:model';

        $array = [
            '{{ Title }}' => ucfirst($this->name),
            '{{ Name }}' => $this->name,
            '{{ Mode }}' => $mode,
            '{{ Action }}' => $this->action,
        ];

        return str_replace(array_keys($array), array_values($array), file_get_contents(__DIR__.'/stubs/'.$this->stub));
    }

}
