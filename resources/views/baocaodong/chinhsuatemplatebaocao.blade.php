<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chỉnh sửa template báo cáo</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.jqueryui.min.js"></script>
    <script>
        $(function () {
            $("#tabs").tabs();
        });
        $(document).ready(function () {

        });

    </script>
    <style>
        .dataTables_length {
            width: 50%;
            float: left;
        }

        .dataTables_filter {
            width: 50%;
            float: right;
            text-align: right;
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
        <div id="tabs">
            <ul>
                <li><a href="#danh-sach-tieu-chi">Danh sách tiêu chí</a></li>
                <li><a href="#chinh-sua-tieu-chi">Chỉnh sửa</a></li>
            </ul>
            <div id="chinh-sua-tieu-chi">
                <p>Chỉnh sửa template tiêu chí</p>
            </div>
            <div id="danh-sach-tieu-chi">
                <div class="row">
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="theLoai">
                    </div>
                    <div class="col-sm-2">

                        <button type="submit" id="addRow" class="btn btn-primary">Tìm kiếm</button>
                        <button type="submit" id="XoaDuLieu" class="btn btn-primary">Xóa</button>
                    </div>
                </div>
                <hr>
                <!-- Bảng -->
                <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr class="text-center">
                            <th class="th-sm">STT
                            </th>
                            <th class="th-sm">Tên tiêu chí
                            </th>
                            <th class="th-sm">Mã tiêu chí
                            </th>
                            <th class="th-sm">Đối tượng
                            </th>
                            <th class="th-sm">Thẻ Tags
                            </th>
                            <th class="th-sm">Mô tả
                            </th>
                            <th class="th-sm">Tùy chọn
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

<script src="baocaodong/dataTable.js"></script>

</html>
