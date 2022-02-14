<?php


namespace EasyPanel\Concerns;


use EasyPanel\Services\LangManager;

trait Translatable
{
    protected $texts = [];

    public function addText($text, $key = null)
    {
        if (array_key_exists($key, $this->texts)){
            return;
        }

        $this->texts[$key ?? $text] = $text;
    }

    public function translate()
    {
        LangManager::update($this->texts);
    }

    public function getTexts()
    {
        return $this->texts;
    }
}
