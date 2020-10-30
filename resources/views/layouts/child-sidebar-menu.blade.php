<li class="list-divider"></li>

@foreach(config('admin_panel.actions') as $name => $value)
    <li class="sidebar-item @isActive('admin.$name', 'selected')">
        <a class="sidebar-link @isActive('admin.$name', 'active') " href="@route('admin.'.$name)" aria-expanded="false">
            <i data-feather="{{ get_icon($name) }}" class="feather-icon"></i>
            <span class="hide-menu">{{ \Illuminate\Support\Str::ucfirst($name) }}</span>
        </a>
    </li>
@endforeach
