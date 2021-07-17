<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap"><span class="hide-menu">{{ __('Applications') }}</span></li>

                <li class="sidebar-item @isActive(getRouteName().'.home', 'selected')">
                    <a class="sidebar-link @isActive(getRouteName().'.home', 'active') " href="@route(getRouteName().'.home')" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">{{ __('Home') }}</span>
                    </a>
                </li>

                <li class="sidebar-item @isActive(getRouteName().'.crud.lists', 'selected')">
                    <a class="sidebar-link @isActive(getRouteName().'.crud.lists', 'active') " href="@route(getRouteName().'.crud.lists')" aria-expanded="false">
                        <i data-feather="package" class="feather-icon"></i>
                        <span class="hide-menu">{{ __('CRUD Manager') }}</span>
                    </a>
                </li>

                @include('admin::layouts.child-sidebar-menu')


                <li class="list-divider"></li>
                <li class="sidebar-item">
                    <a href="@route(getRouteName().'.logout')" class="sidebar-link sidebar-link" onclick="event.preventDefault(); document.querySelector('#logout').submit()" aria-expanded="false">
                        <i data-feather="log-out" class="feather-icon"></i>
                        <span class="hide-menu">{{ __('Logout') }}</span>
                    </a>
                    <form id="logout" action="@route(getRouteName().'.logout')" method="post"> @csrf </form>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
