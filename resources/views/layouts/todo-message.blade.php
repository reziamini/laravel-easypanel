@foreach(\EasyPanel\Models\Todo::where('user_id', auth()->user()->id)->where('checked', false)->get() as $todo)
<a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
    <span class="btn btn-info rounded-circle btn-circle">
        <i data-feather="settings" class="text-white"></i>
    </span>
    <div class="w-75 d-inline-block v-middle pl-2">
        <h6 class="message-title mb-0 mt-1">{{ __('Todo') }} {{ $loop->count }}</h6>
        <span class="font-12 text-nowrap d-block text-muted text-truncate">{{ $todo->title }}</span>
    </div>
</a>
@endforeach
