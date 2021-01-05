<div>
    @livewire('admin::livewire.todo.create')
    <h4 class="mt-3 text-dark">Your TODO list :</h4>
    <div class="rounded-lg border-light mt-4 p-2 border">
        @if(count($todos) > 0)
            @foreach($todos as $todo)
                @livewire('admin::livewire.todo.single', ['todo' => $todo ], key($todo->id))
            @endforeach
        @else
            <div class="text-center mt-5 align-items-center">
                <h2><span class="text-success">Congrats!</span><br>There is nothing to do</h2>
            </div>
        @endif
    </div>

</div>
