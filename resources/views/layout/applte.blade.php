<?php
$cate_menu = session("cate_menu", []);
$doipass = session("user", []);
$str = '';
$tenDangNhap = get_user_info("fullName");
$tenDacBiet=htmlspecialchars_decode($tenDangNhap,ENT_QUOTES);
$tenDacBiet1 = str_replace("'", "&dacbiet1", $tenDacBiet);
$tenDacBiet2 = str_replace('"', "&dacbiet2", $tenDacBiet1);
$tenDacBiet2 = str_replace("\\", "&dacbiet3", $tenDacBiet2);
// $tenDacBiet2 = str_replace(']', "&dacbiet4", $tenDacBiet2);
?>
<script>
    console.log(
        "%cDừng lại!",
        "color:red;font-family:system-ui;font-size:4rem;-webkit-text-stroke: 1px black;font-weight:bold"
    );

    console.log('\x1b[35m%s\x1b[34m%s\x1b[0m', 'Đây là một tính năng của nhà phát triển. Vui lòng quay trở lại.',
        'Xin cảm ơn.');
    // console.log = function () {};
    window.userInfo = '{!! json_encode(get_user_info("common_info")) !!}';
    let dm = JSON.parse(window.userInfo)
    var res = '<?php echo($tenDacBiet2)?>'.replace("&dacbiet1", "'");
    var res = res.replace("&dacbiet2", '"');
    var res = res.replace("&dacbiet3", '\\');
    dm.display_name = res;
    window.userInfo = JSON.stringify(dm);
    let dsch = '<?php echo($lch) ?>';
    let dsch2 = JSON.parse(dsch)
    window.listCapHoc = dsch2;
    console.log("Danh sách cấp học:");
    console.log(window.userInfo);
    console.log(window.listCapHoc);
    window.token = '';
    if (document.cookie != '') {
        let cook = document.cookie;
        let arr_cookie = cook.split('; ');
        for (var i = 0; i < arr_cookie.length; i++) {
            let item = arr_cookie[i].split('=');
            if (item.length > 1) {
                if (item[0] == 'XSRF-TOKEN') {
                    window.token = item[1];
                }
            }
        }
        if (window.token == '') {
            let arr_cook = cook.split(';');
            for (var i = 0; i < arr_cook.length; i++) {
                let item = arr_cook[i].split('=');
                if (item.length > 1) {
                    if (item[0] == 'XSRF-TOKEN') {
                        window.token = item[1];
                    }
                }
            }
        }
    }

</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hệ Thống Cơ Sở Dữ Liệu Ngành Giáo Dục</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="AdminLTE/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="AdminLTE/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div id="doimatkhau">
        <doi-mat-khau :info="'{{json_encode(get_user_info("common_info"))}}'"></doi-mat-khau>
    </div>
    <div class="wrapper">
        <!-- Navbar -->
        <nav style="display:none" class="main-header navbar navbar-expand navbar-white navbar-light"
            style="background:smoke">
            <ul class="navbar-nav">
                @foreach($cate_menu as $mn)
                @if(isset($mn->children))
                <li class="nav-item dropdown ">
                    <a class="nav-link" data-toggle="dropdown" href="#">{{$mn->name}}</a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- <span class="dropdown-item dropdown-header">Tùy chọn cá nhân</span> -->
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item doimatkhau">
                            <i class="fas fa-envelope mr-2"></i>Đổi mật khẩu
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{url('logout')}}" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> Đăng xuất
                        </a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
                @endif
                @endforeach
            </ul>
            <!-- Left navbar links -->
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown ">
                    <a class="nav-link" data-toggle="dropdown" href="#">{{get_user_info("fullName")}}</a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- <span class="dropdown-item dropdown-header">Tùy chọn cá nhân</span> -->
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item doimatkhau">
                            <i class="fas fa-envelope mr-2"></i>Đổi mật khẩu
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{url('logout')}}" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> Đăng xuất
                        </a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i style="padding-top:5px" class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li> -->
            </ul>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
           
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tổng hợp</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Dãy menu con
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Menu con</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- <footer class="main-footer">
            <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0-rc
            </div>
        </footer> -->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="AdminLTE/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="AdminLTE/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="AdminLTE/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="AdminLTE/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="AdminLTE/plugins/moment/moment.min.js"></script>
    <script src="AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <!-- AdminLTE for demo purposes -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="AdminLTE/dist/js/pages/dashboard.js"></script>
    @yield('js_location')
    <script src="{{asset('js/doi-mat-khau.js')}}"></script>
    <script src="cdn/element-ui-2-15.js"></script>
</body>

</html>
