<?php

namespace EasyPanel\Parsers\HTMLInputs;

class Select
{

    public function handle($name, $values, $action)
    {
        return "<select wire:model='$name' class=\"form-control @error('$name') is-invalid @enderror\" id='input$name'>
                @foreach(config('easy_panel.crud.$action.fields.$name')['select'] as " . '$key => $value' . ")
                    <option value='{{ " . '$key' . " }}'>{{ " . '$value' . " }}</option>
                @endforeach
            </select>";
    }
}
