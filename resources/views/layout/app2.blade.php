<?php

$cate_menu = session("cate_menu", []);
$doipass = session("user", []);
// dd($doipass['doipass']);
$str = '';

foreach ($cate_menu as $value) {
    $value = (object)$value;
    $str .= '<li>';
    if (isset($value->children)) {
        $subMenus = $value->children;
        if (sizeof($subMenus) == 0 || is_string($subMenus[0])) {
            $str .= '<a href="' . $value->path . '"> <i class="' . $value->icon . '"></i> ' . $value->name . '</a>';
        } else {
            $str .= '<a href="#"> <i class="' . $value->icon . '"></i> ' . $value->name . '<span class="fa arrow"></span></a>';
            $str .= '<ul class="nav nav-second-level">';
            foreach ($subMenus as $subMenu) {
                $subMenu = (object)$subMenu;
                $str .= '<li>';
                $str .= '<a href="' . $subMenu->path . '"> <i class="' . $subMenu->icon . '"></i> ' . $subMenu->name . '</a>';
                $str .= '</li>';
            }
            $str .= '</ul>';
        }
    } else {
        $str .= '<a href="' . $value->path . '"> <i class="' . $value->icon . '"></i> ' . $value->name . '</a>';
    }
    $str .= '</li>';
}
?>
<script>
    console.log(
        "%cDừng lại!",
        "color:red;font-family:system-ui;font-size:4rem;-webkit-text-stroke: 1px black;font-weight:bold"
    );

    // 1
    // 2
    console.log('\x1b[35m%s\x1b[34m%s\x1b[0m', 'Đây là một tính năng của nhà phát triển. Mọi hành đồng nhằm cố ý can thiệp vào hệ thống 1 cách sai trái đều là vi phạm. Vui lòng quay trở lại.','Xin cảm ơn.');
    // console.log = function () {};
    window.userInfo = '{!! json_encode(get_user_info("common_info")) !!}';

    let dsch = '<?php echo($lch) ?>';
    let dsch2 = JSON.parse(dsch)
    window.listCapHoc = dsch2;
    console.log("Danh sách cấp học:");
    console.log(window.userInfo);
    console.log(window.listCapHoc);
    window.token = '';
    if(document.cookie != '')
    {
        let cook = document.cookie;
        let arr_cookie = cook.split('; ');
        for(var i = 0; i < arr_cookie.length; i++)
        {
            let item = arr_cookie[i].split('=');
            if(item.length > 1)
            {
                if(item[0] == 'XSRF-TOKEN')
                {
                    window.token = item[1];
                }
            }
        }
        if(window.token == '')
        {
            let arr_cook = cook.split(';');
            for(var i = 0; i < arr_cook.length; i++)
            {
                let item = arr_cook[i].split('=');
                if(item.length > 1)
                {
                    if(item[0] == 'XSRF-TOKEN')
                    {
                        window.token = item[1];
                    }
                }
            }
        }
    }
</script>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cơ sở dữ liệu ngành</title>
    <base href="{{asset('')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" property="base-url" content="{!! url(" /") !!}"/>
    <meta
        name="aps-token"
        property="aps-token"
        content="{{json_encode(get_user_info("
            common_info"))}}"="common_info"
    ))}}""="))}}"
    ""/>
    @yield('header') @yield('cssheader')

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <link
        href="css/plugins/metisMenu/metisMenu.min.css"
        rel="stylesheet"
        type="text/css"/>
    <link href="css/sb-admin-2.css" rel="stylesheet" type="text/css"/>
    <link
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link href="css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>
    <style>

        body {
            /* font-family: roboto slab; */
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        }

        @keyframes spinner {
            to {
                transform: rotate(360deg);
            }
        }
        p {
            margin: 0;
        }

        .spinner:before {
            content: '';
            box-sizing: border-box;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin-top: -10px;
            margin-left: -10px;
            border-radius: 50%;
            border-top: 2px solid #07d;
            border-right: 2px solid transparent;
            animation: spinner 0.6s linear infinite;
        }

        .space60 {
            padding-bottom: 60px;
        }
        .space70 {
            padding-bottom: 70px;
        }
        .space80 {
            padding-bottom: 80px;
        }
        .space90 {
            padding-bottom: 90px;
        }
        .space100 {
            padding-bottom: 100px;
        }
        .sidebar .nav-second-level li a {
            font-size: 12px;
        }
        .e-multiselect.e-checkbox .e-multi-select-wrapper {
            padding-left: 15px !improtant;
            padding-top: 15px !improtant;
        }
        .e-multiselect .e-multi-select-wrapper.e-down-icon,
        .e-multiselect.e-checkbox .e-multi-select-wrapper {
            padding: 0;
            /* margin-right:15px; */
            border: 1px solid #ccc;
            border-radius: 4px;
            /* box-shadow: inset 0 1px 1px rgba(0,0,0,.095); */
            padding-left: 15px !important;
        }

        .thanhmenu > li > a {
            color: whitesmoke;
            font-size: 12px;
        }
        .thanhmenu > li > a > i {
            width: 20px;
        }
        .nav > li > a:hover {
            color: black;
        }
        .nav > li > a:focus {
            color: black;
        }
        .sidebar .nav-second-level li a {
            color: white;
        }
        .sidebar .nav-second-level li a:hover {
            color: black;
        }
        #back-to-top {
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 9999;
            width: 32px;
            height: 32px;
            text-align: center;
            line-height: 30px;
            background: #0B4C5F;
            color: #fff;
            cursor: pointer;
            border: 0;
            border-radius: 2px;
            text-decoration: none;
            transition: opacity 0.2s ease-out;
            opacity: 0.8;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.3);
            display: none;
        }
        .form-control.baoselect {
            border: none;
        }
        .form-control {
            height: 30px;
            font-size: 12px;
        }
        #back-to-top:hover {
            opacity: 1;
        }
        #back-to-top.show {
            opacity: 1;
            display: block;
        }
        ,
        .form-control {
            font-size: 12px !important;
        }
        .space10 {
            padding-bottom: 10px;
        }

        .space20 {
            padding-bottom: 20px;
        }

        .space30 {
            padding-bottom: 30px;
        }

        .space40 {
            padding-bottom: 40px;
        }

        .space50 {
            padding-bottom: 50px;
        }

        .space60 {
            padding-bottom: 60px;
        }

        .space70 {
            padding-bottom: 70px;
        }

        .space80 {
            padding-bottom: 80px;
        }

        .space90 {
            padding-bottom: 90px;
        }

        .space100 {
            padding-bottom: 100px;
        }

        .sidebar .nav-second-level li a {
            font-size: 12px;
        }

        .e-multiselect.e-checkbox .e-multi-select-wrapper {
            padding-left: 15px ! improtant;
            padding-top: 15px ! improtant;
        }

        .e-multiselect .e-multi-select-wrapper.e-down-icon,
        .e-multiselect.e-checkbox .e-multi-select-wrapper {
            padding: 0;
            /* margin-right:15px; */
            /* border: 1px solid #ccc; */
            border-radius: 4px;
            /* box-shadow: inset 0 1px 1px rgba(0,0,0,.095); */
            padding-left: 15px !important;
        }

        .thanhmenu > li > a {
            color: whitesmoke;
            font-size: 12px;
        }

        .thanhmenu > li > a > i {
            width: 20px;
        }

        .nav > li > a:hover {
            color: black;
        }

        .nav > li > a:focus {
            color: black;
        }

        .sidebar .nav-second-level li a {
            color: white;
        }

        .sidebar .nav-second-level li a:hover {
            color: black;
        }

        #back-to-top {
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 9999;
            width: 32px;
            height: 32px;
            text-align: center;
            line-height: 30px;
            background: #0B4C5F;
            color: #fff;
            cursor: pointer;
            border: 0;
            border-radius: 2px;
            text-decoration: none;
            transition: opacity 0.2s ease-out;
            opacity: 0.8;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.3);
            display: none;
        }

        #back-to-top:hover {
            opacity: 1;
        }

        #back-to-top.show {
            opacity: 1;
            display: block;
        }

        ,
        .form-control {
            font-size: 12px !important;
        },
        .pagination>.active>a{
            z-index:0;
        }
        /*  */
        /* @media only screen and (max-width: 1140px) {
            .container{
                display:none;
            }
            .dmk{
                display:none;
            }
            .container-fluid{
                display:block !important;
            }
        } */

        /*  */
    </style>
</head>
<body>
<div class="dmk">

    <div id="doimatkhau">
        <doi-mat-khau
            :info="'{{json_encode(get_user_info("common_info"))}}'"></doi-mat-khau>
    </div>
</div>
<div id="wrapper" class="container" style="padding:0;overflow: hidden;">
    <nav
        class="navbar navbar-default navbar-static-top"
        role="navigation"
        style="margin-bottom: 0">
        <div class="navbar-header">
            <button
                type="button"
                class="navbar-toggle"
                data-toggle="collapse"
                data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- -->
            <div>
                @if(strpos(get_full_url(), "csdlgiaoduc.thainguyen.gov.vn" ))
                    <img src="images/logoThaiNguyen.png" alt=""/>
                @elseif(get_user_info("common_info")["ma_so"]=="19")
                    <img src="images/logoThaiNguyen.png" alt=""/>
                @else
                    <img src="images/logo.png"alt=""/>
                @endif
            </div>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a
                    class="dropdown-toggle"
                    style=" color:0B4C5F;height:70px"
                    data-toggle="dropdown"
                    href="#">
                    {{get_user_info("fullName")}}
                    <i class="fa fa-user fa-fw"></i>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                <!-- <li><i class="fa fa-user fa-fw"></i>Chào: {{get_user_info("fullName")}} -->
                    <!-- </li> -->
                    <!-- <li><a href="/"><i class="fas fa-key"></i> Đổi mật khẩu</a></li> -->
                    <!-- <li class="divider"></li> -->
                    <li>
                        <a href="{{url('logout')}}">
                            <i class="fas fa-sign-out-alt"></i>
                            Đăng xuất</a>
                    </li>
                    <li>
                        <p style="padding:3px 20px;" class="doimatkhau">
                            <i class="fas fa-key" style="padding-right:3px;"></i>Đổi mật khẩu</p>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <marquee behavior="" direction=""><b style="color: red">Thông báo:</b> Hệ thống sẽ bảo trì để tiến hành nâng từ 12h00p - 05/03/2020 đến 12h15p - 05/03/2020.</marquee>
        </div>
    </div>
    <div class="row" style="background:#0B4C5F">
        <div class="col-sm-2">
            <div
                class="navbar-default sidebar"
                role="navigation"
                style="background:#0B4C5F">
                <div class="sidebar-collapse">
                    <ul class="nav thanhmenu" id="side-menu">
                        <?php echo $str?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-10">
            <div id="page-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
    <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        id="mdLoading"
        style="z-index: 20000"
        data-keyboard="false"
        data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="spinner"></div>
        </div>
    </div>
</div>
</div>
<a href="#" id="back-to-top" title="Back to top">&uarr;</a>
<script src="js/mlogger.js" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script
    src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/metisMenu.min.js" type="text/javascript"></script>
<script src="js/sb-admin-2.js" type="text/javascript"></script>
<script src="js/utils.js" type="text/javascript"></script>
<script src="js/bootstrap-dialog.min.js" type="text/javascript"></script>

@yield('js_location')
<script src="{{asset('js/doi-mat-khau.js')}}"></script>
<script src="{{asset('js/jquery.table.marge.js')}}"></script>
<script>
    $(document).ready(function () {
        let url = window.location;

        let element = $('ul#side-menu a').filter(function () {
            return this.href === url || url
                .href
                .indexOf(this.href) === 0;
        });

        $(element)
            .parentsUntil('ul#side-menu', 'li')
            .addClass('active');

        $("#mdLoading").on("show.bs.modal", () => {
            setTimeout(function () {
                $('.modal-backdrop')
                    .not('.modal-loading')
                    .css('z-index', 19999)
                    .addClass('modal-loading');
            }, 0);
        });
        $(".custom_md").on("show.bs.modal", function () {
            $(this).css('z-index', 1039);
            setTimeout(function () {
                $('.modal-backdrop')
                    .not('.modal-custom-dialog')
                    .css('z-index', 1038)
                    .addClass('modal-custom-dialog modal-loading');
            }, 0);
        });
    });
    if ($('#back-to-top').length) {
        var scrollTrigger = 200, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#back-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }
</script>
</body>
</html>
