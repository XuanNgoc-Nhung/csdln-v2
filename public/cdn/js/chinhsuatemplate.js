
let tieuChi1 = 0;
let tieuChi2 = 0;
let theLoai = "";
let mangTieuChi = []
$(document).ready(function () {
    $(document).on({
        click: function () {
            $('#mdLoading').modal('show');
            console.log("du_lieu_chinh_sua");
            let data_dm = $(this).attr('data-maTieuChi');
            console.log(data_dm);
            $.ajax({
                url: '/api-lay-chi-tiet-tieu-chi',
                type: 'GET',
                dataType: 'json',
                data: {
                    maBcChiTiet: data_dm,
                }
            }).done(function (ketqua) {
                $('#mdLoading').modal('hide');
                console.log(ketqua);
                let kq = JSON.stringify(ketqua.item.filters);
                console.log(kq);
                console.log("*****");
                $('#exampleModalCenter').modal('show');
                $('body').find("#info-maTieuChi").text(ketqua.item.maTieuChi);
                $('body').find("#info-tenTieuChi").text(ketqua.item.tenTieuChi);
                $('body').find("#info-moTa").text(ketqua.item.moTa);
                $('body').find("#info-doiTuong").text(ketqua.item.doiTuong);
                $('body').find("#info-phuongPhap").text(ketqua.item.calculation);
                $('body').find("#info-phuongPhap").text(ketqua.item.calculation);
                $('body').find("#info-querybuid").text(kq);
            });
        },
        mouseenter: function () {
            let tt = $(this);
            console.log(tt);
            $(this).css({
                color: 'red',
            });
        },
        mouseout: function () {
            $('.info').css({
                color: '#FF8000',
            });
        },
    }, '.info');
    $('#dongModal').click(function () {
        $('#exampleModalCenter').modal('hide');
    });
    $(".js-example-basic-single").select2({
        theme: "classic",
        tags: "true",
        allowClear: true
    });
    //   
    $('.tieuChi1').change(function () {
        console.log("2");
        if (this.checked) {
            tieuChi1 = 1;
        } else {
            tieuChi1 = 0
        }
    });
    $('.tieuChi2').change(function () {
        if (this.checked) {
            tieuChi2 = 1;
        } else {
            tieuChi2 = 0
        }
    });
    $('#theLoai').change(function () {
        theLoai = $("#theLoai").val();
        console.log(theLoai);
        $('.GiaoVien').css({
            "display": "block",
        });
        $('.LopHoc').css({
            "display": "block",
        });
        $('.kqht').css({
            "display": "block",
        });
        $('.TruongHoc').css({
            "display": "block",
        });
        $('.HocSinh').css({
            "display": "block",
        });
        if (theLoai == "GiaoVien") {
            console.log("ấn giáo viên");
            $('.GiaoVien').css({
                "display": "block",
            });
            $('.LopHoc').css({
                "display": "none",
            });
            $('.kqht').css({
                "display": "none",
            });
            $('.TruongHoc').css({
                "display": "none",
            });
            $('.HocSinh').css({
                "display": "none",
            });
        }
        if (theLoai == "LopHoc") {
            $('.GiaoVien').css({
                "display": "none",
            });
            $('.LopHoc').css({
                "display": "block",
            });
            $('.kqht').css({
                "display": "none",
            });
            $('.TruongHoc').css({
                "display": "none",
            });
            $('.HocSinh').css({
                "display": "none",
            });
        }
        if (theLoai == "KQHT") {
        $('.GiaoVien').css({
            "display": "none",
        });
        $('.LopHoc').css({
            "display": "none",
        });
        $('.kqht').css({
            "display": "block",
        });
        $('.TruongHoc').css({
            "display": "none",
        });
        $('.HocSinh').css({
            "display": "none",
        });}
        if (theLoai == "TruongHoc") {
            $('.GiaoVien').css({
                "display": "none",
            });
            $('.LopHoc').css({
                "display": "none",
            });
            $('.kqht').css({
                "display": "none",
            });
            $('.TruongHoc').css({
                "display": "block",
            });
            $('.HocSinh').css({
                "display": "none",
            });
        }
        if (theLoai == "HocSinh") {
            $('.GiaoVien').css({
                "display": "none",
            });
            $('.LopHoc').css({
                "display": "none",
            });
            $('.kqht').css({
                "display": "none",
            });
            $('.TruongHoc').css({
                "display": "none",
            });
            $('.HocSinh').css({
                "display": "block",
            });
        }



    });
    $('.js-example-basic-single').select2({
        closeOnSelect: false,
        width: '100px',
        ajax: {
            url: '/api-lay-danh-sach-tieu-chi',
            data: function (params) {
                var query = {
                    search: params.term,
                    theLoai: theLoai,
                    TieuChiHeThong: tieuChi1,
                    tieuChiNguoiDung: tieuChi2
                }
                return query;
            },
            processResults: function (data, params) {
                let dt = JSON.parse(data)
                if (dt.rc == 0) {
                    if (dt.rows) {
                        var result = dt.rows;
                    } else {
                        var result = '';
                    }
                    return {
                        results: result,
                    };
                } else {
                    // window.location.href = data.url;
                }
            },
            cache: true
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'></div>" +
            "<div class='select2-result-repository__description' ><div><i class='mota' style='color:blue;font-size:8pt'></i></div></div>" +
            '<i data-maTieuChi="" style="color:#FF8000; float:right" class="fas fa-info-circle info"></i>' +
            "</div>" +
            "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo.tenTieuChi + " - [" + repo.maTieuChi + "]");
        $container.find(".mota").text(repo.moTa);
        $container.find(".info").attr('data-maTieuChi', repo.id);
        return $container;
    }

    function formatRepoSelection(repo) {
        return repo.maTieuChi || repo.tenTieuChi;
    }
    $('#chinhSua').click(function () {
        console.log(mangTieuChi);
        let mang = 0;
        $(".js-example-basic-single").each(function () {
            mang += 1;
        });
        if (mangTieuChi.length ==0 ) {
            console.log("thiếu mảng");
            alert("Vui lòng kiểm tra lại và đảm bảo các trường dữ liệu được điển đầy đủ")
        } else {
            if (confirm("Xác nhận chỉnh sửa dữ liệu")) {

                let idBaoCao = $('#idBaoCao').val();
                console.log("id báo cáo:" + idBaoCao);
                console.log("Đủ");
                const params = {
                    "danhSachTieuChi": mangTieuChi,
                    "id": idBaoCao
                };
                var token;
                token = '{{ csrf_token() }}';
                console.log(token);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'POST',
                    url: '/api-post-chinh-sua-template-bao-cao',
                    data: params,
                    dataType: 'html',
                    success: function (data) {
                        alert("Chỉnh sửa thành công")
                        if (data.error) {
                            console.log(data);
                        } else {
                            console.log(data);
                        }
                    },
                    error: function (html, status) {
                        alert("Chỉnh sửa thất bại")
                        console.log(html.responseText);
                        console.log(status);
                    }
                });
            } else {
                return false;
            }
        }
    });
    $('.js-example-basic-single').on('select2:select', function (e) {
        var value = e.params.data.maTieuChi;
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
});
