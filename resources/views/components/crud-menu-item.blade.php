@if ($crud->with_acl)
    @if (auth()->user()->hasPermission(getRouteName().".{$crud->route}.*"))
        <li class='sidebar-item @isActive([getRouteName().".{$crud->route}.read", getRouteName().".{$crud->route}.create", getRouteName().".{$crud->route}.update"], "selected")'>
            <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
                <i class="{{ $crud->icon }}"></i>
                <span class="hide-menu">{{ __(\Illuminate\Support\Str::plural(ucfirst($crud->name))) }}</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level base-level-line">

                @if (auth()->user()->hasPermission(getRouteName().".{$crud->route}.read"))
                    <li class="sidebar-item @isActive(getRouteName().'.'.$crud->route.'.read')">
                        <a href="@route(getRouteName().'.'.$crud->route.'.read')" class="sidebar-link @isActive(getRouteName().'.'.$crud->route.'.read')">
                            <span class="hide-menu"> {{ __('List') }} </span>
                        </a>
                    </li>
                @endif

                @if(getCrudConfig($crud->name)->create && auth()->user()->hasPermission(getRouteName().".{$crud->route}.create"))
                    <li class="sidebar-item @isActive(getRouteName().'.'.$crud->route.'.create')">
                        <a href="@route(getRouteName().'.'.$crud->route.'.create')" class="sidebar-link @isActive(getRouteName().'.'.$crud->route.'.create')">
                            <span class="hide-menu"> {{ __('Create') }} </span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
@else 
    <li class='sidebar-item @isActive([getRouteName().".{$crud->route}.read", getRouteName().".{$crud->route}.create", getRouteName().".{$crud->route}.update"], "selected")'>
        <a class='sidebar-link has-arrow' href="javascript:void(0)" aria-expanded="false">
            <i class="{{ $crud->icon }}"></i>
            <span class="hide-menu">{{ __(\Illuminate\Support\Str::plural(ucfirst($crud->name))) }}</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level base-level-line">
            <li class="sidebar-item @isActive(getRouteName().'.'.$crud->route.'.read')">
                <a href="@route(getRouteName().'.'.$crud->route.'.read')" class="sidebar-link @isActive(getRouteName().'.'.$crud->route.'.read')">
                    <span class="hide-menu"> {{ __('List') }} </span>
                </a>
            </li>
            @if(getCrudConfig($crud->name)->create)
                <li class="sidebar-item @isActive(getRouteName().'.'.$crud->route.'.create')">
                    <a href="@route(getRouteName().'.'.$crud->route.'.create')" class="sidebar-link @isActive(getRouteName().'.'.$crud->route.'.create')">
                        <span class="hide-menu"> {{ __('Create') }} </span>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif