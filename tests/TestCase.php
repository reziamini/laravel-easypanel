<?php

namespace AdminPanelTest;

use AdminPanel\AdminPanelServiceProvider;
use AdminPanelTest\Dependencies\User;

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
        config()->set('admin_panel.user_model', User::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            AdminPanelServiceProvider::class
        ];
    }
}