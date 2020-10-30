<?php

namespace AdminPanel\Http\Livewire\Todo;

use AdminPanel\Models\Todo;
use Livewire\Component;

class Create extends Component
{

    public $title;

    protected $rules = [
        'title' => 'required|min:8|unique:todos',
    ];

    public function mount()
    {
        //dd(';das');
    }

    public function updatedTitle()
    {
        $this->validateOnly('title');
    }

    public function create()
    {
        $this->validate();
        $this->emit('todoCreated');
        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => 'TODO was created.']);

        Todo::create([
            'title' => $this->title,
            'user_id' => auth()->user()->id
        ]);
        $this->reset();

    }

    public function render()
    {
        return view('admin::livewire.todo.create')
            ->layout('admin::layouts.app');
    }
}
