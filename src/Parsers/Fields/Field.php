<?php


namespace EasyPanel\Parsers\Fields;


class Field
{
    protected $title;
    protected $model;
    protected $key;
    protected $style;
    protected $alt;
    protected $badgeType = 'info';
    protected $stub = 'text.stub';
    protected $height = 50;
    protected $width = 50;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public static function title($title)
    {
        return new static($title);
    }

    public function style($style)
    {
        $this->style = $style;

        return $this;
    }

    public function asImage()
    {
        $this->stub = 'image.stub';

        return $this;
    }

    public function asBadge()
    {
        $this->stub = 'badge.stub';

        return $this;
    }

    public function alt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    public function height($height)
    {
        $this->height = $height;

        return $this;
    }

    public function width($width)
    {
        $this->height = $width;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function badgeType($type)
    {
        $this->badgeType = $type;

        return $this;
    }

    public function roundedBadge()
    {
        $this->style .= ' badge-pill ';

        return $this;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function renderTitle()
    {
        $stubContent = $this->getTitleStubContent();

        $array = [
            '{{ key }}' => $this->key,
            '{{ title }}' => $this->title
        ];

        return str_replace(array_keys($array), array_values($array), $stubContent);
    }

    public function renderData()
    {
        $stubContent = $this->getDataStubContent();

        $array = [
            '{{ key }}' => $this->parseRelationalKey($this->key),
            '{{ model }}' => $this->model,
            '{{ height }}' => $this->height,
            '{{ width }}' => $this->width,
            '{{ style }}' => $this->style,
            '{{ alt }}' => $this->alt,
            '{{ badgeType }}' => $this->badgeType,
        ];

        return str_replace(array_keys($array), array_values($array), $stubContent);
    }

    private function getDataStubContent()
    {
        return file_get_contents(__DIR__.'/stubs/'.$this->stub);
    }

    private function getTitleStubContent()
    {
        if ($this->isRelational()){
            return file_get_contents(__DIR__.'/stubs/titles/relational.stub');
        }

        return file_get_contents(__DIR__.'/stubs/titles/normal.stub');
    }

    private function isRelational()
    {
        return \Str::contains($this->key, '.');
    }

    private function parseRelationalKey($key){
        return str_replace('.', '->', $key);
    }

}
