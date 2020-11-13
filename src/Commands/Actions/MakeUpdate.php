<?php

namespace EasyPanel\Commands\Actions;

use Illuminate\Console\GeneratorCommand;

class MakeUpdate extends GeneratorCommand
{

    use StubParser, CommandParser;

    protected $name = 'crud:update';
    private $file = 'update';
    protected $type = 'Update Action';
    private $path;

}
