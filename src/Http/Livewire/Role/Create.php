<?php

namespace EasyPanel\Http\Livewire\Role;

use Livewire\Component;
use Iya30n\DynamicAcl\ACL;
use Iya30n\DynamicAcl\Models\Role;

class Create extends Component
{
    public $name, $access;

    protected $rules = [
        'name' => 'required|min:3|unique:roles',
        'access' => 'required'
    ];

    public function updatingArray($value, $key)
    {
        // if ($key == 'access')

    }

    public function create()
    {
        $this->validate();

        dd($this->name, $this->access);

        Role::create(['name' => $this->name, 'permissions' => $this->access]);

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Role') ])]);

        try {
            Role::create(['name' => $this->name, 'permissions' => $this->access]);

            $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Role') ])]);
        } catch (\Exception $exception){
            $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => $exception->getMessage()]);
        }

        $this->reset();
    }

    public function render()
    {
        $permissions = ACL::getRoutes();

        return view('admin::livewire.role.create', compact('permissions'))
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Role') ])]);
    }
}
