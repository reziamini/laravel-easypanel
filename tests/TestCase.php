<?php

namespace AdminPanelTest;

use AdminPanel\AdminPanelServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/Dependencies/database/migrations');
        $this->withFactories(__DIR__.'/Dependencies/database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            AdminPanelServiceProvider::class
        ];
    }
}