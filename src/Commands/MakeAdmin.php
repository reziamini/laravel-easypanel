<?php


namespace EasyPanel\Commands;


use EasyPanel\Support\Contract\UserProviderFacade;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{

    protected $description = 'Register an new admin';

    protected $signature = 'panel:add {user}';

    public function handle()
    {
        $user = $this->argument('user');
        try{
            UserProviderFacade::makeAdmin($user);
            $this->info("User {$user} was converted to an admin");
        } catch (\Exception $exception){
            $this->error("User {$user} does not exist");
        }
    }

}
