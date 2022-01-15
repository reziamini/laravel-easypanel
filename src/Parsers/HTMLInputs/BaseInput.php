<?php

namespace EasyPanel\Parsers\HTMLInputs;

abstract class BaseInput
{
    protected $key;
    protected $action;
    protected $mode;
    protected $label;
    protected $placeholder;

    public function __construct($label)
    {
        $this->label = $label;
        $this->mode = config('easy_panel.lazy_mode') ? 'wire:model.lazy' : 'wire:model';
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function placeholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public static function label($label)
    {
        return new static($label);
    }

    public function lazyMode()
    {
        $this->mode = 'wire:model.lazy';

        return $this;
    }

    public function deferMode()
    {
        $this->mode = 'wire:model.defer';

        return $this;
    }

    public function render()
    {
        $array = [
            '{{ Title }}' => $this->label,
            '{{ Name }}' => $this->key,
            '{{ Mode }}' => $this->mode,
            '{{ Action }}' => $this->action,
            '{{ placeholder }}' => $this->placeholder,
        ];

        return str_replace(array_keys($array), array_values($array), file_get_contents(__DIR__.'/stubs/'.$this->stub));
    }

    public function getTitle()
    {
        return $this->label;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

}
