<?php

namespace EasyPanel\Parsers\HTMLInputs;

class BaseInput
{

    const classMap = [
        'password' => Password::class,
        'text' => Text::class,
        'file' => File::class,
        'email' => Email::class,
        'number' => Number::class,
        'textarea' => Textarea::class,
        'ckeditor' => Ckeditor::class
    ];

    protected $name;
    protected $type;

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function render(){
        $name = $this->name;

        // Create an instance of input class
        // then call handle() method to get input as a steing
        $inputStringClass = static::classMap[$this->type];
        $input = (new $inputStringClass())->handle($name);

        // render all input element
        $title = ucfirst($this->name);
        $str = "
            <!-- $title Input -->
            <div class='form-group'>
                <label for='input$name' class='col-sm-2 control-label'> {{ __('$title') }}</label>
                $input
                @error('$name') <div class='invalid-feedback'>{{ ".'$message'." }}</div> @enderror
            </div>
            ";

        return $str;
    }
}
