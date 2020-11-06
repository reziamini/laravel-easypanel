<?php

namespace EasyPanel\Http\Livewire\Todo;

use EasyPanel\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;

class Lists extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['todoDeleted', 'todoCreated', 'todoChecked'];

    public function todoDeleted()
    {
        // There is nothing to do, just update It.
    }
    public function todoCreated()
    {
        // There is nothing to do, just update It.
    }
    public function todoChecked()
    {
        // There is nothing to do, just update It.
    }

    public function render()
    {
        $todos = Todo::query()
            ->where('user_id', auth()->user()->id)
            ->orderBy('checked', 'ASC')
            ->paginate(15);

        return view('admin::livewire.todo.lists', compact('todos'))
            ->layout('admin::layouts.app');
    }
}
