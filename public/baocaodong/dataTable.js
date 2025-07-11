
$body = $("body");
$(document).ready(function () {
    getAllTieuChi();
    $('.js-example-basic-single').select2();
    $('#dtBasicExample').DataTable({
        "language": {
            "decimal": "",
            "emptyTable": "Không có dữ liệu",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Hiển thị _MENU_ bản ghi/trang",
            "loadingRecords": "Loading...",
            "processing": "Processing...",
            "search": "Từ khóa: ",
            "zeroRecords": "No matching records found",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "»",
                "previous": "«"
            },
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            }
        }
    });
    $('#addRow').on('click', function () {
        var table = $('#dtBasicExample').DataTable();
        table.clear().draw();
        getAllTieuChi();
    });

    function getAllTieuChi() {
        $body.addClass("loading");
        let params = "";
        theLoai = $("#theLoai").val();
        $.ajax({
            url: '/api-lay-danh-sach-tieu-chi',
            type: 'GET',
            dataType: 'json',
            data: {
                theLoai: theLoai,
            }
        }).done(function (ketqua) {
            $body.removeClass("loading");
            console.log(ketqua);
            if (ketqua.rc == 0) {
                $body.addClass("loading");
                let du_lieu_tra_ve = ketqua.rows;
                var t = $('#dtBasicExample').DataTable();
                for (let i = 0; i < du_lieu_tra_ve.length; i++) {
                    t.row.add([
                        i+1,
                        du_lieu_tra_ve[i].tenTieuChi,
                        du_lieu_tra_ve[i].maTieuChi,
                        du_lieu_tra_ve[i].doiTuong,
                        du_lieu_tra_ve[i].relatedIndicators,
                        du_lieu_tra_ve[i].moTa,
                        'Tùy chọn',
                    ]).draw(false);
                }
                $body.removeClass("loading");
            } else {}
            return;
        });
    }
});
