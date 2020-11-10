<?php

namespace EasyPanelTest;

use EasyPanel\Http\Livewire\Todo\Create;
use EasyPanel\Models\Todo;
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
            ->call('create')
            ->assertDispatchedBrowserEvent('show-message');
        $this->assertDatabaseHas('todos', ['title' => 'Contributing in']);

        Livewire::test(Create::class)
            ->set('title', 'Contributing in')
            ->call('create');
        $this->assertCount(1, Todo::all());
    }

    /** @test * */
    public function create_with_empty_title(){
        $this->actingAs($this->user);

        Livewire::test(Create::class)
            ->set('title', '')
            ->call('create')
            ->assertHasErrors('title');
    }

}