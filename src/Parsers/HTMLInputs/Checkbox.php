<?php

namespace EasyPanel\Parsers\HTMLInputs;

class Checkbox
{

    public function handle($name)
    {
        $mode = config('easy_panel.lazy_mode') ? 'wire:model.lazy' : 'wire:model';
        $UName = ucfirst($name);
        return "
            <!-- $UName Input -->
            <div class='form-group'>
                <div class='form-check mt-4 mb-3'>
                    <input $mode='$name' class='form-check-input' type='checkbox' id='input$name'>
                    <label class='form-check-label' for='input$name'>{{ __('$UName') }}</label>
                </div>
                @error('$name') <div class='invalid-feedback'>{{ " . '$message' . " }}</div> @enderror
            </div>
            ";
    }
}
