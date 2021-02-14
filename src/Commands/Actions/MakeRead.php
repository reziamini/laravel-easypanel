<?php


namespace EasyPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;

class MakeRead extends CommandBase
{

    use StubParser;

    protected $name = 'panel:read';
    protected $type = 'Read Action';
    protected $file = 'read';
    protected $description = 'Make a read action in CRUD';
    protected $path;

}
