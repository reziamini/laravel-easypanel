<?php

namespace EasyPanel\Http\Livewire\Role;

use Iya30n\DynamicAcl\ACL;
use Iya30n\DynamicAcl\Models\Role;
use Livewire\Component;

class Update extends Component
{
    public $role;

    public $name;

    public $access = [];

    protected $rules = [
        'name' => 'min:3'
    ];

    public function mount(Role $role)
    {
        $this->role = $role;

        $this->name = $role->name;

        $this->access = $this->replaceArrayKeys($role->permissions, '.', '-');
    }

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function update()
    {
        if ($this->getRules())
            $this->validate();

        if ($this->role->is_super_admin()) {
            $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('CannotUpdateMessage', ['name' => __('Role')])]);
            return;
        }

        $this->role->update([
            'name' => $this->name,
            'permissions' => $this->replaceArrayKeys($this->access, '-', '.')
        ]);

        $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('UpdatedMessage', ['name' => __('Role')])]);
    }

    public function render()
    {
        return view('admin::livewire.role.update', [
            'role' => $this->role,
            'permissions' => ACL::getRoutes(),
        ])->layout('admin::layouts.app', ['title' => __('UpdateTitle', ['name' => __('Role')])]);
    }

    private function replaceArrayKeys($permissions, $from, $to)
    {
        foreach($permissions as $key => $value) {
            unset($permissions[$key]);
            $key = str_replace($from, $to, $key);
            $value = is_array($value) ? array_filter($value) : $value;

            if (empty($value))
                continue;

            $permissions[$key] = $value;
        }

        return $permissions;
    }
}
