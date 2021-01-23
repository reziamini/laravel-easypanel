<li class="list-divider"></li>
<li class="nav-small-cap"><span class="hide-menu">CRUD Menu</span></li>
@foreach(config('easy_panel.actions') as $name)
    <li class='sidebar-item @isActive([getRouteName().".$name.read", getRouteName().".$name.create", getRouteName().".$name.update"], "selected")'>
        <a class='sidebar-link @isActive([getRouteName().".$name.read", getRouteName().".$name.create", getRouteName().".$name.update"], "active") ' href="@route(getRouteName().'.'.$name.'.read')" aria-expanded="false">
            <i data-feather="{{ get_icon($name) }}" class="feather-icon"></i>
            <span class="hide-menu">{{ \Illuminate\Support\Str::ucfirst($name) }}</span>
        </a>
    </li>
@endforeach

@if(config('easy_panel.todo'))
    <li class="sidebar-item @isActive([getRouteName().'.todo.lists', getRouteName().'.todo.create'], 'selected')">
        <a class="sidebar-link @isActive([getRouteName().'.todo.lists', getRouteName().'.todo.create'], 'active') " href="@route(getRouteName().'.todo.lists')" aria-expanded="false">
            <i data-feather="grid" class="feather-icon"></i>
            <span class="hide-menu">Todo</span>
        </a>
    </li>
@endif
