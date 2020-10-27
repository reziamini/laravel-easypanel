<?php

use AdminPanel\Http\Livewire\TestCrud;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return "hello";
})->name('home');

foreach (config('admin_panel.actions') as $prefix => $value){
    Route::get($prefix, TestCrud::class)->name($prefix);
}
