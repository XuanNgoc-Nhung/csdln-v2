let mangTieuChi = []
let giaTriBanDau = []
var list_tieu_chi = [];
$(document).ready(function () {


    $body = $("body");
    console.log("ready function");
    var toan_bo_tieu_chi = localStorage["toan_bo_tieu_chi_localstorage"];
    if (toan_bo_tieu_chi) {
        console.log("Có tiêu chí")
        toan_bo_tieu_chi = JSON.parse(toan_bo_tieu_chi)
        list_tieu_chi = toan_bo_tieu_chi;
        ganDuLieuOption(toan_bo_tieu_chi)
    } else {
        console.log("chưa có tiêu chí")
        getToanBoTieuChi();
    }
    $('.chonTieuChi').on('select2:select', function (e) {
        var value = e.params.data.id;
        var key = $(this).attr('name');
        let obj = {
            value: value,
            key: key
        }
        let trung = false;
        for (let i = 0; i < mangTieuChi.length; i++) {
            if (mangTieuChi[i].key == key) {
                mangTieuChi[i].value = value;
            }
        }
        for (let i = 0; i < mangTieuChi.length; i++) {
            console.log("object");
            if (mangTieuChi[i].key == key) {
                trung = true;
                break
            }
        }
        if (trung == false) {
            mangTieuChi.push(obj)
        }

    });
    $("#mapDuLieuChinhSua").click(function () {
        console.log("ấn chỉnh s")
        mapDuLieuChinhSua();
    });
    // $(".chonTieuChi").click(function (e) {
    //     var key = $(this).attr('id');
    //     let idO = '#' + key;
    //     console.log(key);
    //     let dts_dtsc = [
    //         {
    //             id:"",
    //             text:"Chọn"
    //         }
    //     ]
    //     for (let i = 0; i < toan_bo_tieu_chi.length; i++) {
    //         let obj = {
    //             id: toan_bo_tieu_chi[i].maTieuChi,
    //             text: '[' + toan_bo_tieu_chi[i].maTieuChi + '] - ' + toan_bo_tieu_chi[i].tenTieuChi
    //         }
    //         dts_dtsc.push(obj);
    //     }
    //     $('#demo').trigger('click')
    //     $(idO).select2({
    //         data: dts_dtsc
    //     });
    // });

});

function getToanBoTieuChi() {
    console.log("lấy toàn bộ dữ liệu tiêu chí")
    $body.addClass("loading");
    $.ajax({
        url: '/lay-toan-bo-tieu-chi',
        type: 'GET',
        dataType: 'json',
        data: {
            type: '1',
        }
    }).done(function (ketqua) {
        $body.removeClass("loading");
        console.log("kết quả trả về moetCode:");
        if (ketqua.rc == 0) {
            let toan_bo_tieu_chi_localstorage = ketqua.rows;
            list_tieu_chi = toan_bo_tieu_chi_localstorage;

            localStorage["toan_bo_tieu_chi_localstorage"] = JSON.stringify(toan_bo_tieu_chi_localstorage)
            ganDuLieuOption(ketqua.rows)
        } else {}
    });
}
function ganDuLieuOption(e) {
    console.log(e);
    let data_source = e;
    var dt_sc = [{
        id: "",
        text: "Chọn"
    }];
    for (let i = 0; i < data_source.length; i++) {
        let obj = {
            id: data_source[i].maTieuChi,
            text: '[' + data_source[i].maTieuChi + '] - ' + data_source[i].tenTieuChi
        }
        dt_sc.push(obj);
    }
    mapPingSelect2(dt_sc);
}

function mapPingSelect2(e) {

    console.log("Bắt đầu gán:")
    console.time();
    console.log(e)
    let thu = $('.chonTieuChi');
    console.log(thu.length)
    $('.chonTieuChi').select2({
        data: e
    });
    console.log("Gán xong:")
    console.time();
    layGiaTriChon();
}

function layGiaTriChon() {
    console.log("Lấy các giá trị ban đầu")
    $body.addClass("loading");
    var demo = $('.chonTieuChi');
    for (let i = 0; i < demo.length; i++) {
        var val = demo[i].getAttribute('value');
        var vitri = demo[i].getAttribute('name');
        if (val) {
            let obj = {
                key: vitri,
                value: val
            }
            giaTriBanDau.push(obj);
            console.log("vị trí: " + i + " có dữ liệu cần gán")
            let vt = $('#a' + vitri);
            $(vt).val(val).trigger('change');
        }
    }
    
    console.log("giaTriBanDau")
    console.log(giaTriBanDau)
    console.log(JSON.stringify(giaTriBanDau))
    $body.removeClass("loading");
}

function mapDuLieuChinhSua() {
    console.log("ấn chỉnh sửa:")
    var toan_bo_du_lieu = Object.values(giaTriBanDau.concat(mangTieuChi).reduce((r, o) => {
        r[o.key] = o;
        return r;
    }, {}));
    console.log(toan_bo_du_lieu)
    for (let i = 0; i < toan_bo_du_lieu.length; i++) {
        if (toan_bo_du_lieu[i].value == "" || !toan_bo_du_lieu[i].value) {
            toan_bo_du_lieu.splice(i, 1);
        }
    }
    if (toan_bo_du_lieu.length == 0) {
        console.log("chưa có dữ liệu")
        alert("Vui lòng bổ sung thông tin chỉnh sửa");
        return;
    } else {
        if (confirm("Xác nhận chỉnh sửa dữ liệu")) {
            let idBaoCao = $('#idBaoCao').val();
            console.log("id báo cáo:" + idBaoCao);
            console.log("Đủ");
            const params = {
                "danhSachTieuChi": JSON.stringify(toan_bo_du_lieu),
                "id": idBaoCao
            };
            var token;
            token = '{{ csrf_token() }}';
            $body.addClass("loading");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'POST',
                url: '/api-post-chinh-sua-template-bao-cao',
                data: params,
                dataType: 'html',
                success: function (data) {
                    let dt = JSON.parse(data);
                    $body.removeClass("loading");
                    console.log(dt)
                    if (dt.rc==0) {
                        alert("Chỉnh sửa thành công")
                    } else {
                        alert(dt.rd)
                    }
                },
                error: function (html, status) {
                    $body.removeClass("loading");
                    alert("Chỉnh sửa thất bại")
                    console.log(html.responseText);
                    console.log(status);
                }
            });
        } else {
            return false;
        }
    }
}
