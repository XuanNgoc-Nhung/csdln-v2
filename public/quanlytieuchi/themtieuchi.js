var doiTuongApDung = "GiaoVien";
var mang_filter = [];
$(document).ready(function () {
    mang_filter = [];
    $('#doiTuongApDung').change(function () {
        console.log("Chọn đối tượng")
        doiTuongApDung = $("#doiTuongApDung").val();
        console.log("Chọn đối tượng áp dụng:")
        console.log(doiTuongApDung);
        if (doiTuongApDung == 'Custom') {
            console.log("Tiêu chí ngoài")
            $('#builder-basic').queryBuilder('destroy');

            $('.phuongPhapTinh').css({
                "display": "none",
            });
        } else {
            $('.phuongPhapTinh').css({
                "display": "block",
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
                if (ketqua.rc == 0) {
                    mang_filter = [];
                    let du_lieu_tra_ve = ketqua.tableData;
                    for (let i = 0; i < du_lieu_tra_ve.length; i++) {
                        let obj = {
                            id: du_lieu_tra_ve[i].mongoEntityField,
                            label: du_lieu_tra_ve[i].moetExcelValue,
                            input: du_lieu_tra_ve[i].inputType,
                            type: du_lieu_tra_ve[i].entityDataType,
                            values: getValue(du_lieu_tra_ve[i].constantType),
                        }
                        mang_filter.push(obj);
                    }
                    buildQueryBuilder(mang_filter)
                    localStorage.setItem('dieu_kien_and_nhom_dieu_kien', 'true');
                    $('select').select2();
                    $('select').select2({
                        "width": "400px",
                    });
                } else {
                    NotiError(ketqua.rd)
                    let rong = []
                    localStorage.setItem('dieu_kien_and_nhom_dieu_kien', 'false');
                    buildQueryBuilder(rong)
                }
                return;
            });
        }
    });
    $('#hienThiThemTieuChi').click(function () {

        $('.show_add').css({
            "display": "block",
        });
        $('.show_done').css({
            "display": "none",
        });
    });
    // gán giá trị
    // function getValue(e) {
    //     let arr = JSON.parse(localStorage[e]);
    //     let pr = arr.value;
    //     return pr;
    // }
    // gán giá trị
    function getValue(e) {
        let tmp = localStorage[e];
        let arr = {
            value: []
        };
        if (tmp) {
            arr = JSON.parse(localStorage[e]);
        }
        let pr = arr.value;
        return pr;
    }

    function buildQueryBuilder(e) {
        console.log("Buid cho mảng:")
        if (e.length == 0) {
            e = [{
                id: 'dts-group-null-value',
                label: 'Name',
                type: 'string'
            }, ]
        }
        $('#builder-basic').queryBuilder({
            filters: e,
            sort_filters: true,
        });
        $('#builder-basic').queryBuilder('reset');
        $('#builder-basic').queryBuilder('destroy');
        $('#builder-basic').queryBuilder({
            filters: e,
            sort_filters: true,
        });
        console.log("sau khi build lại");
        console.log(e)
        if (e.length == 1 && e[0].id == 'dts-group-null-value') {
            $('#builder-basic').queryBuilder('destroy');
            NotiError("Đối tượng áp dụng này chưa có thông tin điều kiện");
        }
    }
});
$('#btn-themTieu-Chi').on('click', function () {
    console.log("ahihihih ******")
    var ten_tieu_chi = $("#tenTieuChi").val();
    var doi_tuong_ap_dung = $("#doiTuongApDung").val();
    console.log("hihi123")
    var phuong_phap = $("#phuongPhapTinh").val();
    console.log("hihi121523")
    var the_tags = $('#Tags').tagsinput('items')
    console.log("hihi12773")
    console.log(the_tags)
    var mo_ta = $("#moTa").val();
    if (!ten_tieu_chi) {
        NotiError("Thiếu tên tiêu chí");
        return
    }
    if (!doi_tuong_ap_dung) {
        NotiError("Thiếu đối tượng áp dụng");
        return
    }
    if (localStorage["dieu_kien_and_nhom_dieu_kien"] == 'false') {
        NotiError("Chọn đối tượng khác sau đó bổ sung điều kiện hoặc nhóm điều kiện");
        return
    }
    if (!phuong_phap) {
        NotiError("Thiếu phương pháp tính");
        return
    }
    if (!the_tags || the_tags.length == 0) {
        NotiError("Thiếu thẻ tags");
        return
    }
    if (!mo_ta) {
        NotiError("Thiếu mô tả");
        return
    }
    //
    console.log("132467498")
    var result = "";
    if (doi_tuong_ap_dung != 'Custom') {
        result = $('#builder-basic').queryBuilder('getRules');
        console.log("66666")
        if ($.isEmptyObject(result)) {
            NotiError("Thiếu điều kiện hoặc nhóm điều kiện");
            return;
        }
    }
    console.log("Ấn thêm mới:")
    for(let i=0;i<the_tags.length;i++){
        the_tags[i] = the_tags[i].trim();
    }
    var params = {
        doiTuong: doi_tuong_ap_dung,
        tenTieuChi: ten_tieu_chi,
        tag: the_tags,
        moTa: mo_ta,
    }
    if (doi_tuong_ap_dung != 'Custom') {
        params.filters = JSON.stringify(result);
        params.calculation = phuong_phap;
    }
    console.log(JSON.stringify(params))
    $.confirm({
        title: 'Xác nhận thêm tiêu chí?',
        content: '',
        buttons: {
            Huy: {
                text: 'Hủy',
                btnClass: 'btn btn-danger',
                action: function () {
                    // $.alert('Hủy');
                }
            },
            DongY: {
                text: 'Đồng ý',
                btnClass: 'btn btn-success',
                keys: ['enter', 'shift'],
                action: function () {
                    themTieuChi(params)
                }
            }
        }
    });
});

function themTieuChi(e) {
    $body.addClass("loading");
    console.log("Đoạn này là để gửi tham số đi nè:");
    console.log(e)
    var token;
    token = '{{ csrf_token() }}';
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': token
        },
        type: 'POST',
        url: '/api-post-them-tieu-chi',
        data: e,
        dataType: 'html',

    }).done(function (ketqua) {
        $body.removeClass("loading");
        console.log(JSON.parse(ketqua));
        let kq = JSON.parse(ketqua)
        console.log("*************");
        if (kq.rc == 0) {
            $('#maTieuChi').text(kq.item.maTieuChi)
            notif({
                msg: "Thêm tiêu chí thành công",
                type: "success"
            });
            $('.show_add').css({
                "display": "none",
            });
            $('.show_done').css({
                "display": "block",
            });
            localStorage.setItem('ReLoadTrangQuanLyTieuChi', 'true');
        } else {
            notif({
                type: "error",
                msg: kq.rd,
            });
        }
        return;
    });
}

function NotiSuccess(e) {
    notif({
        msg: e,
        type: "success",
        timeout: 2500
    });
}

function NotiError(e) {
    notif({
        msg: e,
        type: "error",
        timeout: 2500,
    });
}

function NotiInfo(e) {
    notif({
        msg: e,
        type: "info",
        timeout: 2500,
    });
}
