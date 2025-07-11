<!doctype html>
<html style="height:100%;font-size:14px;">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SystemJS -->

    <script>

    </script>
</head>
<body>
<div id="app">
    <view-excel></view-excel>
</div>
<script src="{{asset('js/view-excel.js?t=1')}}"></script>
</body>
</html>
