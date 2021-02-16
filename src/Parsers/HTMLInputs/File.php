<?php

namespace EasyPanel\Parsers\HTMLInputs;

class File
{

    public function handle($name)
    {
        return "<input type='file' wire:model='$name' class=\"form-control-file @error('$name') is-invalid @enderror\" id='input$name'>";
    }
}
