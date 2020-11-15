<?php

namespace EasyPanelTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

class ManageAdminWithCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function create_admin_with_command(){
        Artisan::call('panel:add', [
            'user' => $this->user->id
        ]);

        $this->assertTrue( (bool) $this->user->refresh()->is_superuser);
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

        $this->assertFalse( (bool) $this->user->refresh()->is_superuser);
    }

}
