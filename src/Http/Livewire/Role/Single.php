<?php

namespace EasyPanel\Http\Livewire\Role;

use Livewire\Component;
use Iya30n\DynamicAcl\Models\Role;

class Single extends Component
{

    public $role;

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function delete()
    {
        // sync users to []
        // $this->role->delete();

        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Todo') ] )]);
        $this->emit('roleUpdated');
    }

    public function render()
    {
        return view('admin::livewire.role.single')
            ->layout('admin::layouts.app');
    }
}
