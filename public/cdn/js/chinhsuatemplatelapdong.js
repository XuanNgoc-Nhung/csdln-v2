var sanh_sach_doi_tuong_lap = [
    {
        id: 0,
        text: 'Mã trường'
    },
    {
        id: 1,
        text: 'Tên trường'
    },
    {
        id: 2,
        text: 'Đơn vị quản lý'
    },
    {
        id: 3,
        text: 'Cấp học'
    },
    {
        id: 4,
        text: 'Quận huyện'
    },
    {
        id: 4,
        text: 'Tỉnh thành'
    }
];
$(document).ready(function () {
    $('.lapdong').select2({
        closeOnSelect: false,
        width: '100px',
        data: sanh_sach_doi_tuong_lap
    });
});
