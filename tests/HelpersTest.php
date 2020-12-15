<?php


namespace EasyPanelTest;


class HelpersTest extends TestCase
{

    /** @test * */
    public function get_icon_helper_works(){
        $this->assertEquals(get_icon('user'), 'users');
        $this->assertEquals(get_icon('users'), 'users');
        $this->assertEquals(get_icon('admin'), 'users');
        $this->assertEquals(get_icon('article'), 'file-text');
        $this->assertEquals(get_icon('articles'), 'file-text');
        $this->assertEquals(get_icon('posts'), 'file-text');
        $this->assertEquals(get_icon('xxxx'), 'grid');
    }

    /** @test * */
    public function get_route_name_works(){
        config()->set('easy_panel.route_prefix', 'admin');
        $this->assertEquals(getRouteName(), 'admin');
        config()->set('easy_panel.route_prefix', '/admin');
        $this->assertEquals(getRouteName(), 'admin');
        config()->set('easy_panel.route_prefix', 'admin/');
        $this->assertEquals(getRouteName(), 'admin');
        config()->set('easy_panel.route_prefix', '/admin/');
        $this->assertEquals(getRouteName(), 'admin');
        config()->set('easy_panel.route_prefix', 'admin/panel/');
        $this->assertEquals(getRouteName(), 'admin.panel');
        config()->set('easy_panel.route_prefix', 'admin/panel/dashboard//');
        $this->assertEquals(getRouteName(), 'admin.panel.dashboard');
    }

}
