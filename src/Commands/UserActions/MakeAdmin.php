<?php

namespace EasyPanel\Commands\UserActions;

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
            $status = UserProviderFacade::makeAdmin($user);
            if($status){
                $this->info("User {$user} was converted to an admin");
                return;
            }
            $this->warn("It was failed, be sure your column is fillable.");
        } catch (\Exception $exception){
            $this->error("User {$user} does not exist");
        }
    }

}
