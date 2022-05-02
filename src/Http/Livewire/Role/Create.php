<?php

namespace EasyPanel\Http\Livewire\Role;

use Livewire\Component;
use Iya30n\DynamicAcl\ACL;
use Iya30n\DynamicAcl\Models\Role;

class Create extends Component
{
    public $name;

    public $permissionsData = [];

    public $access = [];

    public $selectedAll = [];

    protected $rules = [
        'name' => 'required|min:3|unique:roles',
        'access' => 'required'
    ];

    private function fixAccessKeys()
    {
        foreach($this->access as $key => $value) {
            unset($this->access[$key]);
            $key = str_replace('-', '.', $key);
            $this->access[$key] = is_array($value) ? array_filter($value) : $value;
        }

        return $this->access;
    }

    /** 
     * this method checks if whole checkboxes checked, set value true for SelectAll checkbox
     * 
     * @param string $key
     * 
     * @param string $dashKey
     */
    public function checkSelectedAll($key, $dashKey)
    {
        $selectedRoutes = array_filter($this->access[$dashKey]);

        // we don't have delete route in cruds but we have a button for it. that's why i added 1
        if(count($selectedRoutes) == count($this->permissionsData[$key]) + 1)
            $this->selectedAll[$dashKey] = true;
        else
            unset($this->selectedAll[$dashKey]);
    }

    public function create()
    {
        $this->validate();

        try {
            Role::create(['name' => $this->name, 'permissions' => $this->fixAccessKeys()]);

            $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('Role') ])]);
        } catch (\Exception $exception){
            $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => $exception->getMessage()]);
        }

        $this->reset();
    }

    public function render()
    {
        $permissions = ACL::getRoutes();

        $this->permissionsData = $permissions;

        return view('admin::livewire.role.create', compact('permissions'))
            ->layout('admin::layouts.app', ['title' => __('CreateTitle', ['name' => __('Role') ])]);
    }
}
