$(document).ready(function () {
    console.log("demo ready function")
    $(document).on('click', '#buttonChinhSua', function () {
        console.log("ấn chỉnh s")
        let data = $('input.form-control');
        let arr = [];
        $('input.form-control').each(function () {
            arr.push({
                key: this.id,
                value: this.value
            })
        });
        console.log("Thông tin mảng dữ liệu cần thêm:")
        console.log(arr)
        if (confirm("Xác nhận chỉnh sửa dữ liệu")) {
            let idBaoCao = $('#idBaoCao').val();
            const params = {
                "danhSachTieuChi": JSON.stringify(arr),
                "id": idBaoCao
            };
            var token;
            token = '{{ csrf_token() }}';
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
                    console.log(dt)
                    if (dt.rc == 0) {
                        alert("Chỉnh sửa thành công");
                        window.close();
                    } else {
                        alert(dt.rd)
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

    });
})
