<?php

namespace EasyPanel\Parsers\HTMLInputs;

class Text
{

    public function handle($name)
    {
        $mode = config('easy_panel.lazy_mode') ? 'wire:model.lazy' : 'wire:model';

        return "<input type='text' $mode='$name' class=\"form-control @error('$name') is-invalid @enderror\" id='input$name'>";
    }
}
