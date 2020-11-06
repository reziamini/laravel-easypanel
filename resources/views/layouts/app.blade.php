<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Panel</title>

    @style('dist/vendor/admin/css/style.min.css')
    @style('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css')

    @script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    @script('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')

    @script('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.2/dist/alpine.min.js')
    @livewireStyles

</head>

<body>

<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

    <!-- Topbar header - style you can find in pages.scss -->
    <header class="topbar" data-navbarbg="skin6">
        <nav class="navbar top-navbar navbar-expand-md">
            <div class="navbar-header" data-logobg="skin6">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>

                <!-- Logo -->
                <div class="navbar-brand">
                    <a href="@route(getRouteName().'.home')">
                        <span class="logo-text">EasyPanel</span>
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
                            <span class="badge badge-primary notify-no rounded-circle">{{ \EasyPanel\Models\Todo::where('user_id', auth()->user()->id)->count() }}</span>
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
                                    <a class="nav-link pt-3 text-center text-dark" href="@route(getRouteName().'.todo.lists')">
                                        <strong>See TODO list</strong>
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
                                <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                        class="text-dark">@user('name')</span> <i data-feather="chevron-down"
                                                                              class="svg-icon"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                            <a class="dropdown-item" href="javascript:void(0)"><i data-feather="user"
                                                                                  class="svg-icon mr-2 ml-1"></i>
                                My Profile</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)"><i data-feather="power"
                                                                                  class="svg-icon mr-2 ml-1"></i>
                                Logout</a>
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
        <!-- Bread crumb and right sidebar toggle -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Ticket List</h4>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item"><a href="index.html" class="text-muted">Apps</a></li>
                                <li class="breadcrumb-item text-muted active" aria-current="page">Ticket List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bread crumb and right sidebar toggle -->

        <!-- Container -->
        <div class="container-fluid">

            {{ $slot }}

        </div>
        <!-- End Container fluid  -->

        <!-- footer -->
        <footer class="footer text-center text-muted">Adminmart Template, EasyPanel Package.</a>.</footer>
        <!-- End footer -->
    </div>
</div>
<!-- End Wrapper -->

<!-- All Scripts -->
@script('assets/vendor/admin/libs/jquery/dist/jquery.min.js')
@script('assets/vendor/admin/libs/popper.js/dist/umd/popper.min.js')
@script('assets/vendor/admin/libs/bootstrap/dist/js/bootstrap.min.js')

@script('dist/vendor/admin/js/app-style-switcher.js')
@script('dist/vendor/admin/js/feather.min.js')
@script('assets/vendor/admin/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')


@script('dist/vendor/admin/js/sidebarmenu.js')
@script('dist/vendor/admin/js/custom.min.js')

@livewireScripts
<script>

    window.addEventListener('show-message', function (event) {
        let type = event.detail.type;
        let message = event.detail.message;
        if(document.querySelector('.notification')){
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
