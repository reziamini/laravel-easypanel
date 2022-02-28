<?php

namespace EasyPanelTest\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use EasyPanelTest\TestCase;
use EasyPanel\Support\Contract\UserProviderFacade;

class ManageAdminWithCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function create_admin_with_command(){
        Artisan::call('panel:add', [
            'user' => $this->user->id
        ]);

        $this->assertTrue( (bool) $this->user->panelAdmin()->exists());
    }

    /** @test * */
    public function remove_admin_with_command(){
        Artisan::call('panel:add', [
            'user' => $this->user->id
        ]);

        Artisan::call('panel:remove', [
            'user' => $this->user->id,
            '--force' => true
        ]);

        $this->assertFalse( (bool) $this->user->panelAdmin()->exists());
    }

    /** @test * */
    public function all_admins_is_listed(){
        Artisan::call('panel:add', [
            'user' => $this->user->id
        ]);

        $this->artisan('panel:admins')
            ->expectsOutput("• {$this->user->name}: {$this->user->email}");
    }

    /** @test * */
    public function all_super_users_are_returned(){
        Artisan::call('panel:add', [
            'user' => $this->user->id,
            '--super' => true
        ]);

        $this->artisan('panel:admins')
            ->expectsOutput("• {$this->user->name}: {$this->user->email} ( Super Admin ✅ )");
    }

}
