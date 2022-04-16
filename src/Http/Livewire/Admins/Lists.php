<?php

namespace EasyPanel\Http\Livewire\Admins;

use EasyPanel\Support\Contract\UserProviderFacade;
use Livewire\Component;
use Livewire\WithPagination;
use Iya30n\DynamicAcl\Models\Role;

class Lists extends Component
{
    // use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // protected $listeners = ['adminUpdated'];

    public function roleUpdated()
    {
        // There is nothing to do, just update It.
    }

    public function render()
    {
        $admins = UserProviderFacade::getAdmins();

        dd($admins->first()->getFillable());

        /* dd($admins);
        $roles = Role::query()
            ->paginate(20); */

        return view('admin::livewire.admins.lists', compact('admins'))
            ->layout('admin::layouts.app', ['title' => __('ListTitle', ['name' => __('Admins')])]);
    }
}
