<script>
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
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <script src="https://dongbo.csdl.edu.vn/cdn/js/jquery-1.12.4.min.js" type="text/javascript"></script>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="cdn/js/chinhsuatemplatebaocao.js" type="text/javascript"></script>
    <script src="cdn/js/danhsachtieuchi.js" type="text/javascript"></script>
    <script src="cdn/js/index.js" type="text/javascript"></script>
    <title>Chỉnh sửa template</title>
    <style>
        table {
            width: 100% !important
        }

        span.select2-dropdown.select2-dropdown--below {
            width: 400px !important;
        }

        span.select2.select2-container.select2-container--default {
            width: 100px !important;
        }

    </style>
    <script>
        $(document).ready(function () {});

    </script>
</head>

<body>
    <div class="container" style="border:1px solid red">
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
                <div id="danhsachtieuchi">
                    <danh-sach-tieu-chi></danh-sach-tieu-chi>
                </div>

            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <script src="{{asset('js/danh-sach-tieu-chi-trong-chinh-sua-template.js')}}"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>

</html>
