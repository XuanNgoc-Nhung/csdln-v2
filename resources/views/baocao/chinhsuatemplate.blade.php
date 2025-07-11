<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Chỉnh sửa template</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- javascript -->
    <script src="cdn/js/jquery.js" type="text/javascript"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="css/indexElementUi.css" rel="stylesheet" type="text/css" /><!-- import CSS -->
    <link href="css/indexElementUiCusstom.css" rel="stylesheet" type="text/css" /><!-- import CSS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="cdn/js/ChinhSuaTemPlateBaoCaoDong.js" type="text/javascript"></script>
    <style>
        .dts-noty-success {
            background: #67c23a;
        }

        .dts-noty-info {
            background: #909399;
        }

        .dts-noty-warning {
            background: #e6a23c;
        }

        .dts-noty-error {
            background: #f56c6c;
        }

        .el-message__content {
            color: white !important;
        }

        .el-message .el-icon-error {
            color: white !important;
        }

        .el-message .el-icon-success {
            color: white !important;
        }

        .el-message .el-icon-warning {
            color: white !important;
        }

        .el-message .el-icon-info {
            color: white !important;
        }

        .mx-datepicker-popup {
            z-index: 2025 !important;
        }
        #myTabContent{
            padding-top:60px;
        }
        .container-fluid{
            border:1px solid Silver
        }

    </style>
    <script>
        console.log("AHihi")

        window.userInfo = '{!! json_encode(get_user_info("common_info")) !!}';
        var thongtin = JSON.parse(window.userInfo);
        let tt = JSON.stringify(thongtin)
        localStorage.setItem('user', tt);
        let dsch = '<?php echo($lch) ?>';
        let dsch2 = JSON.parse(dsch)
        window.listCapHoc = dsch2;

    </script>
</head>

<body>
    <div class="container-fluid"  id='app'>
        <div class="container-fluid">
            <nav class="navbar fixed-top navbar-light bg-light">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Chỉnh sửa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Danh sách tiêu chí hệ thống</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tieuChiNgoai-tab" data-toggle="tab" href="#tieuChiNgoai" role="tab"
                            aria-controls="tieuChiNgoai" aria-selected="false">Danh sách tiêu chí ngoài</a>
                    </li>
                </ul>
            </nav>
            <div  class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="text-center">
                        @if($dataHtml)
                        {!!$dataHtml!!}
                        @else
                        <div class="text-center">
                            <h3>Báo cáo này chưa có dữ liệu. Vui lòng thử lại sau.</h3>
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        @if($dataHtml)
                        <button class="btn btn-primary" id="buttonChinhSua">Chỉnh
                            sửa</button>
                        @else
                        @endif
                        <input type="hidden" id="idBaoCao" name="idBaoCao" value={{$idBaoCao}}>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div>
                        <chinh-sua-template-bao-cao></chinh-sua-template-bao-cao>
                    </div>
                </div>
                <div class="tab-pane fade" id="tieuChiNgoai" role="tabpanel" aria-labelledby="tieuChiNgoai-tab">
                    <div>
                        <danh-sach-tieu-chi-ngoai></danh-sach-tieu-chi-ngoai>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
<script src="{{asset('js/chinh-sua-template-bao-cao.js')}}"></script>

</html>
