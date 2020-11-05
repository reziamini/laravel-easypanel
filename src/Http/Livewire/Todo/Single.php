<?php

namespace AdminPanel\Http\Livewire\Todo;

use AdminPanel\Models\Todo;
use AdminPanel\Support\Contract\TodoFacade;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\WithPagination;

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
        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => 'TODO was deleted.']);
        $this->emit('todoDeleted');
    }

    public function render()
    {
        return view('admin::livewire.todo.single')
            ->layout('admin::layouts.app');
    }
}
