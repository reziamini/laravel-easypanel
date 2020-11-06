<?php


namespace EasyPanel\Commands;


use EasyPanel\Support\Contract\UserProviderFacade;
use Illuminate\Console\Command;

class DeleteAdmin extends Command
{

    protected $signature = 'delete:admin {user} {--f|force}';

    protected $description = 'Delete a admin with user id';

    public function handle()
    {
        $user = $this->argument('user');

        if($this->askResult($user)){
            UserProviderFacade::deleteAdmin($user);
            $this->info('Admin was removed successfully');
        } else {
            $this->warn('Process was canceled');
        }
    }

    public function askResult($user)
    {
        if($this->option('force')) {
            return true;
        }
        $result = $this->confirm("Do you want to remove {$user} from administration", 'yes');
        return $result;
    }
}
