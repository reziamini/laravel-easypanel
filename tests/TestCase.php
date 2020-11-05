<?php


namespace AdminPanelTest;


use AdminPanel\AdminPanelServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    protected function getApplicationProviders($app)
    {
        return [
            AdminPanelServiceProvider::class
        ];
    }
}