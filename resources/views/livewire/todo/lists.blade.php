<div>
    @livewire('admin::livewire.todo.create')
    <h4 class="mt-3 text-dark">Your TODO list :</h4>
    <div class="bg-light rounded p-2">
        <div class="">
            @foreach($todos as $todo)
                @livewire('admin::livewire.todo.single', ['todo' => $todo ], key($todo->id))
            @endforeach
        </div>
    </div>

</div>
