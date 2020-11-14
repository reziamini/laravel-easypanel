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

    protected $name = 'crud:read';
    protected $type = 'Read Action';
    protected $file = 'read';
    private $path;

    public function handle()
    {
        $this->Handler();

        Artisan::call('crud:single', [
            'name' => $this->getNameInput()
        ]);
    }
}
