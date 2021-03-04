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
        'select' => Select::class,
        'ckeditor' => Ckeditor::class,
        'checkbox' => Checkbox::class,
    ];

    protected $name;
    protected $type;
    protected $action;

    public function __construct($name, $type, $action)
    {
        $this->name = $name;
        $this->type = $type;
        $this->action = $action;
    }

    public function render(){
        $name = $this->name;

        // Create an instance of input class
        // then call handle() method to get input as a steing
        if(!is_array($this->type)) {
            $inputStringClass = static::classMap[$this->type];
            $input = (new $inputStringClass())->handle($name);
        } else {
            $type = array_key_first($this->type);
            $inputStringClass = static::classMap[$type];
            $inputValues = $this->type[$type];
            $input = (new $inputStringClass())->handle($name, $inputValues, $this->action);
        }

        // render all input element
        if($this->type != 'checkbox') {
            $title = ucfirst($name);
            $str = "
            <!-- $title Input -->
            <div class='form-group'>
                <label for='input$name' class='col-sm-2 control-label'> {{ __('$title') }}</label>
                $input
                @error('$name') <div class='invalid-feedback'>{{ " . '$message' . " }}</div> @enderror
            </div>
            ";
            return $str;
        }

        return $input;
    }
}
