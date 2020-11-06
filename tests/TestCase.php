<?php

namespace EasyPanelTest;

use EasyPanel\EasyPanelServiceProvider;
use EasyPanelTest\Dependencies\User;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/Dependencies/database/migrations');
        $this->withFactories(__DIR__.'/Dependencies/database/factories');
        $this->user = factory(User::class)->create(['is_superuser' => false]);
        config()->set('easy_panel.user_model', User::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            EasyPanelServiceProvider::class
        ];
    }
}