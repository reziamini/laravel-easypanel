<?php

namespace EasyPanel\Parsers\HTMLInputs;

class Select
{

    public function handle($name, $values, $action)
    {

        if(!class_exists($values[0])) {
            return "<select wire:model='$name' class=\"form-control @error('$name') is-invalid @enderror\" id='input$name'>
                    @foreach(config('easy_panel.crud.$action.fields.$name')['select'] as " . '$key => $value' . ")
                        <option value='{{ " . '$key' . " }}'>{{ " . '$value' . " }}</option>
                    @endforeach
                </select>";
        }

        return "<select wire:model='$name' class=\"form-control @error('$name') is-invalid @enderror\" id='input$name'>
                    @foreach((new $values[0])->pluck('$values[2]', '$values[1]') as " . '$key => $value' . ")
                        <option value='{{ " . '$key' . " }}'>{{ " . '$value' . " }}</option>
                    @endforeach
                </select>";

    }
}
