

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PMH</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @include('user.layouts.link_css')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed" style="font-size: 14px">

    <div class="wrapper" id="wrapp">

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
                <span class="brand-text font-weight-light">MB PMS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fa fa-user text-fuchsia" style="font-size: 40px"></i>
{{--                        <img src="" class="img-circle elevation-2" alt="User Image">--}}
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

                        @if(\Illuminate\Support\Facades\Auth::user()->is_admin == false && \Illuminate\Support\Facades\Auth::user()->can_add_stock)
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fa fa-plus-square"></i>
                                    <p>
                                        Add To Stock
                                    </p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="nav-icon fa fa-database"></i>
                                <p>
                                    Stock
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="nav-icon fa fa-list"></i>
                                <p>
                                    Drug Cateories
                                </p>
                            </a>
                        </li>

                        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fa fa-plus-square"></i>
                                    <p>
                                        Add To Stock
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fa fa-money"></i>
                                    <p>
                                        Sell
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fa fa-users"></i>
                                    <p>
                                        Workers
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a id="report-link" class="nav-link">
                                    <i class="nav-icon fa fa-chart-line"></i>
                                    <p>
                                        Report
                                    </p>
                                </a>
                            </li>

                        @else
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="nav-icon fa fa-money"></i>
                                    <p>
                                        Sell
                                    </p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h5 class="m-0 text-dark">@yield('header')</h5>
                        </div><!-- /.col -->
                        <div class="col-12">
                            <hr>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                @include('user.layouts.messages')
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2020-2010 <a href="#">FCIPMS</a>.</strong>
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


    @include('user.layouts.link_js')

    <script>
        $(function () {
            let date_start = moment().format('MMMM-D-YYYY')
            let date_end = moment().format('MMMM-D-YYYY')
            let route = '/report/'+date_start+'/'+date_end
            $('#report-link').attr("href", route)

        })
    </script>
    </body>
</html>


