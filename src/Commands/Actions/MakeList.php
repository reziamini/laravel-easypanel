<?php


namespace EasyPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;

class MakeList extends GeneratorCommand
{

    use StubParser;
    use CommandParser {
        handle as Handler;
    }

    protected $name = 'crud:list';
    protected $type = 'List Action';
    protected $file = 'lists';
    private $path;

    public function handle()
    {
        $this->Handler();

        Artisan::call('crud:single', [
            'name' => $this->getNameInput()
        ]);
    }
}
