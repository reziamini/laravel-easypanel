<div>
    <h3 class="text-dark font-weight-bold">{{ __('ListTitle', ['name' => 'todo']) }}</h3>

    <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
        <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ __('Todo') }}</li>
    </ul>

    <div class="mt-4 px-2">
        <div class="mt-2">
            @livewire('admin::livewire.todo.create')
        </div>
        <h4 class="mt-3 text-dark">{{ __('Your TODO list') }} :</h4>
        <div class="rounded-lg border-light mt-4 p-2 border">
            @if(count($todos) > 0)
                @foreach($todos as $todo)
                    @livewire('admin::livewire.todo.single', ['todo' => $todo ], key($todo->id))
                @endforeach
            @else
                <div class="text-center mt-5 align-items-center">
                    <h2><span class="text-success">{{ __('Congrats') }}!</span><br>{{ __('There is nothing to do') }}</h2>
                </div>
            @endif
        </div>
    </div>

</div>
