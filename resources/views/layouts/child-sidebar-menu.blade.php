<li class="list-divider"></li>

@foreach(config('admin_panel.actions') as $name => $value)
    <li class='sidebar-item @isActive([getRouteName().".$name.lists", getRouteName().".$name.create", getRouteName().".$name.update"], "selected")'>
        <a class='sidebar-link @isActive([getRouteName().".$name.lists", getRouteName().".$name.create", getRouteName().".$name.update"], "active") ' href="@route(getRouteName().'.'.$name.'.lists')" aria-expanded="false">
            <i data-feather="{{ get_icon($name) }}" class="feather-icon"></i>
            <span class="hide-menu">{{ \Illuminate\Support\Str::ucfirst($name) }}</span>
        </a>
    </li>
@endforeach
@if(config('admin_panel.todo'))
    <li class="sidebar-item @isActive([getRouteName().'.todo.lists', getRouteName().'.todo.create'], 'selected')">
        <a class="sidebar-link @isActive([getRouteName().'.todo.lists', getRouteName().'.todo.create'], 'active') " href="@route(getRouteName().'.todo.lists')" aria-expanded="false">
            <i data-feather="grid" class="feather-icon"></i>
            <span class="hide-menu">Todo</span>
        </a>
    </li>
@endif