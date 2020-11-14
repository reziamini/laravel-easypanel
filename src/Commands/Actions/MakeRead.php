<?php


namespace EasyPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;

class MakeRead extends GeneratorCommand
{

    use StubParser;
    use CommandParser {
        handle as Handler;
    }

    protected $name = 'panel:read';
    protected $type = 'Read Action';
    protected $file = 'read';
    protected $description = 'Make a read action in CRUD';
    private $path;

    public function handle()
    {
        $this->Handler();

        Artisan::call('panel:single', [
            'name' => $this->getNameInput()
        ]);
    }
}
