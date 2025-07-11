let mo = 0;
dataLopHoc =  JSON.parse(localStorage["danh_sach_tieu_chi_lop_hoc"]);
dataCanBo =  JSON.parse(localStorage["danh_sach_tieu_chi_can_bo_giao_vien"]);
dataKqht =  JSON.parse(localStorage["danh_sach_tieu_chi_ket_qua_hoc_tap"]);
dataDiemTruong =  JSON.parse(localStorage["danh_sach_tieu_chi_truong_hoc"]);
dataHocSinh =  JSON.parse(localStorage["danh_sach_tieu_chi_hoc_sinh"]);
$(document).ready(function () {
    $('table#canBoGiaoVien').DataTable({
        "scrollY": '150px',
        processing: true,
        data: dataCanBo,
        "columns": [{
                "data": "tenTieuChi"
            },
            {
                "data": "maTieuChi"
            },
            {
                "data": "moTa"
            },
            {
                "data": "relatedIndicators"
            },
            {
                "data": "calculation"
            }
        ],
        "language": {
            "lengthMenu": "Hiển thị _MENU_ bản ghi/trang",
            "Search:": "Tìm kiếm",
            "zeroRecords": "Không tìm thấy bản ghi nào",
            "info": "Đang hiển thị trang _PAGE_ trong tổng số _PAGES_ trang",
            "infoEmpty": "Không có bản ghi nào",
            "infoFiltered": "(Lọc từ _MAX_ bản ghi)"
        }
    });
    $('table#lopHoc').DataTable({
        "scrollY": '150px',
        processing: true,
        data: dataLopHoc,
        "columns": [{
                "data": "tenTieuChi"
            },
            {
                "data": "maTieuChi"
            },
            {
                "data": "moTa"
            },
            {
                "data": "relatedIndicators"
            },
            {
                "data": "calculation"
            }
        ],
        "language": {
            "lengthMenu": "Hiển thị _MENU_ bản ghi/trang",
            "Search:": "Tìm kiếm",
            "zeroRecords": "Không tìm thấy bản ghi nào",
            "info": "Đang hiển thị trang _PAGE_ trong tổng số _PAGES_ trang",
            "infoEmpty": "Không có bản ghi nào",
            "infoFiltered": "(Lọc từ _MAX_ bản ghi)"
        }
    });
    $('table#kqht').DataTable({
        "scrollY": '150px',
        processing: true,
        data: dataKqht,
        "columns": [{
                "data": "tenTieuChi"
            },
            {
                "data": "maTieuChi"
            },
            {
                "data": "moTa"
            },
            {
                "data": "relatedIndicators"
            },
            {
                "data": "calculation"
            }
        ],
        "language": {
            "lengthMenu": "Hiển thị _MENU_ bản ghi/trang",
            "Search:": "Tìm kiếm",
            "zeroRecords": "Không tìm thấy bản ghi nào",
            "info": "Đang hiển thị trang _PAGE_ trong tổng số _PAGES_ trang",
            "infoEmpty": "Không có bản ghi nào",
            "infoFiltered": "(Lọc từ _MAX_ bản ghi)"
        }
    });
    $('table#diemTruong').DataTable({
        "scrollY": '150px',
        processing: true,
        data: dataDiemTruong,
        "columns": [{
                "data": "tenTieuChi"
            },
            {
                "data": "maTieuChi"
            },
            {
                "data": "moTa"
            },
            {
                "data": "relatedIndicators"
            },
            {
                "data": "calculation"
            }
        ],
        "language": {
            "lengthMenu": "Hiển thị _MENU_ bản ghi/trang",
            "Search:": "Tìm kiếm",
            "zeroRecords": "Không tìm thấy bản ghi nào",
            "info": "Đang hiển thị trang _PAGE_ trong tổng số _PAGES_ trang",
            "infoEmpty": "Không có bản ghi nào",
            "infoFiltered": "(Lọc từ _MAX_ bản ghi)"
        }
    });
    $('table#hocSinh').DataTable({
        "scrollY": '150px',
        processing: true,
        data: dataHocSinh,
        "columns": [{
                "data": "tenTieuChi"
            },
            {
                "data": "maTieuChi"
            },
            {
                "data": "moTa"
            },
            {
                "data": "relatedIndicators"
            },
            {
                "data": "calculation"
            }
        ],
        "language": {
            "lengthMenu": "Hiển thị _MENU_ bản ghi/trang",
            "Search:": "Tìm kiếm",
            "zeroRecords": "Không tìm thấy bản ghi nào",
            "info": "Đang hiển thị trang _PAGE_ trong tổng số _PAGES_ trang",
            "infoEmpty": "Không có bản ghi nào",
            "infoFiltered": "(Lọc từ _MAX_ bản ghi)"
        }
    });

    $('#hienThiDanhDachTieuChi').click(function () {
        if (mo == 0) {
            setTimeout(function () {
                $(".sorting").click();
            }, 100);
            mo = 2;
        }
    });
});
