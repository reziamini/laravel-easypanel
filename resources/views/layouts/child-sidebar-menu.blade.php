<li class="list-divider"></li>
<li class="nav-small-cap"><span class="hide-menu">{{ __('CRUD Menu') }}</span></li>
@foreach(\EasyPanel\Models\CRUD::active() as $crud)
    <li class='sidebar-item @isActive([getRouteName().".{$crud->name}.read", getRouteName().".{$crud->name}.create", getRouteName().".{$crud->name}.update"], "selected")'>
        <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
            <i data-feather="{{ get_icon($crud->name) }}" class="feather-icon"></i>
            <span class="hide-menu">{{ __(\Illuminate\Support\Str::plural(ucfirst($crud->name))) }}</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level base-level-line">
            <li class="sidebar-item @isActive(getRouteName().'.'.$crud->name.'.read')">
                <a href="@route(getRouteName().'.'.$crud->name.'.read')" class="sidebar-link @isActive(getRouteName().'.'.$crud->name.'.read')">
                    <span class="hide-menu"> {{ __('List') }} </span>
                </a>
            </li>
            @if(getCrudConfig($crud->name))
                <li class="sidebar-item @isActive(getRouteName().'.'.$crud->name.'.create')">
                    <a href="@route(getRouteName().'.'.$crud->name.'.create')" class="sidebar-link @isActive(getRouteName().'.'.$crud->name.'.create')">
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
