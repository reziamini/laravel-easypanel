<?php

namespace EasyPanel\Commands\Actions;

class MakeUpdate extends CommandBase
{

    use StubParser;

    protected $name = 'panel:update';
    protected $file = 'update';
    protected $type = 'Update Action';
    protected $description = 'Make a update action in CRUD';
    protected $path;

}
