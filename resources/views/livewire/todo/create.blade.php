<form action="" wire:submit.prevent="create">
    <div class="row ">
        <div class="col-9">
            <div class="form-group">
                <input id="title" type="text" placeholder="{{ __('Title of TODO') }}" class="form-control rounded @error('title') is-invalid @enderror" wire:model="title">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <input type="submit" class="form-control rounded btn btn-block btn-primary" value="{{ __('Create') }}">
            </div>
        </div>
    </div>
</form>
