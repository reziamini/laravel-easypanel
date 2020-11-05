<?php


namespace AdminPanelTest;


use AdminPanel\Http\Livewire\Todo\Create;
use AdminPanel\Http\Livewire\Todo\Single;
use AdminPanel\Models\Todo;
use Livewire\Livewire;

class TodoListTest extends TestCase
{

    /** @test * */
    public function todo_create(){
        Livewire::test(Create::class)
            ->set('title', 'I should create a article about PHP')
            ->call('create');

        $this->assertDatabaseHas('todos', ['title' => 'I should create a article about PHP']);

        Livewire::test(Create::class)
            ->set('title', 'I should create a article about PHP')
            ->call('create')
            ->assertHasErrors(['title' => 'unique']);
    }

    /** @test * */
    public function todo_checked(){
        $todo = Todo::create([
            'title' => 'daassaassa',
            'user_id' => 1,
        ]);

        Livewire::test(Single::class, ['todo' => $todo])
            ->set('checked', true);

        $this->assertTrue(Todo::query()->where('id', $todo->id)->where('checked', true)->exists());

        Livewire::test(Single::class, ['todo' => $todo])
            ->set('checked', false);

        $this->assertTrue(Todo::query()->where('id', $todo->id)->where('checked', false)->exists());
    }

    /** @test * */
    public function remove_todo(){
        $todo = Todo::create([
            'title' => 'daassaassa',
            'user_id' => 1,
        ]);

        Livewire::test(Single::class, ['todo' => $todo])
            ->set('checked', true)
            ->call('delete')
            ->assertDispatchedBrowserEvent('show-message');

        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}
