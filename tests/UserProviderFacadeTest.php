<?php

namespace EasyPanelTest;

use EasyPanel\Support\Contract\UserProviderFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProviderFacadeTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function find_a_real_user_by_id(){
        $userFoundByFacade = UserProviderFacade::findUser($this->user->id);
        $this->assertEquals($userFoundByFacade->name, $this->user->name);
    }

    /** @test * */
    public function make_an_admin_with_provider(){
        $id = $this->user->id;
        UserProviderFacade::makeAdmin($id);
        $this->assertTrue((bool) $this->user->refresh()->is_superuser);
    }

    /** @test * */
    public function remove_an_admin_with_provider(){
        $id = $this->user->id;
        UserProviderFacade::makeAdmin($id);
        $this->assertTrue((bool) $this->user->refresh()->is_superuser);
        UserProviderFacade::deleteAdmin($id);
        $this->assertFalse((bool) $this->user->refresh()->is_superuser);
    }

    /** @test * */
    public function get_admins_list(){
        $id = $this->user->id;
        UserProviderFacade::makeAdmin($id);
        $adminsId = UserProviderFacade::getAdmins()->pluck('id');
        $this->assertContains($id, $adminsId);
    }
}
