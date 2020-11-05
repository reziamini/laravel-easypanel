<?php


namespace AdminPanel\Commands;


use AdminPanel\Support\Contract\UserProviderFacade;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{

    protected $description = 'register a new admin';

    protected $signature = 'make:admin {user}';

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
