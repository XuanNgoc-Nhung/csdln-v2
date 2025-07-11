<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống CSDL</title>
    <link rel="stylesheet" href="cdn/css/bootstrap.min.css">
    <link href="{{convertHttps(url("/"))}}/font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet">
    <link href="{{convertHttps(url("/"))}}/css/sb-admin-2.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    .container {}

    body {
        height: 100vh;
        background: url("images/hinhnen.jpg");
        background-position: center;
        background-repeat: repeat-x;
        background-size: cover;
    }

    .formdangnhap .login-panel {
        background-color: rgba(255, 255, 255, 0.7);
    }

    .formdangnhap button {
        opacity: 1;
    }

    .panel-body {
        width: 85%;
        margin: 0 auto;
    }

    .captchar {
        position: relative
    }

    .captchar img {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: auto;
    }

</style>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-6 col-sm-offset-6 col-md-6 col-sm-6 formdangnhap">
                <div class="login-panel panel panel-default" style="padding:30px 0 50px 0;">
                    <div class="panel-body" style="padding-bottom:0; margin-bottom:0;">
                        @if(strpos(get_full_url(), "csdlSgiaoduc.thainguyen.gov.vn"))
                        <img src="images/logoThaiNguyen.png" alt="Sở giáo dục và đào tạo Thái Nguyên" />
                        @elseif(strpos(get_full_url(), "csdl.quangtri.edu.vn"))
                        <div class="logoQuangTri">
                            <img width="80%" src="images/logoQuangTri.png" alt="Sở giáo dục và đào tạo Quảng Trị" />
                        </div> @elseif(strpos(get_full_url(), "csdl.gialai.edu.vn"))
                        <div class="logoQuangTri">
                            <img width="80%" src="images/logoGiaLai.png" alt="Sở giáo dục và đào tạo Gia Lai" />
                        </div>
                        @else
                        <img src="images/logo.png" style="height:50px;" alt="" />
                        @endif
                    </div>
                    <div class="panel-body">
                        <form ole="form" id="loginForm" method="post" autocomplete="off" action="{{route('login')}}">
                            @csrf
                            <fieldset>
                                <div class="form-group" style="padding-bottom:15px;">
                                    <label>Tên đăng nhập:</label>
                                    <div class="input-username">
                                        <input autocomplete="off" class="form-control" placeholder="Tên đăng nhập"
                                            name="username" type="text" autocomplete="false"
                                            value="{{old('username')}}">
                                    </div>
                                    @if ($errors->has('username'))
                                    <span class="help-block" style="color: red">
                                        <i><strong class="error-user"></strong></i>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group" style="">
                                    <label>Mật khẩu:</label>
                                    <input class="form-control" placeholder="Mật khẩu" name="password" type="password"
                                        autocomplete="password" value="{{old('password')}}">
                                    @if ($errors->has('password'))
                                    <span class="help-block" style="color: red">
                                        <i><strong>{{ $errors->first('password') }}</strong></i>
                                    </span>
                                    @endif
                                </div>
                                @if(Session::get('tokenCap'))
                                <div class="form-group captchar" style="">
                                    <input type="hidden" name="tokenCap" value="{{Session::get('tokenCap')}}">
                                    <input class="form-control" placeholder="Nhập mã captcha" name="captcha" type="text"
                                        value="">
                                    <img src="data:image/png;base64, {{Session::get('dataImage')}}" alt="captcha">
                                </div>
                                @endif
                                <div style="padding-top: 15px;">
                                    <input style="background: #36a491" id='buttonLogin' type="submit" value="Đăng nhập"
                                        class="btn btn-success btn-block btn-flat" disabled />
                                </div>
                                <div style="margin-top: 5px; ">
                                    <button id="butonLoginSSO" class="btn btn-primary btn-block btn-flat">Đăng nhập
                                        SSO</button>
                                    <a style="padding: 10px 15px; display:none"
                                        class="btn btn-primary btn-block btn-flat"
                                        href="https://sso-edu.viettel.vn/?page=Account.App.login&userId=5d54db0b62aa4af4283fbf04">
                                        Đăng nhập SSO </a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="cdn/js/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="cdn/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            console.log("xóa localstorage")
            localStorage.clear();
            var checkUsername = $('input[name="username"]').val();
            console.log('checkUsername:' + checkUsername);
            
            var checkPassword = $('input[name="password"]').val();
            console.log('checkPassword:' + checkPassword);

            if (!checkUsername && !checkPassword) {
                $('#buttonLogin').prop('disabled', true);
            }

            console.log('check ^^^^^^');
            
            $("#butonLoginSSO").click(function (event) {
                event.preventDefault();
                // let url = 'https://sso-edu.viettel.vn/?page=Account.App.login&userId=5d54db0b62aa4af4283fbf04';
                //
                // window.location.href = url;
                // return;
                $.ajax({
                    type: 'POST',
                    url: '/get_code_sso',
                    data: {},
                }).done(function (response) {
                    data = JSON.parse(response)
                    console.log("data")
                    console.log(data)
                    if (data.rc == 0) {
                        let code_challenge = data.code_challenge;
                        let params = {
                            response_type: 'code',
                            Issuer: 'https://id.nentanggiaoduc.edu.vn',
                            redirect_uri: 'https://dongbo.csdl.edu.vn/sso/login.html',
                            postLogoutRedirectUri: 'https://dongbo.csdl.edu.vn/sso/logout.html',
                            client_id: 'csdln_client',
                            state: generateString(5),
                            scope: 'openid profile offline_access esmartup',
                            code_challenge: code_challenge,
                            code_challenge_method: 'S256',
                        };
                        let query = objectToQueryString(params);
                        let urlLogin = 'https://id.nentanggiaoduc.edu.vn/connect/authorize?'+query;
                        console.log(JSON.stringify(urlLogin))
                        navigator.clipboard.writeText(urlLogin);
                        // return;
                        window.location.href = urlLogin;
                    }
                    return
                });
            });
            function generateString(length) {
                let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let result = '';
                const charactersLength = characters.length;
                for (let i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            };

            function objectToQueryString(obj) {
                let str = [];
                for (let p in obj)
                    if (obj.hasOwnProperty(p)) {
                        str.push(p + "=" + obj[p]);
                    }
                return str.join("&");
            }
            jQuery('input[name=password]').val('');
            if (jQuery('input[name=username]').val().trim() != '' && jQuery('input[name=username]').val()
                .trim()) {
                jQuery("#buttonLogin").attr("disabled", false);
            }
            jQuery('input[name=password]').on('input', function () {
                var value = $(this).val();
                if (value.length >= 4 && value.trim() != "") {
                    if (jQuery('input[name=username]').val().trim() != '') {
                        jQuery("#buttonLogin").attr("disabled", false);
                    }
                } else {
                jQuery("#buttonLogin").attr("disabled", true);
                }
            });
            jQuery('input[name=username]').on('input', function () {
                let value = $(this).val();
                if (value.trim() != "") {
                    if (jQuery('input[name=password]').val().trim() != '' && $('input[name=password]')
                        .val().length >= 4) {
                            jQuery("#buttonLogin").attr("disabled", false);
                    }
                } else {
                    jQuery("#buttonLogin").attr("disabled", true);
                }
            });
        });

    </script>
</body>

</html>
