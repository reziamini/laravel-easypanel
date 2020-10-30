<?php

use AdminPanel\Http\Livewire\TestCrud;
use Illuminate\Support\Facades\Route;

Route::view('/', "admin::test")->name('home');

Route::post('/logout', function (){
    auth()->logout();
    return redirect(config('admin_panel.redirect_unauthorized'));
})->name('logout');

foreach (config('admin_panel.actions') as $prefix => $value){
    Route::get($prefix, TestCrud::class)->name($prefix);
}

if(config('admin_panel.todo')){
    Route::prefix('todo')->group(function (){
        Route::get('/', \AdminPanel\Http\Livewire\Todo\Lists::class);
        Route::get('/create', \AdminPanel\Http\Livewire\Todo\Create::class);
    });
}
