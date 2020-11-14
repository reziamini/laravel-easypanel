<?php


namespace EasyPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;

class MakeCreate extends GeneratorCommand
{

    use StubParser, CommandParser;

    protected $name = 'panel:create';
    protected $type = 'Create Action';
    protected $file = 'create';
    protected $description = 'Make a create action in CRUD';
    private $path;

}
