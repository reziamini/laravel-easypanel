<?php

namespace EasyPanel\Http\Livewire\CRUD;

use EasyPanel\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;
use EasyPanel\Models\CRUD;

class Lists extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['crudUpdated'];

    public function crudUpdated()
    {
        // There is nothing to do, just update It.
    }

    public function render()
    {
        $cruds = CRUD::query()
            ->paginate(20);

        return view('admin::livewire.crud.lists', compact('cruds'))
            ->layout('admin::layouts.app');
    }
}
