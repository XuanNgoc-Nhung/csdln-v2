<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đăng nhập hệ thống</title>
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
            integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu"
            crossorigin="anonymous">
        <link
            href="{{url("/")}}/font-awesome-4.1.0/css/font-awesome.css"
            rel="stylesheet">
        <link href="{{url("/")}}/css/sb-admin-2.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

<style>

.container{

}
body{
    height:100vh;
    background:url("images/hinhnen.jpg");
    background-position: center;
    background-repeat: repeat-x;
    background-size: cover;
}
.formdangnhap{
    opacity:0.7;
}
.formdangnhap button{
    opacity:1;
}
.panel-body{

    width:85%;
    margin: 0 auto;
}

/* @media  only screen and (max-width: 991px) {
    .formdangnhap{

    } */
/* } */
</style>


    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-6 col-sm-offset-6 col-md-6 col-sm-6 formdangnhap" style="border:1px solid red">
                    <div class="login-panel panel panel-default" style="padding:30px 0 50px 0; border:2px solid blue">
                        <div class="panel-body" style="padding-bottom:0; margin-bottom:0;">
                            <img
                                style="display: block;max-width: 100%;height: auto;"
                                src="images/logo.png"
                                alt="">
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="{{asset("/login")}}">
                                @csrf
                                <fieldset>
                                    <div class="form-group" style="padding-bottom:15px;">
                                        <label>Tên đăng dnhập:</label>
                                        <input
                                            class="form-control"
                                            placeholder="Tên đăng nhập"
                                            name="username"
                                            type="text"
                                            autofocus="autofocus">
                                        @if ($errors->has('username'))
                                        <span class="help-block" style="color: red">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group" style="padding-bottom:15px;">
                                        <label>Mật khẩu:</label>
                                        <input
                                            class="form-control"
                                            placeholder="Mật khẩu"
                                            name="password"
                                            type="password"
                                            value="">
                                        @if ($errors->has('password'))
                                        <span class="help-block" style="color: red">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div style="margin-top: 5px;">
                                        <input
                                            style="background: #36a491"
                                            type="submit"
                                            value="Đăng nhập"
                                            class="btn btn-lg btn-success btn-block"/>
                                    </div>
                                    @if(1>2)

{{--                                    <div style="margin-top: 5px; ">--}}
{{--                                        <a--}}
{{--                                            style="padding: 10px 15px;"--}}
{{--                                            class="btn btn-primary btn-block btn-flat"--}}
{{--                                            href="https://sso-edu.viettel.vn/?page=Account.App.login&userId=5d54db0b62aa4af4283fbf04">--}}
{{--                                            Đăng nhập SSO--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
                                    @endif
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script
            src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
            crossorigin="anonymous"></script>
        <script
            src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>
    </body>

</html>
