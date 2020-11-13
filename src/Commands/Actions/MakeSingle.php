<?php


namespace EasyPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;

class MakeSingle extends GeneratorCommand
{

    use StubParser, CommandParser;

    protected $name = 'crud:single';
    private $file = 'single';
    private $path;

}
