<?php

use Illuminate\Support\Facades\Route;

Route::view('/', "admin::home")->name('home');

Route::post('/logout', function (){
    auth()->logout();
    return redirect(config('easy_panel.redirect_unauthorized'));
})->name('logout');

if (\Illuminate\Support\Facades\Schema::hasTable('cruds')) {
    foreach (\EasyPanel\Models\CRUD::active() as $crud) {
        $crudConfig = getCrudConfig($crud->name);
        $name = ucfirst($crud->name);
        $component = "App\\Http\\Livewire\\Admin\\$name";

        Route::prefix($crud->route)->name("{$crud->route}.")->group(function () use ($component, $crud, $crudConfig) {

            if (@class_exists("$component\\Read")) {
                Route::get('/', "$component\\Read")->name('read');
            }

            if (@$crudConfig->create and @class_exists("$component\\Create")) {
                Route::get('/create', "$component\\Create")->name('create');
            }

            if (@$crudConfig->update and @class_exists("$component\\Update")) {
                Route::get('/update/{' . $crud->name . '}', "$component\\Update")->name('update');
            }

        });
    }
}

if(config('easy_panel.todo')){
    Route::prefix('todo')->name('todo.')->group(function (){
        Route::get('/', \EasyPanel\Http\Livewire\Todo\Lists::class)->name('lists');
        Route::get('/create', \EasyPanel\Http\Livewire\Todo\Create::class)->name('create');
    });
}

Route::prefix('crud')->name('crud.')->group(function (){
    Route::get('/', \EasyPanel\Http\Livewire\CRUD\Lists::class)->name('lists');
});
