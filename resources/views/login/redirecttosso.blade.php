<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống CSDL</title>
</head>
<body>
<div>
    <input type="hidden" id="postLogoutRedirectUri" value="{{$postLogoutRedirectUri}}">
    <input type="hidden" id="redirect_uri" value="{{$redirect_uri}}">
</div>
    <script src="cdn/js/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            console.log("xóa localstorage")
            localStorage.clear();
            redirectToSso();
            function redirectToSso(){
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
                        var postLogoutRedirectUri = $('#postLogoutRedirectUri').val()
                        var redirect_uri = $('#redirect_uri').val()
                        let params = {
                            response_type: 'code',
                            Issuer: 'https://id.nentanggiaoduc.edu.vn',
                            redirect_uri: redirect_uri,
                            postLogoutRedirectUri: postLogoutRedirectUri,
                            client_id: 'csdln_client',
                            state: generateString(5),
                            scope: 'openid profile offline_access esmartup',
                            code_challenge: code_challenge,
                            code_challenge_method: 'S256',
                        };
                        let query = objectToQueryString(params);
                        let urlLogin = 'https://id.nentanggiaoduc.edu.vn/connect/authorize?'+query;
                        let DomainPath = window.location.hostname;
                        if (DomainPath == 'csdl.bentre.edu.vn') {
                            urlLogin ='https://id.bentre.edu.vn/connect/authorize?' + query;
                            params.Issuer = 'https://id.bentre.edu.vn'
                        }
                        
                        window.location.href = urlLogin;
                    }
                    return
                });
            }
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
        });
    </script>
</body>
</html>
