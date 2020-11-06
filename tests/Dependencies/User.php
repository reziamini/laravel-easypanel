<?php


namespace AdminPanelTest\Dependencies;
use Orchestra\Testbench\Concerns\WithFactories;

class User extends \Illuminate\Foundation\Auth\User
{
    use WithFactories;
    protected $fillable = ['name', 'email', 'is_superuser'];
}