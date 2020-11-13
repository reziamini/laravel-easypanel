<?php


namespace EasyPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;

class MakeCreate extends GeneratorCommand
{

    use StubParser, CommandParser;

    protected $name = 'crud:create';
    protected $type = 'Create Action';
    protected $file = 'create';
    private $path;

}
