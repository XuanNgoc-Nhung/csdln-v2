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
    <title>Clone tiêu chí</title>
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

        span#maTieuChiClone: {
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
                    <input type="hidden" id="idTieuChi" value={{$idTieuChi}}>
                    <input type="hidden" id="maTieuChi">
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
                        <label>Đối tượng áp dụng<span class="required">*</span></label>
                        <select id="doiTuongApDung" class="imputTimKiem imputTimKiemDoiTuong form-control">
                        </select>
                    </div>
                </div>
                <div class="col-sm-3 phuongPhapTinh">
                    <div class="form-group">
                        <label>Phương pháp tính <span class="required">*</span></label>
                        <select id="phuongPhapTinh" class="imputTimKiem imputTimKiemPhuongPhap form-control">
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
            </div>
            <div class="col-sm-12">
                <div id="builder-basic"></div>
            </div>
            <div class="row" style="padding:20px">
                <div class="col-md-12 text-center">
                    <button id="btn-themTieu-Chi" class="btn btn-primary">Thêm mới</button>
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
            margin: 5 px;" id="maTieuChiClone"></span> </p>
                    <p>Bạn có thể đóng cửa sổ trình duyệt này!</p>
                    <button id="hienThiThemTieuChi" class="btn btn-success">Thêm mới</button>
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
        var list_doi_tuong = [{
                id: 'GiaoVien',
                text: 'Cán bộ, Giáo viên'
            },
            {
                id: 'LopHoc',
                text: 'Lớp học'
            },
            {
                id: 'KQHT',
                text: 'Kết quả học tập'
            },
            {
                id: 'TruongHoc',
                text: 'Trường học, Điểm trường'
            },
            {
                id: 'HocSinh',
                text: 'Học sinh',
            },
            {
                id: 'Custom',
                text: 'Tiêu chí ngoài',
            }
        ];
        var list_phuong_phap = [{
                id: 'count',
                text: 'Đếm (count)'
            },
            {
                id: 'sum',
                text: 'Cộng (sum)'
            },
            {
                id: 'avg',
                text: 'Trung bình (avg)'
            },
            {
                id: 'TruongHoc',
                text: 'Trường học, điểm trường'
            },
        ];
        var mang_sme = [];
        $(document).ready(function () {
            console.log("Sẵn sàng:")
            getValue();
            var idTieuChi = $('#idTieuChi').val();
            console.log("Chỉnh sửa tiêu chí báo cáo có id là:" + idTieuChi)
            layThongTinTieuChi(idTieuChi);

        })

        function layThongTinTieuChi(e) {
            $body.addClass("loading");
            $.ajax({
                url: '/api-lay-thong-tin-tieu-chi',
                type: 'GET',
                dataType: 'json',
                data: {
                    idTieuChi: e,
                }
            }).done(function (ketqua) {
                $body.removeClass("loading");
                console.log(ketqua);
                if (ketqua.rc == 0) {
                    var thongTinTieuChi = ketqua.item;
                    ganDuLieuTieuChi(thongTinTieuChi);
                } else {
                    NotiError("Không lấy được thông tin chỉnh sửa. Vui lòng thử lại sau");
                }
            });
        }

        function ganDuLieuTieuChi(e) {
            console.log("Gán dữ liệu tiêu chí")
            console.log(e)
            let thong_tin = e;
            console.log("Đối tượng")
            console.log(JSON.stringify(thong_tin));
            $('#tenTieuChi').val(thong_tin.tenTieuChi);
            $('#moTa').val(thong_tin.moTa);
            $('#maTieuChi').val(thong_tin.maTieuChi);
            if (thong_tin.tag) {
                if (thong_tin.tag.length > 0) {
                    for (let i = 0; i < thong_tin.tag.length; i++) {
                        $('#Tags').tagsinput('add', thong_tin.tag[i]);
                    }
                }
            }
            for (let i = 0; i < list_doi_tuong.length; i++) {
                list_doi_tuong[i].disabled = false;
                if (list_doi_tuong[i].id == thong_tin.doiTuong) {
                    list_doi_tuong[i].selected = true;

                }
            }
            var doiTuongApDung = thong_tin.doiTuong;
            $('.imputTimKiemDoiTuong').select2({
                data: list_doi_tuong
            });
            if (thong_tin.doiTuong != 'Custom') {

                $('.phuongPhapTinh').css({
                    "display": "block",
                });
                for (let i = 0; i < list_phuong_phap.length; i++) {
                    list_phuong_phap[i].disabled = false;
                    if (list_phuong_phap[i].id == thong_tin.calculation) {
                        list_phuong_phap[i].selected = true;
                    }
                }
                $('.imputTimKiemPhuongPhap').select2({
                    data: list_phuong_phap
                });

                $body.addClass("loading");
                $.ajax({
                    url: '/api-lay-sme-theo-doi-tuong',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        doiTuongApDung: doiTuongApDung,
                    }
                }).done(function (ketqua) {
                    $body.removeClass("loading");
                    console.log(ketqua);
                    $('select').select2();
                    if (ketqua.rc == 0) {
                        mang_filter = [];
                        let du_lieu_tra_ve = ketqua.tableData;
                        for (let i = 0; i < du_lieu_tra_ve.length; i++) {
                            let obj = {
                                id: du_lieu_tra_ve[i].mongoEntityField,
                                label: du_lieu_tra_ve[i].moetExcelValue,
                                input: du_lieu_tra_ve[i].inputType,
                                type: du_lieu_tra_ve[i].entityDataType,
                                values: getValues(du_lieu_tra_ve[i].constantType),
                            }
                            mang_filter.push(obj);
                        }
                        buildQueryBuilderUpdate(mang_filter, thong_tin)
                    } else {
                        alert(ketqua.rd)
                        let rong = []
                        buildQueryBuilderUpdate(rong, thong_tin)
                    }
                });
            } else {
                $('.phuongPhapTinh').css({
                    "display": "none",
                });
            }

        }

        function buildQueryBuilderUpdate(e, b) {
            $('select').select2();
            console.log("Buid cho mảng 222:")
            var rules_basic = b.filters;
            console.log(rules_basic);
            console.log(e);
            $('#builder-basic').queryBuilder({
                filters: e,
                rules: rules_basic,
                sort_filters: true,
            });
        }

        function getValues(e) {
            let arr = {
                value: [],
            }
            if (localStorage[e]) {
                arr = JSON.parse(localStorage[e]);
            }
            let pr = arr.value;
            return pr;
        }

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

<script src="quanlytieuchi/query-builder.js"></script>
<script src="quanlytieuchi/clonetieuchi.js"></script>

</html>
