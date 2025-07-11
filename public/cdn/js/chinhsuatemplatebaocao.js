$(document).ready(function () {
    console.log("ready...")
    console.log("lấy dữ liệu các tiêu chí")
    
    $('.js-example-basic-single').select2({
        closeOnSelect: true,
        width: '100px',
        ajax: {
            url: '/api-lay-danh-sach-tieu-chi',
            data: function (params) {
                var query = {
                    search: params.term,
                    theLoai: 'HocSinh',
                    TieuChiHeThong: true,
                    tieuChiNguoiDung: false
                }
                return query;
            },
            processResults: function (data, params) {
                let dt = JSON.parse(data)
                console.log("***")
                console.log(JSON.stringify(dt))
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
            cache: false
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });
    

});

function formatRepo(repo) {
    if (repo.loading) {
        return repo.text;
    }
    var $container = $(
        "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>"+repo.maTieuChi + " - [" + repo.tenTieuChi + "]"+"</div>" +
        "<div class='select2-result-repository__description' ><div><i class='mota' style='color:blue;font-size:8pt'></i></div></div>" +
        '<i data-maTieuChi="" style="color:#FF8000; float:right" class="fas fa-info-circle info"></i>' +
        "</div>" +
        "</div>"
    );
    $container.find(".mota").text(repo.moTa);
    return $container;
}

function formatRepoSelection(repo) {
    return repo.maTieuChi || repo.tenTieuChi;
}