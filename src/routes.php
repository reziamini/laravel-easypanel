<?php

use Illuminate\Support\Facades\Route;

Route::view('/', "admin::home")->name('home');

Route::post('/logout', function (){
    auth()->logout();
    return redirect(config('easy_panel.redirect_unauthorized'));
})->name('logout');

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
