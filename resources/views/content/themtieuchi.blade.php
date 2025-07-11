<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="quanlytieuchi/index.den.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="quanlytieuchi/index.css">
    <link rel="stylesheet" href="quanlytieuchi/bootstrap.css">
    <link rel="stylesheet"
        href="https://www.jqueryscript.net/demo/Simple-Easy-jQuery-Notification-Plugin-NotifIt/css/notifIt.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <script src="cdn/js/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="quanlytieuchi/query-builder.standalone.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://www.jqueryscript.net/demo/Simple-Easy-jQuery-Notification-Plugin-NotifIt/js/notifIt.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <title>Thêm tiêu chí</title>
    <style>
        input {
            height: 28px;
        }

        .rules-group-container {
            width: 100%;
        }

        .btn {
            margin: 0px 1px 5px !important;
            padding: 0px 5px !important;
        }

        select.form-control {
            height: 28px !important;
            padding: 0;
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

        .container {

            background: oldlace;
            margin-top: 50px;
            border-radius: 5px;
            padding-top: 20px;
        }

        .jc-bs3-container {
            background: none;
        }

        .required {
            color: red
        }

        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: white;
            border-radius: 4px;
            background: #3485AA;
            padding-left: 5px;
        }

        .bootstrap-tagsinput {
            height: 28px !important;
            width: 100%;
            padding: 0px 1px !important;
        }

        .select2-container--default {
            width: 100% !important;
            min-width: 250px !important;
        }

        select.form-control:not([size]):not([multiple]) {
            width: 100% !important;
        }

        input[placeholder="+"] {
            width: 30px
        }

        .query-builder .rule-value-container label {

            display: inline-flex;
        }

        #maTieuChi: {
            color: rgb(0 0 255);
            background: rgb(255 180 118);
            font-weight: bold;
            margin: 5 px;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="show_add" style="display:block">
            <div class="row">
                <div class="col-md-12">
                    <h4 style="margin:0">THÊM TIÊU CHÍ</h4>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Tên tiêu chí <span class="required">*</span></label>
                        <input id="tenTieuChi" type="text" class="form-control" placeholder="Nhập">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Đối tượng áp dụng <span class="required">*</span></label>
                        <select id="doiTuongApDung" class="imputTimKiem form-control">
                            <option value="">Chọn đối tượng áp dụng</option>
                            <option value="GiaoVien">Cán bộ, Giáo viên</option>
                            <option value="LopHoc">Lớp học</option>
                            <option value="KQHT">Kết quả học tập</option>
                            <option value="TruongHoc">Trường học, Điểm trường</option>
                            <option value="HocSinh">Học sinh</option>
                            <option value="Custom">Tiêu chí ngoài</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 phuongPhapTinh">
                    <div class="form-group">
                        <label>Phương pháp tính <span class="required">*</span></label>
                        <select id="phuongPhapTinh" class="imputTimKiem form-control">
                            <option value="count">Đếm (count)</option>
                            <option value="sum">Cộng (sum)</option>
                            <option value="avg">Trung bình</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Thẻ <span class="required">*</span></label>
                        <input id="Tags" type="text" value="" class="form-control" data-role="tagsinput" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Mô tả <span class="required">*</span></label>
                        <input id="moTa" type="text" class="form-control" placeholder="Nhập">
                    </div>
                </div>
                <!-- <div class="col-sm-6">
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <input id="ghiChu" type="text" class="form-control" placeholder="Nhập">
                    </div>
                </div> -->
            </div>
            <div class="col-sm-12">
                <div id="builder-basic"></div>
            </div>
            <div class="row" style="padding:20px">
                <div class="col-md-12 text-center">
                    <button id="btn-themTieu-Chi" class="btn btn-primary">Thêm tiêu chí</button>
                </div>
            </div>
        </div>
        <div class="show_done" style="display:none">
            <div class="row-">
                <div class="col-md-12 text-center">
                    <p>Thêm tiêu chí thành công. Tiêu chí có mã là <span style="
            color: rgb(0 0 255);
            background: rgb(255 180 118);
            font-weight: bold;
            margin: 5 px;" id="maTieuChi"></span> </p>
                    <p>Bạn có thể đóng cửa sổ trình duyệt này!</p>
                    <button id="hienThiThemTieuChi" class="btn btn-success">Thêm tiêu chí mới</button>
                </div>
            </div>
        </div>
        <div class="modal text-center">
            <img src="https://icon-library.com/images/loading-icon-animated-gif/loading-icon-animated-gif-7.jpg"
                alt="Loading" style="width:5%; padding-top:50px">
            <p style="color:white">Loading...</p>
        </div>
    </div>

    <script>
        $body = $("body");
        $('select').select2();
        var mang_sme = [];
        $(document).ready(function () {
            $('.imputTimKiem').select2();
            console.log("Sẵn sàng:")
            getValue();



        })

        function getValue() {
            $body.addClass("loading");
            $.ajax({
                url: '/api-lay-toan-bo-sme-mappingcode',
                type: 'GET',
                dataType: 'json',
                data: {
                    type: "2",
                }
            }).done(function (ketqua) {
                $body.removeClass("loading");
                console.log(ketqua);
                if (ketqua.rc == 0) {
                    mang_sme = [];
                    let du_lieu_tra_ve = ketqua.tableData;
                    for (let i = 0; i < du_lieu_tra_ve.length; i++) {
                        let gia_tri = [];
                        let name = du_lieu_tra_ve[i].constantType;
                        for (let j = 0; j < du_lieu_tra_ve[i].list_data.length; j++) {
                            let obj = {
                                value: du_lieu_tra_ve[i].list_data[j].mappingCode,
                                label: du_lieu_tra_ve[i].list_data[j].constantTitle,
                            }
                            if (du_lieu_tra_ve[i].list_data[j].constantType == "DM_NHOM_CAP_HOC") {
                                obj.value = du_lieu_tra_ve[i].list_data[j].constantCode
                            }
                            gia_tri.push(obj);
                        }
                        let moi_ban_ghi = {
                            name: name,
                            value: gia_tri
                        }
                        mang_sme.push(moi_ban_ghi);
                    }
                    console.log("*************")
                    console.log(mang_sme)
                    for (let i = 0; i < mang_sme.length; i++) {
                        localStorage[mang_sme[i].name] = JSON.stringify(mang_sme[i])
                    }
                } else {
                    alert(ketqua.rd)
                }
            });
        }

    </script>
</body>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script src="quanlytieuchi/query-builder.js"></script>
<script src="quanlytieuchi/themtieuchi.js"></script>

</html>
