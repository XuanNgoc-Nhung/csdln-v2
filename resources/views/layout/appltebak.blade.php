<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="ioc/css/all.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="ioc/css/adminlte.css">
    <link rel="stylesheet" href="ioc/css/OverlayScrollbars.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <title>Trang chủ || IOC</title>
    <base href="{{asset('')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="css/cssCustom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="cdn/css/ioc.css" type="text/css" />
    <link href="css/indexElementUi.css" rel="stylesheet" type="text/css" />
    <link href="css/indexElementUiCusstom.css" rel="stylesheet" type="text/css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="ioc/logoThaiNguyen.png" alt="Logo IOC" height="60" width="60">
        </div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand ">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <div class="" style="width:100%;">
                <div class="row" style="">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-3">
                        <select class="custom-select donViQuanLy form-control form-control-border selectpicker"
                            data-show-subtext="true" data-live-search="true">
                            <option>Chọn đơn vị</option>
                            @foreach($listDonVi as $list)
                            <option value="{{$list['maDonVi']}}">{{$list['tenDonVi']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class="custom-select form-control form-control-border selectpicker"
                            data-show-subtext="true" data-live-search="true">
                            <option>Chọn cấp học</option>
                            @foreach($listDonVi as $list)
                            <option>{{$list['tenDonVi']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class="custom-select form-control form-control-border">
                            <option>Chọn năm học</option>
                            <option>Value 2</option>
                            <option>Value 3</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="thongKeDuLieu" class="btn btn-block btn-success">Thống kê</button>
                    </div>
                    <div class="col-sm-1 action-header">
                        <div class="nav-item action-buttom">
                            <a class="" data-widget="fullscreen" href="" role="button">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </a>
                        </div>
                        <div class="nav-item action-buttom">
                            <a class="" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                                <i class="fas fa-th-large"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- <li class="nav-item" >
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <div style="border:1px solid red" class="form-group">
                                <select class="custom-select form-control-border">
                                    <option>Value 1</option>
                                    <option>Value 2</option>
                                    <option>Value 3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-block btn-success">Thống kê</button>
                            </div>
                        </div>
                    </form>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> -->
            </div>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4">
            <a href="index.html" class="brand-link">
                <img src="ioc/logoThaiNguyen.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">CSDL Ngành</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="ioc/teach.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Sở GD&ĐT Thái Nguyên</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Trường học
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Cán bộ
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <section class="content">
                    <div class="container-fluid">
                        <!-- Biểu đồ giáo viên -->
                        <div id="app">
                            <ioc-bieu-do-can-bo></ioc-bieu-do-can-bo>
                        </div>
                        <!-- Hết biểu đồ giáo viên -->
                        <!-- Bản đồ -->
                        <div class="row" style="display:none">
                            <div class="col-12" style="padding-bottom:10px">
                                <div class='hienThiBanDo'>
                                    <div id='map'></div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:none">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h4>Trường học</h4>
                                        <h2>650</h2>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-home"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Chi tiết <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h4>Cán bộ</h4>
                                        <h2>6650</h2>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-home"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Chi tiết <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h4>Học sinh</h4>
                                        <h2>96650</h2>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-home"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Chi tiết <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h4>Học sinh nghỉ học</h4>
                                        <h2>6650</h2>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-home"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Chi tiết <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- Hết bản đồ -->
                    </div><!-- /.container-fluid -->
                </section>
            </div>
            <!-- /.content-wrapper -->
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <script src="ioc/js/jquery.js"></script>
        <!--  -->
        <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    </script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
        </script>
        <script src="js/ioc_constant.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
        <script src="js/ioc.js" type="text/javascript"></script>
        <script src="js/ioc_index.js" type="text/javascript"></script>
        <!-- <script src="{{asset('js/ioc/ioc-bieu-do-can-bo.js')}}"></script> -->
        <script src="ioc/js/overlayScrollbars.js"></script>
        <script src="ioc/js/adminlte.js"></script>
        <script src="ioc/js/demo.js"></script>
</body>

</html>
