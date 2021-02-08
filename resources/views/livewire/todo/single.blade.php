<div  x-data="{ modalIsOpen : false }" class="border-bottom">
    <div class="row align-items-baseline px-5">

        <div class="col-10 d-flex">
            <div class="custom-control custom-checkbox ">
                <input id="todo{{ $todo->id }}" class="custom-control-input" type="checkbox" @if($todo->checked) checked @endif wire:model="checked">
                <label for="todo{{ $todo->id }}" class="custom-control-label"></label>
            </div>
            <p @if($todo->checked) class="text-success" style="text-decoration: line-through" @endif>
                @if(\Illuminate\Support\Str::length($todo->title) > 100)
                    {{ \Illuminate\Support\Str::substr($todo->title, 0, 100) }}...
                @else
                    {{ $todo->title }}
                @endif
            </p>
        </div>

        <div class="col-2 d-flex justify-content-end align-items-center p-1">
            <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                <i class="icon-trash"></i>
            </button>

            <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                    <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Todo')]) }}</h5>
                    <p>{{ __('DeleteMessage', ['name' => __('Todo')]) }}</p>
                    <div class="mt-5 d-flex justify-content-between">
                        <a wire:click.prevent="delete" class="text-white btn btn-success shadow">{{ __('Yes, Delete it') }}.</a>
                        <a @click.prevent="modalIsOpen = false" class="text-white btn btn-danger shadow">{{ __('No, Cancel it') }}.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
