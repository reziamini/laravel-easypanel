<?php

namespace EasyPanel\Http\Livewire\Admins;

use Livewire\Component;

class Single extends Component
{

    public $admin;

    public function mount(/* Role */ $admin)
    {
        $this->admin = $admin;
    }

    public function delete()
    {
        /* $this->role->users()->sync([]);
        
        $this->role->delete();

        $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('DeletedMessage', ['name' => __('Role') ] )]);
        $this->emit('roleUpdated'); */
    }

    public function render()
    {
        return view('admin::livewire.admins.single')
            ->layout('admin::layouts.app');
    }
}
