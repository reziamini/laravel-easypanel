<?php

use Illuminate\Support\Facades\Route;

Route::view('/', "admin::home")->name('home');

Route::post('/logout', function (){
    auth()->logout();
    return redirect(config('easy_panel.redirect_unauthorized'));
})->name('logout');


function registerActionRoutes($action, $component, $crudConfig)
{
    Route::prefix($action)->name("$action.")->group(function () use ($component, $crudConfig, $action) {

        if(class_exists("$component\\Read")) {
            Route::get('/', "$component\\Read")->name('read');
        }

        if ($crudConfig['create'] and class_exists("$component\\Create")) {
            Route::get('/create', "$component\\Create")->name('create');
        }

        if ($crudConfig['update'] and class_exists("$component\\Update")) {
            Route::get('/update/{' . $action . '}', "$component\\Update")->name('update');
        }

    });
}

foreach (config('easy_panel.actions') as $action){
    $crudConfig = config('easy_panel.crud.'.$action);
    $name = ucfirst($action);
    $component = "App\\Http\\Livewire\\Admin\\$name";
    registerActionRoutes($action, $component, $crudConfig);
}

if(config('easy_panel.todo')){
    Route::prefix('todo')->name('todo.')->group(function (){
        Route::get('/', \EasyPanel\Http\Livewire\Todo\Lists::class)->name('lists');
        Route::get('/create', \EasyPanel\Http\Livewire\Todo\Create::class)->name('create');
    });
}
