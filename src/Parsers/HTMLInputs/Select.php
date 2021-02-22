<?php

namespace EasyPanel\Parsers\HTMLInputs;

class Select
{

    public function handle($name, $values)
    {
        $string = '';
        foreach ($values as $key => $value) {
            $string .= "<option value='$key'>$value</option>\n                    ";
        }

        return "<select wire:model='$name' class=\"form-control @error('$name') is-invalid @enderror\" id='input$name'>
                    $string
                </select>";
    }
}
