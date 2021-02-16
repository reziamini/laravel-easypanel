<?php

namespace EasyPanel\Parsers\HTMLInputs;

class Textarea
{

    public function handle($name)
    {
        $mode = config('easy_panel.lazy_mode') ? 'wire:model.lazy' : 'wire:model';

        return "<textarea $mode='$name' class=\"form-control @error('$name') is-invalid @enderror\"></textarea>";
    }
}
