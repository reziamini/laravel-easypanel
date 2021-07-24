<form action="" wire:submit.prevent="create" autocomplete="off">
    <div class="row ">
        <div class="col-md-6">
            <div class="form-group">
                <input id="model" wire:click="setModel" type="text" placeholder="{{ __('Model namespace') }}" class="form-control rounded @error('model') is-invalid @enderror" wire:model="model">
                @if($models and $dropdown)
                    <div class="bg-white rounded d-flex flex-column shadow p-3">
                        @foreach($models as $key => $model)
                            <a href="" class="py-2 autocomplete-item" wire:click.prevent="setSuggestedModel({{ $key }})">{{ $model }}</a>
                        @endforeach
                    </div>
                @endif
                @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input id="route" type="text" placeholder="{{ __('Route of CRUD') }}" class="form-control rounded @error('route') is-invalid @enderror" wire:model="route">
                @error('route') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input type="submit" class="form-control rounded btn btn-block btn-primary" value="{{ __('Create') }}">
            </div>
        </div>
    </div>
</form>
