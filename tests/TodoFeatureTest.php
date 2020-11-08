<?php

namespace EasyPanelTest;

use EasyPanel\Http\Livewire\Todo\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class TodoFeatureTest extends TestCase
{

    use RefreshDatabase;

    /** @test * */
    public function make_a_todo_successfully(){
        $this->actingAs($this->user);

        Livewire::test(Create::class)
            ->set('title', 'Contributing in')
            ->call('create');

        $this->assertDatabaseHas('todos', ['title' => 'Contributing in']);
    }
}