<script>
    window.userInfo = '{!! json_encode(get_user_info("common_info")) !!}';
    let dsch = '<?php echo($lch) ?>';
    let dsch2 = JSON.parse(dsch)
    window.listCapHoc = dsch2;
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <base href="{{asset('')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="ioc/css/all.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet"
        href="https://www.jqueryscript.net/demo/Simple-Easy-jQuery-Notification-Plugin-NotifIt/css/notifIt.css">
    <link rel="stylesheet" href="ioc/css/adminlte.css">
    <link rel="stylesheet" href="ioc/css/OverlayScrollbars.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" hre?f="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <title>Trang chủ || IOC</title>
    <link href="css/cssCustom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="cdn/css/ioc.css" type="text/css" />
    <link href="css/indexElementUi.css" rel="stylesheet" type="text/css" /><!-- import CSS -->
    <link href="css/indexElementUiCusstom.css" rel="stylesheet" type="text/css" /><!-- import CSS -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        
    <div id="app">
        <trang-chu-ioc></trang-chu-ioc>
    </div>
    </div>
    <script src="{{asset('js/trang-chu-ioc.js')}}"></script>
    
    <script src="ioc/js/jquery.js"></script>
        <script src="ioc/js/overlayScrollbars.js"></script>
        <script src="ioc/js/adminlte.js"></script>
        <script src="ioc/js/demo.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
        </script>
        <!-- <script src="js/ioc_constant.js" type="text/javascript"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
        <!-- <script src="js/ioc.js" type="text/javascript"></script> -->
        <!-- <script src="js/ioc_index.js" type="text/javascript"></script> -->
        <!-- <script src="https://www.jqueryscript.net/demo/Simple-Easy-jQuery-Notification-Plugin-NotifIt/js/notifIt.js"> -->
        </script>
</body>

</html>
