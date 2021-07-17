<?php

namespace EasyPanel\Http\Livewire\CRUD;

use Livewire\Component;
use EasyPanel\Models\CRUD;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class Create extends Component
{

    public $model;
    public $route;

    protected $rules = [
        'model' => 'required|min:8|unique:cruds',
        'route' => 'required|min:2|unique:cruds',
    ];

    public function updated($input)
    {
        $this->validateOnly($input);
    }

    public function create()
    {
        $this->validate();

        if (!class_exists($this->model) or ! app()->make($this->model) instanceof Model){
            $this->addError('model', __('Namespace is invalid'));

            return;
        }

        if (!preg_match('/^([a-z]|[0-9])+/', $this->route)){
            $this->addError('route', __('Route is invalid'));

            return;
        }

        try{
            $name = strtolower($this->getModelName($this->model));
            CRUD::create([
                'model' => trim($this->model, '\\'),
                'name' => $name,
                'route' => trim($this->route, '\\'),
            ]);

            Artisan::call('panel:config', [
                'name' => $name,
                '--force' => true
            ]);

            $this->dispatchBrowserEvent('show-message', ['type' => 'success', 'message' => __('CreatedMessage', ['name' => __('CRUD') ])]);
        } catch(\Exception $exception){
            $this->dispatchBrowserEvent('show-message', ['type' => 'error', 'message' => __('UnknownError') ]);
        }


        $this->emit('crudUpdated');
        $this->reset();
    }

    public function render()
    {
        return view('admin::livewire.crud.create')
            ->layout('admin::layouts.app');
    }

    private function getModelName($model){
        $model = explode('\\', $model);

        return end($model);
    }
}
