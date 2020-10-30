<?php

namespace AdminPanel\Http\Livewire;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class TestCrud extends Component
{
    public $data;
    private Model $model;

    public function mount(){
        $this->model = app($this->getModel());

    }

    public function render()
    {
        return view('livewire.test-crud')
            ->layout('layouts.dashboard', ['title' => 'das']);
    }


    private function getModel()
    {
        $model = Route::getCurrentRoute()->getName();
        $routeName = str_replace('/', '.', config('admin_panel.route_prefix'));
        preg_match("/$routeName\.(\w+)\.*?/", $model, $m);
        return config('admin_panel.cruds')[$m[1]];
    }
}
