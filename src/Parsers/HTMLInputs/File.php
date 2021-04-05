<?php

namespace EasyPanel\Parsers\HTMLInputs;

class File
{

    public function handle($name)
    {
        $string = '$'.$name;
        return "<input type='file' wire:model='$name' class=\"form-control-file @error('$name') is-invalid @enderror\" id='input$name'>
                @if($string and !".'$errors'."->has('$name') and $string instanceof \Livewire\TemporaryUploadedFile and (in_array( ".$string."->guessExtension(), ['png', 'jpg', 'gif', 'jpeg'])))
                    <a href=\"{{ ".$string."->temporaryUrl() }}\"><img width=\"200\" height=\"200\" class=\"img-fluid shadow\" src=\"{{ ".$string."->temporaryUrl() }}\" alt=\"\"></a>
                @endif";
    }
}
