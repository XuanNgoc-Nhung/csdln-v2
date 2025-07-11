<?php
$cate_menu = session("cate_menu", []);
// dd($cate_menu);
$doipass = session("user", []);
$str = '';
$tenDangNhap = get_user_info("fullName");
$tenDacBiet=htmlspecialchars_decode($tenDangNhap,ENT_QUOTES);
$tenDacBiet1 = str_replace("'", "&dacbiet1", $tenDacBiet);
$tenDacBiet2 = str_replace('"', "&dacbiet2", $tenDacBiet1);
$tenDacBiet2 = str_replace("\\", "&dacbiet3", $tenDacBiet2);
// $tenDacBiet2 = str_replace(']', "&dacbiet4", $tenDacBiet2);
?>

<script src="https://dongbo.csdl.edu.vn/cdn/js/jquery-1.12.4.min.js" type="text/javascript"></script>
<script>
    console.log(
        "%cDừng lại!",
        "color:red;font-family:system-ui;font-size:4rem;-webkit-text-stroke: 1px black;font-weight:bold"
    );

    console.log('\x1b[35m%s\x1b[34m%s\x1b[0m', 'Đây là một tính năng của nhà phát triển. Vui lòng quay trở lại.',
        'Xin cảm ơn.');
    console.log = function () {};
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
    // let res = "\";
    // let res = '\';
    console.log("Danh sách cấp học:");
    console.log(window.userInfo);
    // console.log(window.listCapHoc);
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
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cơ sở dữ liệu ngành</title>
    <base href="{{asset('')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" property="base-url" content="{!! url(" /") !!}" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js">
    </script><!-- import CSS -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <!-- import JavaScript -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>

</head>

<body>

    <div class="container-fluid" style="border:1px solid red">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Chỉnh sửa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">Danh sách tiêu chí</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Danh sách tiêu chí

                @yield('content')

            </div>
        </div>
    </div>
    </div>
    @yield('js_location')
</body>

</html>
