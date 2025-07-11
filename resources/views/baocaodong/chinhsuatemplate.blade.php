<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.jqueryui.min.css">

    <!-- javascript -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>
    <script src="cdn/js/chinhsuatemplate-final.js" type="text/javascript"></script>
    <!-- <script src="cdn/js/templateTieuChi.js" type="text/javascript"></script> -->
    <title>Chỉnh sửa template báo cáo </title>
    <style>
        table{
            width:100% !important
        }
        #tuychonhienthi span {
            padding-right: 30px;
            font-size: 12px;
            color: blue;
        }

        .displayNnone {
            display: none !important;
        }

        td {
            padding: 5px !important;
            font-size: 12px;
        }

        tr.even {
            background-color: whitesmoke !important;
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
            /* font-size:13pt */
        }

        legend {
            background-color: gray;
            color: white;
            padding: 5px 10px;
            margin-bottom: 0px;
        }

        span.select2-dropdown.select2-dropdown--below {
            width: 400px !important;
        }

        span.select2.select2-container.select2-container--default {
            width: 100px !important;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if($dataHtml)
                {!!$dataHtml!!}
                @else
                <div class="text-center">
                    <h3>Báo cáo này chưa có dữ liệu. Vui lòng thử lại sau.</h3>
                </div>
                @endif
            </div>
        </div>
        <div class="row text-center" style="padding-top:15px;">
            @if($dataHtml)
            <button class="btn btn-primary" id="mapDuLieuChinhSua">
                Chỉnh sửa
            </button>
            @endif
            <input type="hidden" id="idBaoCao" name="idBaoCao" value={{$idBaoCao}}>
        </div>
    </div>
</body>

</html>
