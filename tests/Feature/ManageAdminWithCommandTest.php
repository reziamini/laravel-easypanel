<?php

namespace EasyPanelTest\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use EasyPanelTest\TestCase;

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

}
