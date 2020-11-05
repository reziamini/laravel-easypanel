<?php


namespace AdminPanelTest;


use AdminPanel\Support\Contract\AuthFacade;

class RouteDefinedTest extends TestCase
{

    /** @test **/
    public function user_is_admin()
    {
        AuthFacade::shouldReceive('checkIsAdmin')->once()->andReturn(true);
        $this->assertTrue($this->get(route('admin.home'))->status() == 200);
    }

    /** @test * */
    public function user_is_not_admin(){
        AuthFacade::shouldReceive('checkIsAdmin')->once()->andReturn(false);
        $this->assertTrue($this->get(route('admin.home'))->status() == 302);
    }

}
