<?php

namespace EasyPanel\Parsers\HTMLInputs;

class Number
{

    public function handle($name)
    {
        $mode = config('easy_panel.lazy_mode') ? 'wire:model.lazy' : 'wire:model';

        return "<input type='number' $mode='$name' class=\"form-control @error('$name') is-invalid @enderror\" id='input$name'>";
    }
}
