<li class="list-divider"></li>
<li class="nav-small-cap"><span class="hide-menu">{{ __('CRUD Menu') }}</span></li>
@foreach(config('easy_panel.actions') as $name)
    <li class='sidebar-item @isActive([getRouteName().".$name.read", getRouteName().".$name.create", getRouteName().".$name.update"], "selected")'>
        <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
            <i data-feather="{{ get_icon($name) }}" class="feather-icon"></i>
            <span class="hide-menu">{{ __(\Illuminate\Support\Str::plural(ucfirst($name))) }}</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level base-level-line">
            <li class="sidebar-item @isActive(getRouteName().'.'.$name.'.read')">
                <a href="@route(getRouteName().'.'.$name.'.read')" class="sidebar-link @isActive(getRouteName().'.'.$name.'.read')">
                    <span class="hide-menu"> {{ __('List') }} </span>
                </a>
            </li>
            @if(config('easy_panel.crud.'.$name.'.create'))
                <li class="sidebar-item @isActive(getRouteName().'.'.$name.'.create')">
                    <a href="@route(getRouteName().'.'.$name.'.create')" class="sidebar-link @isActive(getRouteName().'.'.$name.'.create')">
                        <span class="hide-menu"> {{ __('Create') }} </span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endforeach

@if(config('easy_panel.todo'))
    <li class="sidebar-item @isActive([getRouteName().'.todo.lists', getRouteName().'.todo.create'], 'selected')">
        <a class="sidebar-link @isActive([getRouteName().'.todo.lists', getRouteName().'.todo.create'], 'active') " href="@route(getRouteName().'.todo.lists')" aria-expanded="false">
            <i data-feather="grid" class="feather-icon"></i>
            <span class="hide-menu">{{ __('Todo') }}</span>
        </a>
    </li>
@endif
