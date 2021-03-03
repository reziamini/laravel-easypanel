<!DOCTYPE html>
<html dir="{{ config('easy_panel.rtl_mode') ? 'rtl' : 'ltr' }}" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ __('EasyPanel') }} - {{ $title ?? __('Home') }}</title>

    {{--Scripts which must load before full loading--}}
    @style('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css')
    @script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    @script('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    @script('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine.min.js')
    @script("/assets/admin/js/ckeditor.min.js")

    {{--Styles--}}
    @livewireStyles
    @style("/assets/admin/css/style.min.css")
    @if(config('easy_panel.rtl_mode'))
        @style("/assets/admin/css/rtl.css")
        @style("https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v27.2.1/dist/font-face.css")
    @endif
</head>

<body>

<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

    <!-- Topbar header - style you can find in pages.scss -->
    <header class="topbar" data-navbarbg="skin6">
        <nav class="navbar top-navbar navbar-expand-md">
            <div class="navbar-header" data-logobg="skin6">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                        class="ti-menu ti-close"></i></a>

                <!-- Logo -->
                <div class="navbar-brand">
                    <a href="@route(getRouteName().'.home')">
                        <span class="logo-text">{{ __('EasyPanel') }}</span>
                    </a>
                </div>
                <!-- End Logo -->

                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                   data-toggle="collapse" data-target="#navbarSupportedContent"
                   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                        class="ti-more"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->

            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                    <!-- Notification -->
                    @if(config('easy_panel.todo'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                               id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <span><i data-feather="bell" class="svg-icon"></i></span>
                                <span class="badge badge-primary notify-no rounded-circle">{{ \EasyPanel\Models\Todo::where('user_id', auth()->user()->id)->where('checked', false)->count() }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="message-center notifications position-relative">
                                            <!-- Todos Messages -->
                                            @include('admin::layouts.todo-message')
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link pt-3 text-center text-dark"
                                           href="@route(getRouteName().'.todo.lists')">
                                            <strong>{{ __('See TODO list') }}</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                @endif
                <!-- End Notification -->
                </ul>

                <!-- Right side toggle and nav items -->
                <ul class="navbar-nav float-right">
                    <!-- User profile and search -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                                <span class="ml-2 d-none d-lg-inline-block"><span>{{ __('Hello') }},</span> <span
                                        class="text-dark">@user('name')</span> <i data-feather="chevron-down"
                                                                                  class="svg-icon"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated pb-0 flipInY">
                            <a class="dropdown-item" href="javascript:void(0)"
                               onclick="event.preventDefault(); document.querySelector('#logout').submit()"><i
                                    data-feather="power"
                                    class="svg-icon mr-2 ml-1"></i>
                                {{ __('Logout') }}</a>
                            <form id="logout" action="@route(getRouteName().'.logout')" method="post"> @csrf </form>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- End Topbar header -->

    <!-- Left Sidebar -->
@include('admin::layouts.sidebar')
<!-- End Left Sidebar -->


    <!-- Page wrapper  -->
    <div class="page-wrapper">

        <!-- Container -->
        <div class="container-fluid">

            {{ $slot }}

        </div>
        <!-- End Container fluid  -->

        <!-- footer -->
        <footer class="footer text-center text-muted">Adminmart Template, <a href="https://github.com/rezaamini-ir/laravel-easypanel">EasyPanel</a> Package.</footer>
        <!-- End footer -->
    </div>
</div>
<!-- End Wrapper -->

<!-- All Scripts -->
@script("/assets/admin/js/jquery.min.js")
@script("/assets/admin/js/popper.min.js")
@script("/assets/admin/js/bootstrap.min.js")
@script("/assets/admin/js/perfect-scrollbar.jquery.min.js")
@script("/assets/admin/js/app-style-switcher.min.js")
@script("/assets/admin/js/feather.min.js")
@script("/assets/admin/js/sidebarmenu.min.js")
@script("/assets/admin/js/custom.min.js")

@livewireScripts
<script>

    window.addEventListener('show-message', function (event) {
        let type = event.detail.type;
        let message = event.detail.message;
        if (document.querySelector('.notification')) {
            document.querySelector('.notification').remove();
        }
        let body = document.querySelector('#main-wrapper');
        let child = document.createElement('div');
        child.classList.add('notification', 'notification-' + type, 'animate__animated', 'animate__jackInTheBox');
        child.innerHTML = `<p>${message}</p>`;

        body.appendChild(child);

        setTimeout(function () {
            body.removeChild(child);
        }, 3000);
    });
</script>

</body>

</html>
