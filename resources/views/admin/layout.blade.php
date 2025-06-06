<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
@auth
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!--TOKEN DE AJAX-->
        <title>
            @yield('titleSup', __('GDSEC')) | {{ auth()->user()->name }}
        </title>
        {{-- favicon --}}
        <link rel="icon" href="{{ asset('/adminlte/img/GDSEC-logo.ico') }}">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"/>
        <!-- Font Awesome Icons -->
        <link rel="stylesheet"href="{{ asset('/adminlte/plugins/fontawesome-free/css/all.min.css') }}"/>
        <!-- IonIcons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
        <!-- fullCalendar -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>
        {{-- <link rel="stylesheet" href="/adminlte/plugins/fullcalendar/main.css" /> --}}
        <!-- bootstraps 5 -->
        <link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap.css') }}" />
        <link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap-grid.css') }}"/>
        <link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap-utilities.css') }}"/>
        <link rel="stylesheet" href="{{ asset('/bootstrap-5.0.2-dist/css/bootstrap-reboot.css') }}"/>
        <!--DataTables-->
        <link rel="stylesheet" type="text/css" href="{{ asset('/js/DataTables-1.10.25/css/dataTables.bootstrap5.min.css') }}"/>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('/adminlte/css/adminlte.min.css') }}" /> {{-- DarkMode --}}
        <link rel="stylesheet" href="{{ asset('/adminlte/css/icons.css') }}" />
        <link rel="stylesheet" href="{{ asset('/adminlte/css/Products.css') }}" />
        <link rel="stylesheet" href="{{ asset('/adminlte/css/body.css') }}" />
        {{-- datePicker --}}
        <link rel="stylesheet" href="{{ asset('/adminlte/css/multidatepicker/mobiscroll.javascript.min.css') }}" />
        <!-- <link rel="stylesheet" href="{{ asset('/adminlte/css/jquery-ui.multidatespicker.css') }}" /> -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="{{ asset('/adminlte/plugins/moment/moment.min.js') }}"></script>

    </head>

    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light darkMode-bg">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-widget="pushmenu"
                            href="#"
                            role="button"
                            ><i class="fas fa-bars darkMode-text"></i
                        ></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Navbar Search -->
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-widget="navbar-search"
                            href="#"
                            role="button"
                        >
                            <i class="fas fa-search darkMode-text"></i>
                        </a>
                        <div class="navbar-search-block">
                            <form class="form-inline">
                                <div class="input-group input-group-sm">
                                    <input
                                        class="form-control form-control-navbar"
                                        type="search"
                                        placeholder="Search"
                                        aria-label="Search"
                                    />
                                    <div class="input-group-append">
                                        <button
                                            class="btn btn-navbar"
                                            type="submit"
                                        >
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button
                                            class="btn btn-navbar"
                                            type="button"
                                            data-widget="navbar-search"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-widget="fullscreen"
                            href="#"
                            role="button"
                        >
                            <i class="fas fa-expand-arrows-alt darkMode-text"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-widget="control-sidebar"
                            data-slide="true"
                            href="#"
                            role="button"
                            style="padding-top: 0px;"
                        >
                            <div class="image" style="width: 40px; height: 40px;">
                                @if(auth()->user()->img !== null)
                                <img
                                    src="{{ auth()->user()->link }}{{ auth()->user()->img }}"
                                    class="darkMode-circle img-circle elevation-2"
                                    alt="User Image"
                                    style=" height: 42px;
                                            border: 3px solid gray;
                                            width: 42px;"
                                />
                                @else
                                <img
                                    src="/adminlte/img/users/default.png"
                                    class="darkMode-circle img-circle elevation-2"
                                    alt="User Image"
                                    style=" max-height: 100%; border: 3px solid gray;"
                                />
                                @endif
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div
                        class="user-panel mt-3 pb-3 mb-3 d-flex"
                        id="sidebar-profile"
                    >
                        @if(auth()->user()->img !== null)
                        <div
                            class="image"
                            style="padding-left: 0px !important;"
                        >
                            <img
                                src="{{ auth()->user()->link }}{{ auth()->user()->img }}"
                                class="img-circle elevation-2"
                                alt="User Image"
                                id="imagenCircle"
                            />
                        </div>
                        @else
                        <div
                            class="image"
                            style="padding-left: 0px !important;"
                        >
                            <img
                                src="/adminlte/img/users/default.png"
                                class="img-circle elevation-2"
                                alt="User Image"
                                id="imagenCircle"
                            />
                        </div>
                        @endif
                        <div class="info" id="info">
                            <a
                                class="d-block"
                                data-bs-toggle="modal"
                                data-bs-whatever="@fat"
                                class="mg-10-1"
                                style="cursor:pointer;"
                                onclick="ShowModalProfile('{{ auth()->user()->id }}', '{{ auth()->user()->role_id }}', '{{ auth()->user()->city->state->country->id}}')"
                                >{{ auth()->user()->name }}</a
                            >
                        </div>
                    </div>

                    <!-- SidebarSearch Form -->
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul
                            class="nav nav-pills nav-sidebar flex-column"
                            data-widget="treeview"
                            role="menu"
                            data-accordion="false"
                        >
                            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link active">
                                    <i class="fas fa-home"></i>
                                    <p>
                                        {{ __("Main") }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if(auth()->user()->role_id == 1 ||
                                    auth()->user()->role_id == 2)
                                    <li class="nav-item">
                                        <a
                                            href="{{ route('resume.index') }}"
                                            class="nav-link"
                                        >
                                            <i
                                                class="fas fa-file"
                                                style="margin: 5px;"
                                            ></i>
                                            <p>{{ __("Resume") }}</p>
                                        </a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a
                                            href="{{ route('orders.index') }}"
                                            class="nav-link"
                                        >
                                            <i
                                                class="fas fa-box-open"
                                                style="margin: 5px;"
                                            ></i>
                                            <p>{{ __("Orders") }}</p>
                                        </a>
                                    </li>
                                    @if(auth()->user()->role_id == 1 ||
                                    auth()->user()->role_id == 2 ||
                                    auth()->user()->role_id == 3)
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-clipboard-check"
                                            style="margin: 5px;"></i>
                                            <p>
                                                {{ __("Inventario") }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a
                                                href="{{ route('products.index') }}"
                                                class="nav-link" style="padding-left: 35px;">
                                                    <i
                                                        class="fas fa-list-ul"
                                                        style="margin: 5px;"
                                                    ></i>
                                                    <p>{{ __("Products") }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                    href="{{ route('warehouses.index') }}"
                                                    class="nav-link" style="padding-left: 35px;">
                                                    <i
                                                        class="fas fa-warehouse"
                                                        style="margin: 5px;"
                                                    ></i>
                                                    <p>{{ __("Bodegas") }}</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a
                                                href="{{ route('product_warehouses.index') }}"
                                                class="nav-link" style="padding-left: 35px;">
                                                    <i
                                                        class="fas fa-boxes"
                                                        style="margin: 5px;"
                                                    ></i>
                                                    <p>{{ __("Productos x Bodega") }}</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    @endif @if(auth()->user()->role_id == 1 ||
                                    auth()->user()->role_id == 2)
                                    <li class="nav-item">
                                        <a
                                            href="{{
                                                route('employees.index')
                                            }}"
                                            class="nav-link"
                                        >
                                            <i
                                                class="fas fa-user-friends"
                                                style="margin: 5px;"
                                            ></i>
                                            <p>{{ __("Employees") }}</p>
                                        </a>
                                    </li>
                                    @endif @if(auth()->user()->role_id == 1 ||
                                    auth()->user()->role_id == 2)
                                    <li class="nav-item">
                                        <a
                                            href="{{ route('calendar.index') }}"
                                            class="nav-link"
                                        >
                                            <i
                                                class="far fa-calendar-alt"
                                                style="margin: 5px;"
                                            ></i>
                                            <p>{{ __("Calendario") }}</p>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper darkMode-bg">
                <!-- Content Header (Page header) -->
                <div class="content-header darkMode">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">
                                    @yield('title', __('Hola'))
                                </h1>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    @if(auth()->user()->role_id == 1 ||
                                    auth()->user()->role_id == 2)
                                    <li class="breadcrumb-item">
                                        <a class="darkMode-text" href="{{ route('resume.index') }}">{{
                                            __("Resumen")
                                        }}</a>
                                    </li>
                                    @endif @yield('explorer')
                                </ol>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content darkMode-bg">
                    @include('admin.profile.edit') @yield('content')
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->

                <div class="p-4">
                    <div
                        class="form-check form-switch"
                        style="margin-left: 10px; margin-bottom: 10px;"
                    >
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="darkMode"
                            onclick="darkMode( this )"
                        />
                        <label
                            class="form-check-label"
                            for="flexSwitchCheckDefault"
                            >Dark mode</label
                        >
                    </div>
                    @auth
                    <a
                        href="#"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                        >Cerrar Sesion</a
                    >
                    @else
                    <p>No tienes que estar aqui</p>
                    @endguest
                </div>
            </aside>
            <!-- /.control-sidebar -->
            <form
                action="{{ route('logout') }}"
                method="POST"
                id="logout-form"
                style="display: none;"
            >
                @csrf
            </form>
            <!-- Main Footer -->
            <footer class="main-footer" style="text-align: center;">

                <div class="float-left d-none d-sm-inline">
                    <small>
                        All rights reserved 
                    </small>
                    &copy;
                </div>

                <div class="float-right d-none d-sm-inline">
                    &reg;                      
                    <small> 
                        <strong>By</strong>
                         Jose Alejandro Calderón
                    </small>
                </div>

                <img src="/adminlte/img/GDSEC-logo.ico" alt="Logo GDSEC" style="width: 35px;">
                <div class="d-none d-sm-inline" style="font-size: 16px;">
                    <strong> GDSEC </strong>Latam 2022 &copy;
                </div>
            </footer>
        </div>
        {{-- TooltipTex --}}
        <script src="/adminlte/js/tooltip/tooltipTex.js"></script>
        <!-- DarkMode -->
        <script src="/adminlte/js/darkMode/darkMode.js"></script>
        <!-- jQuery -->
        <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
        <!--SweetAlert2-->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Bootstrap 5 -->
        <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.js"></script>
        <!-- AdminLTE App -->
        <script src="/adminlte/js/adminlte.min.js"></script>
        <!-- jQuery UI -->
        <script src="/adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- OPTIONAL SCRIPTS -->
        <script src="/adminlte/plugins/chart.js/Chart.min.js"></script>
        <!-- fullCalendar 2.2.5 -->
       {{--  <script src="/adminlte/plugins/fullcalendar/main.js"></script> --}}
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
        <!--Datatables-->
        <script
            type="text/javascript"
            src="/js/DataTables-1.10.25/js/jquery.dataTables.min.js"
        ></script>
        <script src="/js/DataTables-1.10.25/js/dataTables.bootstrap5.min.js"></script>
        <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <!-- Multi date picker -->
        <script src="{{ asset('/adminlte/js/multidatepicker/mobiscroll.javascript.min.js') }}" defer></script>
        <!-- <script src="{{ asset('/adminlte/js/jquery-ui.multidatespicker.js') }}" defer></script> -->

    </body>
</html>
@endauth
