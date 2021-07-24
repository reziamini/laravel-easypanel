<?php

namespace EasyPanel\Http\Livewire\CRUD;

use Livewire\Component;
use EasyPanel\Models\CRUD;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Create extends Component
{
    public $model;
    public $route;
    public $models;
    public $dropdown;

    protected $rules = [
        'model' => 'required|min:8|unique:cruds',
        'route' => 'required|min:2|unique:cruds',
    ];

    public function setModel()
    {
        $this->models = $this->getModels();
        $this->showDropdown();
    }

    public function setSuggestedModel($key)
    {
        $this->model = $this->models[$key];
        $this->route = Str::lower($this->getModelName($this->model));
        $this->hideDropdown();
    }

    public function updatedModel($value)
    {
        $value = $value == '' ? null : $value;
        $this->models = $this->getModels($value);
        $this->showDropdown();
    }

    public function hideDropdown()
    {
        $this->dropdown = false;
    }

    public function showDropdown()
    {
        $this->dropdown = true;
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

    private function getModels($query = null)
    {
        $files = File::exists(app_path('/Models')) ? File::files(app_path('/Models')) : File::allFiles(app_path('/'));
        $array = [];
        foreach ($files as $file) {
            if (!Str::contains($file->getFilename(), '.php') or (!is_null($query) and !Str::contains(Str::lower($file->getFilename()), Str::lower($query)))){
                continue;
            }

            $namespace = File::exists(app_path('/Models')) ? "App\\Models" : "\\App";
            $fileName = str_replace('.php', null, $file->getFilename());
            $fullNamespace =  $namespace."\\{$fileName}";

            if (app()->make($fullNamespace) instanceof Model) {
                $array[] = $fullNamespace;
            }
        }

        return $array;
    }
}
