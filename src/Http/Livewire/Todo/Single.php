<?php

namespace EasyPanel\Http\Livewire\Todo;

use EasyPanel\Models\Todo;
use EasyPanel\Support\Contract\TodoFacade;
use Livewire\Component;

class Single extends Component
{

    public $todo;
    public $checked;

    public function mount(Todo $todo)
    {
        $this->todo = $todo;
        $this->checked = $todo->checked;
    }

    public function updatedChecked()
    {
        $this->todo->update([
            'checked' => $this->checked
        ]);
    }

    public function delete()
    {
        $this->todo->delete();
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Todo') ] )]);
        $this->emit('todoDeleted');
    }

    public function render()
    {
        return view('admin::livewire.todo.single')
            ->layout('admin::layouts.app');
    }
}
