<?php

use Illuminate\Support\Facades\Route;

Route::view('/', "admin::home")->name('home');

Route::post('/logout', function (){
    auth()->logout();
    return redirect(config('easy_panel.redirect_unauthorized'));
})->name('logout');

foreach (config('easy_panel.actions') as $prefix => $value){
    $name = ucfirst($prefix);
    $livewireNamespace = "App\\Http\\Livewire\\Admin\\$name";
    Route::prefix($prefix)->name($prefix.'.')->group(function () use ($livewireNamespace, $value, $prefix){
        Route::get('/',  $livewireNamespace."\\Lists")->name('lists');
        if($value['create']){
            Route::get('/create', $livewireNamespace."\\Create")->name('create');
        }
        if($value['update']){
            Route::get('/update/{'.$prefix.'}',  $livewireNamespace."\\Update")->name('update');
        }
    });
}

if(config('easy_panel.todo')){
    Route::prefix('todo')->name('todo.')->group(function (){
        Route::get('/', \EasyPanel\Http\Livewire\Todo\Lists::class)->name('lists');
        Route::get('/create', \EasyPanel\Http\Livewire\Todo\Create::class)->name('create');
    });
}
