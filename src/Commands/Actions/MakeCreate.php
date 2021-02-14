<?php

namespace EasyPanel\Commands\Actions;

class MakeCreate extends CommandBase
{

    use StubParser;

    protected $name = 'panel:create';
    protected $type = 'Create Action';
    protected $file = 'create';
    protected $description = 'Make a create action in CRUD';
    protected $path;

}
