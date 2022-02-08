<div x-data="{ rebuildModal: false }">
    <div class="card">
        <div class="card-header p-0">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">{{ __('Translation') }}</h3>
                <div class="customize-input">
                    <select id="langChanger" wire:model="selectedLang" class="custom-select text-dark custom-select-set form-control bg-white border-0 custom-shadow custom-radius" style="border-radius: 6px">
                        @foreach(\EasyPanel\Services\LangManager::get() as $key => $value)
                            <option value="{{ $key }}" selected>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <ul class="breadcrumb mt-3 py-3 px-4 rounded" style="background-color: #e9ecef!important;">
                <li class="breadcrumb-item"><a href="@route(getRouteName().'.home')" class="text-decoration-none">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Translation') }}</li>
            </ul>
        </div>


        <form class="form-horizontal" x-data="{}" wire:submit.prevent="update" autocomplete="off">

            <div class="card-body">
                <div class="row ">
                    @foreach($texts as $key => $text)
                        <div class="col-md-6">
                            <div class="form-group">
                                <input id="route" disabled type="text" placeholder="" class="form-control rounded" value="{{ $key }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group position-relative">
                                <input id="route" type="text" placeholder="" class="form-control rounded" value="{{ $text }}" wire:model="texts.{{ $key }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-info ml-4">{{ __('Update') }}</button>
                <a href="@route(getRouteName().'.home')" class="btn btn-default float-left">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
