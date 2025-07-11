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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="cdn/js/chinhsuatemplate-final.js" type="text/javascript"></script><!-- import CSS -->
    <style>
        table {
            width: 100%;
        }

        .fixed {
            position: fixed;
            top: 0;
            right: 0;
            width: 300px;
            border: 3px solid #73AD21;
        }

        th.sorting.ui-state-default {
            text-align: center;
        }

        .collapse>.card {
            display: none;
        }

        .in {
            height: 93vh !important;
            display: inline-block
        }

        .in>.card {
            display: block;
        }

        hr {

            background: silver;
            height: 1px;
            width: 50%;
        }

        fieldset {
            background-color: #eeeeee;
        }

        legend {
            background-color: gray;
            color: white;
            padding: 5px 10px;
            margin-bottom: 0px;
        }

        span.select2-dropdown.select2-dropdown--below {
            width: 500px !important;
        }

        span.select2.select2-container.select2-container--default {
            width: 150px !important;
        }


        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.7)
        }

        body.loading {
            overflow: hidden;
        }

        body.loading .modal {
            display: block;
        }

    </style>
</head>

<body>
<div class="container-fluid">
    <div class="modal text-center">
        <img src="https://icon-library.com/images/loading-icon-animated-gif/loading-icon-animated-gif-7.jpg"
            alt="Loading" style="width:5%; padding-top:50px">
        <p style="color:white">Loading...</p>
    </div>
    <div class="container-fluid" style="border:1px solid Silver">
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
                @if($dataHtml)
                {!!$dataHtml!!}
                @else
                <div class="text-center">
                    <h3>Báo cáo này chưa có dữ liệu. Vui lòng thử lại sau.</h3>
                </div>
                @endif
                <div class="text-center">
                    @if($dataHtml)
                    <button class="btn btn-primary" id="buttonChinhSua">Chỉnh
                        sửa</button>
                    @else
                    @endif
                    <input type="hidden" id="idBaoCao" name="idBaoCao" value={{$idBaoCao}}>
                </div>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Danh sách tiêu chí
            </div>
        </div>
    </div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

</body>

</html>
