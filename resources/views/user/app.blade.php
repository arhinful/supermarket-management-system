<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMH</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
    @include('user.layouts.link_css')
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="font-size: 14px">

<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-purple navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a class="nav-link">
                    {{\Illuminate\Support\Facades\Auth::user()->is_admin ? 'Admin' : 'Sales Person'}}
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <i class="fa fa-hospital text-olive" style="font-size: 25px"></i>
            <span class="brand-text font-weight-light">SMMS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fa fa-user text-fuchsia" style="font-size: 40px"></i>
                    <i class="fa fa-hos"></i>
                </div>
                <div class="info">
                    <a href="">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <router-link to="/add-stock" class="nav-link">
                            <i class="nav-icon fa fa-plus-square"></i>
                            <p>
                                Add To Stock
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/stocks" class="nav-link">
                            <i class="nav-icon fa fa-database"></i>
                            <p>
                                Stocks
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/sell" class="nav-link">
                            <i class="nav-icon fa fa-plus-square"></i>
                            <p>
                                Sell
                            </p>
                        </router-link>
                    </li>
                    @if(\Illuminate\Support\Facades\Auth::user()->admin)
                        <li class="nav-item">
                            <router-link to="/workers" class="nav-link">
                                <i class="nav-icon fa fa-plus-square"></i>
                                <p>
                                    Workers
                                </p>
                            </router-link>
                        </li>
                    @endif

                    <li class="nav-item">
                        <router-link to="/report" class="nav-link">
                            <i class="nav-icon fa fa-plus-square"></i>
                            <p>
                                Report
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link">
                            <i class="nav-icon fa fa-plus-square"></i>
                            <p>
                                Profile
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link bg-danger"
                           onclick="event.preventDefault();$('#logout-form').submit();"
                        >
                            <i class="nav-icon fas fa-sign-out-alt fa-rotate-180"></i>
                            <p>
                                Logout
                            </p>
                            <form id="logout-form" method="POST" action="{{route('logout')}}">
                                @csrf
                            </form>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
{{--        <!-- Content Header (Page header) -->--}}
{{--        <div class="content-header">--}}
{{--            <div class="container-fluid">--}}
{{--                <div class="row mb-2">--}}
{{--                    <div class="col-sm-6">--}}
{{--                        <h5 class="m-0 text-dark">@yield('header')</h5>--}}
{{--                    </div><!-- /.col -->--}}
{{--                    <div class="col-12">--}}
{{--                        <hr>--}}
{{--                    </div>--}}
{{--                </div><!-- /.row -->--}}
{{--            </div><!-- /.container-fluid -->--}}
{{--        </div>--}}
{{--        <!-- /.content-header -->--}}

        <!-- Main content -->
        <section class="content">
            @include('user.layouts.messages')
            <v-app>
                <router-view>
                </router-view>
            </v-app>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2019-2020 <span style="color:#0940ac;">FCI-SelLite</span>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Created By</b> -FiiComp Inc.-
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="{{asset('js/app.js')}}"></script>
@include('user.layouts.link_js')

<script>
    $(function () {
        let date_start = moment().format('MMMM-D-YYYY')
        let date_end = moment().format('MMMM-D-YYYY')
        let route = '/report/'+date_start+'/'+date_end
        $('#report-link').attr("href", route)

        $("#td").DataTable();
    })
</script>
</body>
</html>



