<form action="" wire:submit.prevent="create">
    <div class="row ">
        <div class="col-md-6">
            <div class="form-group">
                <input id="model" type="text" placeholder="{{ __('Model namespace') }}" class="form-control rounded @error('model') is-invalid @enderror" wire:model="model">
                @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input id="route" type="text" placeholder="{{ __('CRUD's Route') }}" class="form-control rounded @error('route') is-invalid @enderror" wire:model="route">
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
