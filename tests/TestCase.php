<?php

namespace EasyPanelTest;

use EasyPanel\EasyPanelServiceProvider;
use EasyPanelTest\Dependencies\User;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Livewire\LivewireServiceProvider;

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
        $this->setUser();
        config()->set('easy_panel.user_model', User::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            EasyPanelServiceProvider::class,
            LivewireServiceProvider::class
        ];
    }


    protected function setUser()
    {
        $faker = Factory::create();
        $user = User::create(['name' => $faker->name, 'password' => Hash::make('password'), 'is_superuser' => false]);
        $this->user = $user;
    }
}
