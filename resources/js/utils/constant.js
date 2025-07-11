export default {
    list_tieu_chi_so_sanh: [{
            value: 'maTruongHoc',
            name: "Mã trường học *",
            disabled: true
        },
        {
            value: 'hoTen',
            name: "Họ tên học sinh *",
            disabled: true
        },
        {
            value: 'ngaySinh',
            name: "Ngày sinh * ",
            disabled: true
        },
        {
            value: 'tenLopHoc',
            name: "Tên lớp học"
        },
        {
            value: 'gioiTinh',
            name: "Giới tính"
        },
        {
            value: 'noiSinh',
            name: "Nơi sinh"
        },
        {
            value: 'hoTenMe',
            name: "Họ tên mẹ"
        },
        {
            value: 'namSinhMe',
            name: "Năm sinh mẹ"
        },
        {
            value: 'hoTenNguoiGiamHo',
            name: "Họ tên người giám hộ"
        },
        {
            value: 'namSinhNguoiGiamHo',
            name: "Năm sinh người giám hộ"
        },
    ],
    list_tieu_chi_so_sanh_bo_sung: [{
            value: 'khongdau',
            name: "So sánh không dấu"
        },
        {
            value: 'bodaucach',
            name: "Loại bỏ dấu cách trong tên"
        },
        {
            value: 'dungunicode',
            name: "Dùng bảng mã unicode chung"
        },
        {
            value: 'dungchuviethoa',
            name: "Dùng chữ viết hoa"
        },
    ],
    NHOM_TRE_DOC_LAP: [{
        value: '04',
        name: "Nhóm nhà trẻ độc lập"
    }, {
        value: '05',
        name: "Lớp mẫu giáo độc lập"
    }, {
        value: '19',
        name: "Nhóm trẻ, lớp mẫu giáo độc lập"
    }],
    // Tra cứu cán bộ:
    list_chuc_vu_phong: [{
            value: 1,
            name: "Giám đốc"
        },
        {
            value: 2,
            name: "Phó giám đốc"
        },
        {
            value: 3,
            name: "Trưởng phòng"
        },
        {
            value: 4,
            name: "Phó trưởng phòng"
        },
        {
            value: 5,
            name: "Chủ tịch công đoàn ngành"
        },
        {
            value: 6,
            name: "Phó chủ tịch công đoàn ngành"
        },
        {
            value: 7,
            name: "Chánh thanh tra"
        },
        {
            value: 8,
            name: "Phó chánh thanh tra"
        },
        {
            value: 9,
            name: "Thanh tra chính"
        },
        {
            value: 10,
            name: "Thanh tra viên"
        },
        {
            value: 11,
            name: "Chánh tra phòng"
        },
        {
            value: 12,
            name: "Phó chánh văn phòng"
        },
        {
            value: 13,
            name: "Văn thư"
        },
        {
            value: 14,
            name: "Chuyên viên"
        },
    ],
    truong_duoc_phep_day_xoa_du_lieu: [
        '19165406',
        '19164406',
        '19169303',
        '19169321',
        '19000715',
        '19000710',
        '19164345',
        '19000725',
        '19000709',
        '19000732',
        '19167503',
        '19167505',
        '19167509',
        '19167513',
        '19167523',
        '19164350',
        '19164316',
        '19164313',
        '19164308',
        '19164312',
        '19164363',
        '19164404',
        '19164434',
        '19164408',
        '19164410',
        '19164409',
        '19164497',
        '19164414',
        '19164425',
        '19164401',
        '19164418',
        '19164419',
        '19164407',
        '19164431',
        '19164701',
        '19164510',
        '19164507',
        '19164519',
        '19164508',
        '19164502',
        '19164512',
        '19164518',
        '19164525',
        '19165410',
        '19165405',
        '19165412',
        '19165403',
        '19165401',
        '19165407',
        '19165408',
        '19165411',
        '19165402',
        '19165506',
        '19165507',
        '19165404',
        '19165409',
        '19169310',
        '19169407',
        '19172514',
        '19173408',
        '19000908',
        '19000711',
        '19164340',
        '19164344',
    ],
    list_ma_phong_ban: [{
            value: 1,
            name: "Ban giám đốc"
        },
        {
            value: 2,
            name: "Phòng TCCB"
        },
        {
            value: 3,
            name: "Phòng KH-TC"
        },
        {
            value: 4,
            name: "Phòng GDCN-GDTX"
        },
        {
            value: 5,
            name: "Văn phòng"
        },
        {
            value: 6,
            name: "Phòng GDTrh"
        },
        {
            value: 7,
            name: "Phòng Khảo thí và KĐCLGD"
        },
        {
            value: 8,
            name: "Phòng GDTH"
        },
        {
            value: 9,
            name: "Phòng Mầm non"
        },
        {
            value: 10,
            name: "Thanh tra Sở"
        },
        {
            value: 11,
            name: "Công đoàn ngành"
        },
        {
            value: 12,
            name: "Phòng Chính trị - Tư tưởng"
        },
        {
            value: 13,
            name: "Phòng giáo dục & đào tạo"
        },
    ],
    list_trinh_do_dao_tao: [{
            id: '',
            name: "Chọn trình độ đào tạo"
        },
        {
            id: 1,
            name: "Tiến sĩ KH"
        },
        // {id: 2,name: "Tiến sĩ khoa học"},
        {
            id: 3,
            name: "Thạc sĩ"
        },
        {
            id: 4,
            name: "Đại học"
        },
        {
            id: 5,
            name: "Cao đẳng"
        },
        {
            id: 6,
            name: "Trung cấp"
        },
        {
            id: 7,
            name: "Sơ cấp"
        },
        {
            id: 13,
            name: "TH 12+2"
        },
        {
            id: 14,
            name: "TH 9+3"
        },
        {
            id: 15,
            name: "Dưới THSP"
        },
        {
            id: 16,
            name: "Đại học và có chứng chỉ BDNVSP"
        },
        {
            id: 17,
            name: "Cao đẳng và có chứng chỉ BDNVSP"
        },
        {
            id: 18,
            name: "Trung cấp và có chứng chỉ BDNVSP"
        },
        {
            id: 19,
            name: "Đại học sư phạm"
        },
        {
            id: 20,
            name: "Cao đẳng sư phạm"
        },
        {
            id: 21,
            name: "Trung cấp sư phạm"
        },
    ],
    list_chuyen_nganh: [
        // {
        //     id: '',
        //     name: "Chọn"
        // },
        // {id: "1",name: "Tiến sĩ Khoa học"},
        // {id: "2",name: "Tiến sĩ"},
        // {id: "3",name: "Thạc sĩ"},
        // {id: "4",name: "Đại học sư phạm"},
        // {id: "5",name: "Cao đẳng"},
        // {id: "6",name: "Trung cấp"},
        // {id: "7",name: "Sơ cấp"},
        // {id: "13",name: "TH 12+2"},
        // {id: "14",name: "TH 9+3"},
        // {id: "15",name: "Dưới THSP"},
        // {id: "16",name: "Đại học và có chứng chỉ BDNVSP"},
        // {id: "17",name: "Cao đẳng và có chứng chỉ BDNVSP"},
        // {id: "18",name: "Trung cấp và có chứng chỉ BDNVSP"},
        // {id: "19",name: "Đại học sư phạm"},
        // {id: "20",name: "Cao đẳng sư phạm"},
        // {id: "21",name: "Trung cấp sư phạm"},
        // comment lại đổi sang cái mới

        {
            id: 1,
            name: "Tiến sĩ"
        },
        {
            id: 3,
            name: "Thạc sĩ"
        },
        {
            id: 7,
            name: "Trung cấp"
        },
        {
            id: 13,
            name: "Cao đẳng"
        },
        {
            id: 16,
            name: "Đại học"
        },
    ],
    list_chuyen_mon: [{
            id: '',
            name: "Chọn"
        },
        {
            id: "01",
            name: "Tiến sĩ"
        },
        {
            id: "02",
            name: "Thạc sĩ"
        },
        {
            id: "03",
            name: "Đại học"
        },
        {
            id: "04",
            name: "Cao đẳng"
        },
        {
            id: "05",
            name: "Trung cấp"
        },
        {
            id: "06",
            name: "Trình độ khác"
        },
        {
            id: "07",
            name: "Bác sĩ chuyên khoa 1"
        },
        {
            id: "08",
            name: "Bác sĩ chuyên khoa 2"
        },
        {
            id: "09",
            name: "TH 12+2"
        },
        {
            id: "10",
            name: "TH 9+3"
        },
        {
            id: "11",
            name: "Dưới THSP"
        },
        {
            id: "13",
            name: "Đại học và có chứng chỉ BDNVSP"
        },
        {
            id: "14",
            name: "Cao đẳng và có chứng chỉ BDNVSP"
        },
        {
            id: "15",
            name: "Trung cấp và có chứng chỉ BDNVSP"
        },
        {
            id: "16",
            name: "Đại học sư phạm"
        },
        {
            id: "17",
            name: "Cao đẳng sư phạm"
        },
        {
            id: "18",
            name: "Trung cấp sư phạm"
        },
        // comment lại để lấy theo cái mới
        // {id: "1",name: "Tiến sĩ"},
        // {id: "3",name: "Thạc sĩ"},
        // {id: "4",name: "Đại học"},
        // {id: "5",name: "Cao đẳng"},
        // {id: "6",name: "Trung cấp"},
        // {id: "11",name: "Bác sĩ chuyên khoa 1"},
        // {id: "12",name: "Bác sĩ chuyên khoa 2"},
        // {id: "13",name: "TH 12+2"},
        // {id: "14",name: "TH 9+3"},
        // {id: "15",name: "Dưới THSP"},
        // {id: "16",name: "Đại học và có chứng chỉ BDNVSP"},
        // {id: "17",name: "Cao đẳng và có chứng chỉ BDNVSP"},
        // {id: "18",name: "Trung cấp và có chứng chỉ BDNVSP"},
        // {id: "19",name: "Đại học sư phạm"},
        // {id: "20",name: "Cao đẳng sư phạm"},
        // {id: "21",name: "Trung cấp sư phạm"},
        // {id: "23",name: "Trình độ khác"},
    ],
    danh_sach_tim_kiem_danh_sach_hoc_sinh: [

        {
            key: 'maTruongHoc',
            name: "Mã trường",
            stt: 1,
            fixed: 'left',
        },
        {
            key: 'tenTruongHoc',
            name: "Tên trường",
            stt: 2,
            fixed: 'left',
        },
        {
            key: 'hoTen',
            name: "Họ và tên",
            stt: 3,
            fixed: 'left',
        },
        {
            key: 'khoiHoc',
            name: "Khối học/Nhóm lớp",
            stt: 4
        },
        {
            key: 'tenLopHoc',
            name: "Lớp học",
            stt: 5
        },
        {
            key: 'maHocSinh',
            name: "Mã học sinh",
            stt: 6
        },

        {
            key: 'moetCode',
            name: "Mã định danh",
            stt: 7
        },

        {
            key: 'ngaySinh',
            name: "Ngày sinh",
            stt: 8
        },
        {
            key: 'gioiTinh',
            name: "Giới tính",
            stt: 9
        },
        {
            key: 'maDanToc',
            name: "Dân tộc",
            stt: 10
        },
        {
            key: 'trangThai',
            name: "Trạng thái",
            stt: 11
        },
        {
            key: 'noiSinh',
            name: "Nơi sinh",
            stt: 12
        },
        {
            key: 'hoNgheo',
            name: "Hộ nghèo",
            stt: 13
        },
        {
            key: 'maDtuongCsach',
            name: "Đối tượng chính sách",
            stt: 14
        },
        {
            key: 'sdt',
            name: "Số điện thoại",
            stt: 15
        },
        {
            key: 'email',
            name: "Email",
            stt: 16
        },

        {
            key: 'soCmnd',
            name: "CMTND/TCC",
            stt: 17
        },
        // {
        //     key: 'moetCode1',
        //     name: "Tiêu chí bổ sung",
        //     stt: 12
        // },
    ],
    danh_sach_tim_kiem_danh_sach_hoc_sinh_so: [

        {
            key: 'maTruongHoc',
            name: "Mã trường",
            stt: 1,
            fixed: 'left',
        },
        {
            key: 'tenTruongHoc',
            name: "Trường học",
            stt: 2,
            fixed: 'left',
        },
        {
            key: 'hoTen',
            name: "Họ và tên",
            stt: 3,
            fixed: 'left',
        },
        {
            key: 'khoiHoc',
            name: "Khối học/Nhóm lớp",
            stt: 4
        },
        {
            key: 'tenLopHoc',
            name: "Lớp học",
            stt: 5
        },
        {
            key: 'maHocSinh',
            name: "Mã học sinh",
            stt: 6
        },

        {
            key: 'moetCode',
            name: "Mã định danh bộ GD&ĐT",
            stt: 7
        },

        {
            key: 'ngaySinh',
            name: "Ngày sinh",
            stt: 8
        },
        {
            key: 'gioiTinh',
            name: "Giới tính",
            stt: 9
        },
        {
            key: 'maDanToc',
            name: "Dân tộc",
            stt: 10
        },
        {
            key: 'trangThai',
            name: "Trạng thái",
            stt: 11
        },
        {
            key: 'soCmnd',
            name: "Số CMND/CCCD/ĐDCN",
            stt: 12
        },
        {
            key: 'ngayCapCmnd',
            name: "Ngày cấp CMND/CCCD/ĐDCN",
            stt: 13
        },
        {
            key: 'noiCapCmnd',
            name: "Nơi cấp CMND/CCCD/ĐDCN",
            stt: 14
        },
        {
            key: 'sdt',
            name: "SĐT liên hệ",
            stt: 15
        },
        {
            key: 'email',
            name: "Email",
            stt: 16
        },
        // {
        //     key: 'soDienThoaiMe',
        //     name: "Số điện thoại mẹ",
        //     stt: 17
        // },
        {
            key: 'dchiThtru',
            name: "Địa chỉ thường trú",
            stt: 18
        },
        {
            key: 'dchiTmtru',
            name: "Địa chỉ tạm trú",
            stt: 19
        },
        {
            key: 'noiSinh',
            name: "Nơi sinh",
            stt: 20
        },
        {
            key: 'hoNgheo',
            name: "Hộ nghèo",
            stt: 21
        },
        {
            key: 'maDtuongCsach',
            name: "Đối tượng chính sách",
            stt: 22
        },
        // {
        //     key: 'soDienThoaiBo',
        //     name: "Số điện thoại bố",
        //     stt: 23
        // },
        {
            key: 'hoTenBo',
            name: "Họ tên bố",
            stt: 24
        },
        {
            key: 'hoTenMe',
            name: "Họ tên mẹ",
            stt: 25
        },
        {
            key: 'citizenId',
            name: "Mã định danh công dân",
            stt: 26
        },
        {   key: 'kiemTraSucKhoeDinhDuong',
            name: "Kiểm tra sức khỏe dinh dưỡng",
            stt: 27
        },
        // {key: 'isKhamSkDky', name: "Khám sức khỏe định kỳ", stt: 28},
        // { key: 'moetCode1', name: "Có bệnh về ỉa chảy, hô hấp", stt: 29},
        // { key: 'isSuyDduongTheTcoi', name: "Suy dinh dưỡng thể thấp còi", stt: 30},
        // { key: 'isTheoDoiBdoCcao', name: "Theo dõi biểu đồ chiều cao", stt: 31},
        // { key: 'isTheoDoiBdoCnang', name: "Theo dõi biểu đồ cân nặng", stt: 32},
        { key: 'chieuCao', name: "Chiều cao kì 1", stt: 33},
        { key: 'chieuCaoKy2', name: "Chiều cao kì 2", stt: 34},
        { key: 'canNang', name: "Cân nặng kì 1", stt: 35},
        { key: 'canNangKy2', name: "Cân nặng kì 2", stt: 36},
        { key: 'benhMat', name: "Bệnh về mắt", stt: 37},
        { key: 'bietBoiKy1', name: "Biết bơi kỳ 1", stt: 38},
        { key: 'bietBoiKy2', name: "Biết bơi kỳ 2", stt: 39},
        { key: 'hocSinhBanTru', name: "Học sinh bán trú", stt: 40},
        // { key: 'noiChuyenDi', name: "Nơi chuyển đi", stt: 41},
        // { key: 'chuyenDiDenTinh', name: "Chuyển đi đến tỉnh", stt: 42},
        // { key: 'chuyenDiDenQuanHuyen', name: "Chuyển đi đến huyện", stt: 43},    
        // { key: 'chuyenDenTuTinh', name: "Chuyển đến từ tỉnh", stt: 44},
        // { key: 'chuyenDenTuQuanHuyen', name: "Chuyển đến từ huyện", stt: 45},
    ],
    danh_sach_tim_kiem_danh_sach_can_bo: [
        {
            key: 'tenTruongHoc',
            name: "Trường học",
            stt: 0,
            width: 250,
            fixed: 'left',
        },
        {
            key: 'maTruongHoc',
            name: "Mã trường",
            stt: 1,
            width: 150
        },
        {
            key: 'tenCanBo',
            name: "Họ và tên",
            stt: 4,
            width: 250,
            fixed: 'left',
        },

        {
            key: 'maGiaoVien',
            name: "Mã cán bộ",
            stt: 2,
            width: 150
        },
        {
            key: 'moetCode',
            name: "Mã định danh bộ GD&ĐT",
            stt: 3,
            width: 200,

        },

        {
            key: 'ngaySinh',
            name: "Ngày sinh",
            stt: 5
        },
        {
            key: 'gioiTinh',
            name: "Giới tính",
            stt: 6,
            align: 'center'
        },
        {
            key: 'trangThai',
            name: "Trạng thái",
            stt: 7,
            width: 120

        },
        {
            key: 'maDanToc',
            name: "Dân tộc",
            stt: 8
        },
        {
            key: 'loaiCanBo',
            name: "Loại cán bộ",
            stt: 9,
            width: 140
        },
        {
            key: 'chucVu',
            name: "Nhóm chức vụ",
            stt: 10,
            width: 240
        },
        {
            key: 'loaiHopDong',
            name: "Hình thức hợp đồng",
            stt: 11,
            width: 450

        },
        {
            key: 'maTrinhDoChuyenMonCaoNhat',
            name: "T.Độ chuyên môn nghiệp vụ",
            stt: 12,
            width: 320

        },
        {
            key: 'maMonHoc',
            name: "Môn dạy",
            stt: 13,
            width: 170

        },
        {
            key: 'soDienThoaiDiDong',
            name: "Số điện thoại",
            stt: 14,
            width: 120

        },
        {
            key: 'queQuan',
            name: "Quê quán",
            stt: 16,
            width: 350


        },
        {
            key: 'noiSinh',
            name: "Nơi sinh",
            stt: 17,
            width: 150
        },
        {
            key: 'namSinh',
            name: "Năm sinh",
            stt: 18
        },
        {
            key: 'soCmnd',
            name: "Số CMTND/TCC",
            stt: 19,
            width: 140
        },
        {
            key: 'hinhThucDaoTao',
            name: "Hình thức đào tạo",
            stt: 20,
            width: 160

        },
        {
            key: 'doTuoi',
            name: "Độ tuổi",
            stt: 21
        },
        {
            key: 'trinhDoDaoTaoCnChinh',
            name: "Trình độ đào tạo",
            stt: 22,
            width: 120

        },
        {
            key: 'dgKqChuanNgheNghiep',
            name: "Cấp trên đánh giá chuẩn nghề nghiệp",
            stt: 23,
            width: 280
        },
        {
            key: 'tuDanhGiaKqChuanNgheNghiep',
            name: "Tự đánh giá kết quả chuẩn nghề nghiệp",
            stt: 24,
            width: 280
        },
    ],
    danh_sach_tim_kiem_danh_sach_can_bo_cap_so: [
        {
            key: 'tenTruongHoc',
            name: "Trường học",
            stt: 0,
            width: 250,
            fixed: 'left',
        },

        {
            key: 'maTruongHoc',
            name: "Mã trường",
            stt: 1,
            width: 150
        },
        {
            key: 'tenCanBo',
            name: "Họ và tên",
            stt: 4,
            width: 250,
            fixed: 'left',
        },
        {
            key: 'maGiaoVien',
            name: "Mã cán bộ",
            stt: 2,
            width: 150,

        },
        {
            key: 'moetCode',
            name: "Mã định danh bộ GD&ĐT",
            stt: 3,
            width: 200,

        },

        {
            key: 'ngaySinh',
            name: "Ngày sinh",
            stt: 5
        },
        {
            key: 'gioiTinh',
            name: "Giới tính",
            stt: 6,
            align: 'center'
        },
        {
            key: 'trangThai',
            name: "Trạng thái",
            stt: 7,
            width: 120
        },
        {
            key: 'maDanToc',
            name: "Dân tộc",
            stt: 8
        },
        {
            key: 'loaiCanBo',
            name: "Loại cán bộ",
            stt: 9,
            width: 140
        },
        {
            key: 'chucVu',
            name: "Nhóm chức vụ",
            stt: 10,
            width: 240
        },
        {
            key: 'loaiHopDong',
            name: "Hình thức hợp đồng",
            stt: 11,
            width: 450
        },
        {
            key: 'maTrinhDoChuyenMonCaoNhat',
            name: "T.Độ chuyên môn nghiệp vụ",
            stt: 12,
            width: 350
        },
        {
            key: 'maMonHoc',
            name: "Môn dạy",
            stt: 13,
            width: 170
        },
        {
            key: 'soDienThoaiDiDong',
            name: "Số điện thoại",
            stt: 14,
            width: 120
        },
        {
            key: 'queQuan',
            name: "Quê quán",
            stt: 16,
            width: 350
        },
        {
            key: 'noiSinh',
            name: "Nơi sinh",
            stt: 17,
            width: 160
        },
        {
            key: 'namSinh',
            name: "Năm sinh",
            stt: 18
        },
        {
            key: 'soCmnd',
            name: "Số CMTND/TCC",
            stt: 19,
            width: 140
        },
        {
            key: 'hinhThucDaoTao',
            name: "Hình thức đào tạo",
            stt: 20,
            width: 160
        },
        {
            key: 'doTuoi',
            name: "Độ tuổi",
            stt: 21
        },
        {
            key: 'trinhDoDaoTaoCnChinh',
            name: "Trình độ đạo tạo",
            stt: 22,
            width: 140
        },
        {
            key: 'dgKqChuanNgheNghiep',
            name: "Cấp trên đánh giá chuẩn nghề nghiệp",
            stt: 23,
            width: 280
        },
        {
            key: 'tuDanhGiaKqChuanNgheNghiep',
            name: "Tự đánh giá kết quả chuẩn nghề nghiệp",
            stt: 24,
            width: 280
        },
    ],
    list_mon_ngoai_ngu: [{
            value: '1',
            name: "Tiếng Anh"
        },
        {
            value: '4',
            name: "Tiếng Nga"
        },
        {
            value: '7',
            name: "Tiếng Pháp"
        },
        {
            value: '9',
            name: "Tiếng Thái"
        },
        {
            value: '21',
            name: "Ngoại ngữ khác"
        },
        {
            value: '5',
            name: "Tiếng Đức"
        },
        {
            value: '6',
            name: "Tiếng Trung Quốc"
        },
        {
            value: '2',
            name: "Tiếng Nhật"
        },
        {
            value: '3',
            name: "Tiếng Hàn"
        },
        {
            value: '8',
            name: "Tiếng Lào"
        },
    ],
    danh_sach_tim_kiem_danh_sach_lop_hoc: [{
            key: 'maTruongHoc',
            name: "Mã trường",
            stt: 1
        },
        {
            key: 'tenTruongHoc',
            name: "Tên trường",
            stt: 2
        },
        {
            key: 'maLopHoc',
            name: "Mã lớp",
            stt: 3,
            $isDisabled: true
        },
        {
            key: 'moetCode',
            name: "Mã định danh",
            stt: 4
        },
        {
            key: 'tenLopHoc',
            name: "Tên lớp học",
            stt: 5
        },
        {
            key: 'khoiHoc',
            name: "Khối học/Nhóm lớp",
            stt: 6
        },
        {
            key: 'tenGiaoVienCn',
            name: "Giáo viên chủ nhiệm",
            stt: 7
        },
        {
            key: 'buoiHoc',
            name: "Buổi học",
            stt: 8
        },
        {
            key: 'maNn1',
            name: "Học ngoại ngữ 1",
            stt: 9
        },
        {
            key: 'maNn2',
            name: "Học ngoại ngữ 2",
            stt: 10
        },
        // {
        //     key: 'heChuyen',
        //     name: "Hệ chuyên",
        //     stt: 11
        // },
        {
            key: 'phanBan',
            name: "Phân ban",
            stt: 12
        },
        {
            key: 'lopChuyen',
            name: "Lớp chuyên",
            stt: 13
        },
        {
            key: 'coHocSinhHocNghe',
            name: "Học sinh học nghề",
            stt: 14
        },
        {
            key: 'lopGhep',
            name: "Lớp ghép",
            stt: 15
        },
        {
            key: 'maLopGhep',
            name: "Ghép vào lớp",
            stt: 16
        },
        {
            key: 'lopBanTru',
            name: "Lớp bán trú",
            stt: 17
        },
        {
            key: 'soBuoiTrenTuan',
            name: "Số buổi học trên tuần",
            stt: 18
        },
        // {
        //     key: 'maDiemTruong',
        //     name: "Điểm trường",
        //     stt: 19
        // },
        // Hết nội dung hiển thị mặc định

        // {
        //     key: 'lopVnen',
        //     name: "Lớp VNEN",
        //     stt: 16
        // },
        // {
        //     key: 'lopCoTreKhuyetTat',
        //     name: "Lớp có trẻ khuyết tật",
        //     stt: 17
        // },
        // {
        //     key: 'lopChuyenBiet',
        //     name: "Lớp chuyên biệt",
        //     stt: 18
        // },
    ],
    // danh_sach_tim_kiem_danh_sach_ket_qua_hoc_tap: [{
    //         key: 'maTruongHoc',
    //         name: "Mã trường",
    //         stt: 1
    //     },
    //     {
    //         key: 'tenTruongHoc',
    //         name: "Trường học",
    //         stt: 2
    //     },
    //     {
    //         key: 'capHoc',
    //         name: "Cấp học",
    //         stt: 3
    //     },
    //     {
    //         key: 'khoiHoc',
    //         name: "Khối học/Nhóm tuổi",
    //         stt: 4
    //     },
    //     {
    //         key: 'tenLopHoc',
    //         name: "Tên lớp học",
    //         stt: 5
    //     },
    //     {
    //         key: 'tenHocSinh',
    //         name: "Họ và tên",
    //         stt: 6
    //     },
    //     {
    //         key: 'maHocSinh',
    //         name: "Mã học sinh",
    //         stt: 7
    //     },
    //     {
    //         key: 'moetCode',
    //         name: "Mã định danh Bộ GD&ĐT",
    //         stt: 8
    //     },
    //     {
    //         key: 'trangThai',
    //         name: "Trạng thái",
    //         stt: 9
    //     },
    //     {
    //         key: 'diemTongKet',
    //         name: "Điểm tổng kết",
    //         stt: 10
    //     },
    //     {
    //         key: 'namHoc',
    //         name: "Năm học",
    //         stt: 11
    //     },
    //     {
    //         key: 'hocKy',
    //         name: "Học kỳ",
    //         stt: 12
    //     },
    //     {
    //         key: 'giaiDoan',
    //         name: "Giai đoạn",
    //         stt: 13
    //     },
    //     {
    //         key: 'maHocLuc',
    //         name: "Học lực",
    //         stt: 14
    //     },
    //     {
    //         key: 'maHanhKiem',
    //         name: "Hạnh kiểm",
    //         stt: 15
    //     },
    //     {
    //         key: 'maDanhHieu',
    //         name: "Danh hiệu",
    //         stt: 16
    //     },
    //     {
    //         key: 'hthanhCtrinhLhoc',
    //         name: "Hoàn thành chương trình lớp học",
    //         stt: 17
    //     },
    //     {
    //         key: 'hoanThanhChuongTrinhMamMon',
    //         name: "Hoàn thành chương trình mầm non",
    //         stt: 18
    //     },
    //     {
    //         key: 'hoanThanhChuongTrinhTieuHoc',
    //         name: "Hoàn thành chương trình tiểu học",
    //         stt: 19
    //     },
    //     {
    //         key: 'kthuongCnam',
    //         name: "Khen thưởng cuối năm",
    //         stt: 20
    //     },
    //     {
    //         key: 'kthuongDxuat',
    //         name: "Khen thưởng đột xuất",
    //         stt: 21
    //     },
    //     {
    //         key: 'lenLop',
    //         name: "Lên lớp",
    //         stt: 22
    //     },
    //     {
    //         key: 'renLuyenLai',
    //         name: "Rèn luyện lại",
    //         stt: 23
    //     },
    //     {
    //         key: 'thiLai',
    //         name: "Thi lại",
    //         stt: 24
    //     },
    //     {
    //         key: 'duXetTotNghiep',
    //         name: "Dự xét tốt nghiệp",
    //         stt: 25
    //     },
    //     {
    //         key: 'totNghiep',
    //         name: "Tốt nghiệp",
    //         stt: 26
    //     },
    //     {
    //         key: 'maLoaiTotNghiep',
    //         name: "Loại tốt nghiệp",
    //         stt: 27
    //     },
    //     {
    //         key: 'soNgayNghi',
    //         name: "Số ngày nghỉ",
    //         stt: 28
    //     },
    //     {
    //         key: 'kqHocTap',
    //         name: "Kết quả học tập",
    //         stt: 29
    //     },
    //     {
    //         key: 'kqRenLuyen',
    //         name: "Kết quả rèn luyện",
    //         stt: 30
    //     },
    //     // {
    //     //     key: 'kiemTraSucKhoeDinhDuong',
    //     //     name: "Kiểm tra sức khỏe dinh dưỡng",
    //     //     stt: 31
    //     // },
    //     // {
    //     //     key: 'chieuCao',
    //     //     name: "Chiều cao (cm)",
    //     //     stt: 32
    //     // },
    //     // {
    //     //     key: 'canNang',
    //     //     name: "Cân nặng (kg)",
    //     //     stt: 33
    //     // },
    //     // {
    //     //     key: 'benhMat',
    //     //     name: "Bệnh về mắt",
    //     //     stt: 34
    //     // },
    //     // {
    //     //     key: 'isBietBoiKy1',
    //     //     name: "Biết bơi kỳ 1",
    //     //     stt: 35
    //     // },
    //     // {
    //     //     key: 'isBietBoiKy2',
    //     //     name: "Biết bơi kỳ 2",
    //     //     stt: 36
    //     // },
    //     {
    //         key: 'TvDgtx',
    //         name: "Đánh giá Tiếng Việt",
    //         stt: 37
    //     },
    //     {
    //         key: 'LoaiChungChiNghe',
    //         name: "Loại chứng chỉ nghề",
    //         stt: 38
    //     },
    //     {
    //         key: 'khenThuongCapHuyen',
    //         name: "Khen thưởng cấp huyện",
    //         stt: 39
    //     },
    //     // {
    //     //     key: 'TinhTrangDinhDuong',
    //     //     name: "Tình trạng dinh dưỡng",
    //     //     stt: 40
    //     // },
    //     {
    //         key: 'isKhamSkDky',
    //         name: "Khám sức khoẻ định kỳ",
    //         stt: 41
    //     },
    //     {
    //         key: 'isSuyDduongTheNheCan',
    //         name: "Suy dinh dưỡng thể nhẹ cân",
    //         stt: 42
    //     },
    //     {
    //         key: 'isSuyDduongTheCoiCoc',
    //         name: "Suy dinh dưỡng thể còi cọc",
    //         stt: 43
    //     },
    //     {
    //         key: 'beoPhi',
    //         name: "Béo phì",
    //         stt: 44
    //     },
    //     {
    //         key: 'suyDduongTheTcoi',
    //         name: "Suy dinh dưỡng thể thấp còi",
    //         stt: 45
    //     },
    //     {
    //         key: 'theoDoiBdoCcao',
    //         name: "Theo dõi biểu đồ chiều cao",
    //         stt: 46
    //     },
    //     {
    //         key: 'theoDoiBdoCnang',
    //         name: "Theo dõi biểu đồ cân nặng",
    //         stt: 47
    //     },
    //     {
    //         key: 'phoiIchayHhap',
    //         name: "Có bệnh về ỉa chảy, hô hấp",
    //         stt: 48
    //     },
    // ],

    danh_sach_tim_kiem_danh_sach_ket_qua_hoc_tap: [
        {
            key: 'maTruongHoc',
            name: "Mã trường",
            fixed:'left',
            stt: 1,
            width: 110
        },
        {
            key: 'tenTruongHoc',
            name: "Trường học",
            fixed:'left',
            stt: 2,
            width: 380
        },
        {
            key: 'tenHocSinh',
            name: "Họ và tên",
            fixed:'left',
            stt: 6,
            width: 350
        },
        {
            key: 'capHoc',
            name: "Cấp học",
            stt: 3,
            width: 100
        },
        {
            key: 'khoiHoc',
            name: "Khối học/Nhóm tuổi",
            stt: 4,
            width: 170
        },
        {
            key: 'tenLopHoc',
            name: "Tên lớp học",
            stt: 5,
            width: 130
        },

        {
            key: 'maHocSinh',
            name: "Mã học sinh",
            stt: 7,
            width: 150
        },
        {
            key: 'moetCode',
            name: "Mã định danh Bộ GD&ĐT",
            stt: 8,
            width: 200
        },
        {
            key: 'trangThai',
            name: "Trạng thái",
            stt: 9,
            width: 100
        },
        {
            key: 'diemTongKet',
            name: "Điểm tổng kết",
            stt: 10,
            width: 130
        },
        {
            key: 'namHoc',
            name: "Năm học",
            stt: 11,
            width: 120
        },
        {
            key: 'hocKy',
            name: "Học kỳ",
            stt: 12,
            width: 100
        },
        {
            key: 'giaiDoan',
            name: "Giai đoạn",
            stt: 13,
            width: 120
        },
        {
            key: 'maHocLuc',
            name: "Học lực",
            stt: 14,
            width: 120
        },
        {
            key: 'maHanhKiem',
            name: "Hạnh kiểm",
            stt: 15,
            width: 120
        },
        {
            key: 'maDanhHieu',
            name: "Danh hiệu",
            stt: 16,
            width: 120
        },
        {
            key: 'hthanhCtrinhLhoc',
            name: "Hoàn thành chương trình lớp học",
            stt: 17,
            width: 150
        },
        {
            key: 'hoanThanhChuongTrinhMamMon',
            name: "Hoàn thành chương trình mầm non",
            stt: 18,
            width: 150
        },
        {
            key: 'hoanThanhChuongTrinhTieuHoc',
            name: "Hoàn thành chương trình tiểu học",
            stt: 19,
            width: 150
        },
        {
            key: 'kthuongCnam',
            name: "Khen thưởng cuối năm",
            stt: 20,
            width: 180
        },
        {
            key: 'kthuongDxuat',
            name: "Khen thưởng đột xuất",
            stt: 21,
            width: 180
        },
        {
            key: 'lenLop',
            name: "Lên lớp",
            stt: 22,
            width: 100
        },
        {
            key: 'renLuyenLai',
            name: "Rèn luyện lại",
            stt: 23,
            width: 120
        },
        {
            key: 'thiLai',
            name: "Thi lại",
            stt: 24,
            width: 100
        },
        {
            key: 'duXetTotNghiep',
            name: "Dự xét tốt nghiệp",
            stt: 25,
            width: 150
        },
        {
            key: 'totNghiep',
            name: "Tốt nghiệp",
            stt: 26,
            width: 120
        },
        {
            key: 'maLoaiTotNghiep',
            name: "Loại tốt nghiệp",
            stt: 27,
            width: 150
        },
        {
            key: 'soNgayNghi',
            name: "Số ngày nghỉ",
            stt: 28,
            width: 120
        },
        {
            key: 'kqHocTap',
            name: "Kết quả học tập",
            stt: 29,
            width: 150
        },
        {
            key: 'kqRenLuyen',
            name: "Kết quả rèn luyện",
            stt: 30,
            width: 150
        },
        {
            key: 'TvDgtx',
            name: "Đánh giá Tiếng Việt",
            stt: 37,
            width: 150
        },
        {
            key: 'LoaiChungChiNghe',
            name: "Loại chứng chỉ nghề",
            stt: 38,
            width: 150
        },
        {
            key: 'khenThuongCapHuyen',
            name: "Khen thưởng cấp huyện",
            stt: 39,
            width: 180
        },
        {
            key: 'isKhamSkDky',
            name: "Khám sức khoẻ định kỳ",
            stt: 41,
            width: 180
        },
        {
            key: 'isSuyDduongTheNheCan',
            name: "Suy dinh dưỡng thể nhẹ cân",
            stt: 42,
            width: 180
        },
        {
            key: 'isSuyDduongTheCoiCoc',
            name: "Suy dinh dưỡng thể còi cọc",
            stt: 43,
            width: 180
        },
        {
            key: 'beoPhi',
            name: "Béo phì, thừa cân",
            stt: 44,
            width: 100
        },
        {
            key: 'suyDduongTheTcoi',
            name: "Suy dinh dưỡng thể thấp còi",
            stt: 45,
            width: 180
        },
        {
            key: 'theoDoiBdoCcao',
            name: "Theo dõi biểu đồ chiều cao",
            stt: 46,
            width: 200
        },
        {
            key: 'theoDoiBdoCnang',
            name: "Theo dõi biểu đồ cân nặng",
            stt: 47,
            width: 200
        },
        {
            key: 'phoiIchayHhap',
            name: "Có bệnh về ỉa chảy, hô hấp",
            stt: 48,
            width: 200
        }
    ],

    danh_sach_mon_hoc_tra_cuu_hoc_tap: [
        {
            id: "01",
            name: "Mẫu giáo"
        },
        {
            id: "02",
            name: "Nhà trẻ"
        },
        {
            id: "09",
            name: "Tiểu học"
        },
        {
            id: "14",
            name: "Công nghệ (Công nghiệp)"
        },
        // {id: "KTC",name: "Kỹ thuật công nghiệp"},
        {
            id: "28",
            name: "Nhóm nghề nông lâm"
        },
        {
            id: "29",
            name: "Nhóm nghề tiểu thủ công nghiệp"
        },
        {
            id: "30",
            name: "Nhóm nghề dịch vụ"
        },
        {
            id: "KTC",
            name: "Công nghệ"
        },
        {
            id: "ANC",
            name: "Âm nhạc"
        },
        {
            id: "DLY",
            name: "Địa lý"
        },
        {
            id: "TAH",
            name: "Tiếng Anh"
        },
        {
            id: "TDC",
            name: "Thể dục"
        },
        {
            id: "THC",
            name: "Tin học"
        },
        {
            id: "TNA",
            name: "Tiếng Nga"
        },
        {
            id: "TPP",
            name: "Tiếng Pháp"
        },
        {
            id: "TTG",
            name: "Tiếng Trung"
        },
        {
            id: "KTN2",
            name: "Công nghệ (Nông nghiệp)"
        },
        {
            id: "GCD",
            name: "Giáo dục công dân"
        },
        {
            id: "HHC",
            name: "Hóa học"
        },
        {
            id: "LSU",
            name: "Lịch sử"
        },
        {
            id: "MTT",
            name: "Mỹ thuật"
        },
        {
            id: "SHC",
            name: "Sinh học"
        },
        {
            id: "TOC",
            name: "Toán học"
        },
        {
            id: "VLY",
            name: "Vật lý"
        },
        {
            id: "CNE",
            name: "Công nghệ"
        },
        {
            id: "GDQPAN",
            name: "Giáo dục quốc phòng"
        },
        {
            id: "KTN",
            name: "Kỹ thuật nông nghiệp"
        },
        {
            id: "TCN",
            name: "Nhóm nghề khác"
        },
        {
            id: "TDT",
            name: "Tiếng dân tộc"
        },
        {
            id: "TDU",
            name: "Ngoại ngữ khác"
        },
        {
            id: "THN",
            name: "Ngoại ngữ khác"
        },
        {
            id: "TLO",
            name: "Ngoại ngữ khác"
        },
        {
            id: "TTI",
            name: "Ngoại ngữ khác"
        },
        {
            id: "TNT",
            name: "Ngoại ngữ khác"
        },
        {
            id: "TVT",
            name: "Ngữ Văn"
        },
    ],
    listCapHoc() {
        let arr = [];
        arr.push({
            id: this.CAP_HOC_CAP_1,
            name: "Tiểu học"
        });
        arr.push({
            id: this.CAP_HOC_CAP_2,
            name: "THCS"
        });
        arr.push({
            id: this.CAP_HOC_CAP_3,
            name: "THPT"
        });
        arr.push({
            id: this.CAP_HOC_CAP_MAU_GIAO,
            name: "Mẫu giáo"
        });
        arr.push({
            id: this.CAP_HOC_CAP_NHA_TRE,
            name: "Nhà trẻ"
        });
        return arr;
    },


    LOAI_DONVI_PHONG: 2,
    LOAI_DONVI_SO: 1,
    //LIST_YEARS_FULL_OLD là danh sách năm học lấy từ 8 năm về trước và 2 năm về sau
    LIST_YEARS_FULL: (function() {
        const currentYear = new Date().getFullYear();
        const years = [];
        for (let i = currentYear - 10; i <= currentYear + 2; i++) {
            years.push({
                id: i,
                name: `${i}-${i + 1}`
            });
        }
        return years;
    })(),

    LIST_YEARS: [

        {id: 2011,name: "2011-2012"},
        {id: 2012,name: "2012-2013"},
        {id: 2013,name: "2013-2014"},
        {id: 2014,name: "2014-2015"},
        {id: 2015,name: "2015-2016"},
        {id: 2016,name: "2016-2017"},
        {
            id: 2017,
            name: "2017-2018"
        }, {
            id: 2018,
            name: "2018-2019"
        }, {
            id: 2019,
            name: "2019-2020"
        }, {
            id: 2020,
            name: "2020-2021"
        },
        {id: 2021,name: "2021-2022"},
        {id: 2022,name: "2022-2023"},
        {id: 2023,name: "2023-2024"},
        {id: 2024,name: "2024-2025"},
        {id: 2025,name: "2025-2026"},
        {id: 2026,name: "2026-2027"},
    ],
    list_cap_hoc_ap_dung_yeu_cau_nop_du_lieu_theo_bieu_mau: [{
        id: 'phong',
        name: "Phòng"
    }, {
        id: 'phong',
        name: "Nhà trẻ"
    }, {
        id: 'phong',
        name: "Mẫu giáo"
    }, {
        id: 'phong',
        name: "Mầm non"
    }, {
        id: 'phong',
        name: "Tiểu học"
    }, {
        id: 'phong',
        name: "THCS"
    }, {
        id: 'phong',
        name: "PTCS"
    }, {
        id: 'phong',
        name: "THPT"
    }, {
        id: 'phong',
        name: "PTTH"
    }, {
        id: 'phong',
        name: "Phổ thông"
    }, {
        id: 'phong',
        name: "GDTX"
    }],
    LIST_YEARS_SYNC_OLD: [

        {
            id: 2014,
            name: "2014-2015"
        }, {
            id: 2015,
            name: "2015-2016"
        }, {
            id: 2016,
            name: "2016-2017"
        }, {
            id: 2017,
            name: "2017-2018"
        }, {
            id: 2018,
            name: "2018-2019"
        }
    ],
    LIST_CAP_HOC: [{
            id: 1,
            name: "Cấp 1"
        }, {
            id: 2,
            name: "Cấp 2"
        }, {
            id: 3,
            name: "Cấp 3"
        }, {
            id: 4,
            name: "Nhà trẻ"
        }, {
            id: 5,
            name: "Mẫu giáo"
        },
        {
            id: 45,
            name: "Mầm non"
        }, {
            id: 12,
            name: "Trường liên cấp 1+2"
        }, {
            id: 13,
            name: "Trường liên cấp 1+3"
        }, {
            id: 23,
            name: "Trường liên cấp 2+3"
        }, {
            id: 123,
            name: "Trường liên cấp 1+2+3"
        }, {
            id: 6,
            name: "GDTX"
        },
    ],
    TRANG_THAI_CAN_BO: [{
        value: 1,
        name: "Đang làm việc"
    }, {
        value: 2,
        name: "Chuyển đến"
    }, {
        value: 3,
        name: "Chuyển đi"
    }, {
        value: 4,
        name: "Đã điều động"
    }, {
        value: 5,
        name: "Chờ nghỉ hưu"
    }, {
        value: 6,
        name: "Đã nghỉ hưu"
    }, {
        value: 7,
        name: "Đã biệt phái"
    }],
    GIOI_TINH: [{
        value: '1',
        name: "Nam"
    }, {
        value: '0',
        name: "Nữ"
    }],
    LOAI_HINH_TRUONG: [{
        value: 1,
        name: "Công lập"
    }, {
        value: 2,
        name: "Tư thục"
    }, {
        value: 3,
        name: "GDTX"
    }, {
        value: 4,
        name: "Bán công"
    }, {
        value: 5,
        name: "Dân lập"
    }],
    LOAI_TRUONG: [{
        value: "01",
        name: "Dân tộc bán trú"
    }, {
        value: "02",
        name: "Dân tộc nội trú Tỉnh"
    }, {
        value: "03",
        name: "Dân tộc nội trú Huyện"
    }, {
        value: "04",
        name: "Trẻ em khuyết tật"
    }, {
        value: "05",
        name: "Năng khiếu nghệ thuật"
    }, {
        value: "06",
        name: "Năng khiếu thể dục thể thao"
    }, {
        value: "07",
        name: "Trường phổ thông"
    }, {
        value: "08",
        name: "Trẻ em thiệt thòi"
    }, {
        value: "09",
        name: "Trường chuyên"
    }, {
        value: "10",
        name: "Trường THPT kỹ thuật"
    }, {
        value: "13",
        name: "Mầm non"
    }, {
        value: "15",
        name: "TT GDTX"
    }, {
        value: "16",
        name: "TT GDNN - GDTX (Sát nhập theo TTLT số 39/2015)"
    }, {
        value: "17",
        name: "TT GDTX - DN - HN (Các tên gọi khác)"
    }, {
        value: "18",
        name: "Khuyết tật"
    }],
    LOAI_HOP_DONG: [{
        value: "0",
        name: "Hợp đồng làm việc"
    }, {
        value: "1",
        name: "Viên chức HĐLV không xác định thời hạn"
    }, {
        value: "2",
        name: "Hợp đồng làm việc theo nghị định 68"
    }, {
        value: "3",
        name: "Hợp đồng làm việc trên 1 năm"
    }, {
        value: "4",
        name: "Hợp đồng làm việc dưới 1 năm"
    }, {
        value: "5",
        name: "Thỉnh giảng"
    }, {
        value: "6",
        name: "Hợp đồng thuê khoán"
    }, {
        value: "7",
        name: "Viên chức HĐLV xác định thời hạn"
    }],
    // danh sách trạng thái đẩy lên bộ
    list_trang_thai_day_len_bo: [{
        id: "0",
        name: "Chờ đẩy"
    }, {
        id: "1",
        name: "Đang đẩy"
    }, {
        id: "2",
        name: "Đẩy thành công"
    }, {
        id: "3",
        name: "Đẩy lỗi"
    }, {
        id: "4",
        name: "Cần đẩy lại"
    }, {
        id: "5",
        name: "Thiếu mật khẩu kết chuyển"
    }, {
        id: "6",
        name: "Tài khoản kết chuyển không chính xác"
    }, {
        id: "7",
        name: "Content chưa đúng"
    }, {
        id: "9",
        name: "Chờ tổng hợp"
    }, {
        id: "10",
        name: "Đang tổng hợp"
    }, {
        id: "11",
        name: "Tổng hợp xong"
    }, {
        id: "12",
        name: "Tổng hợp lỗi"
    }, {
        id: "13",
        name: "Hoàn thành"
    }],
    // Danh sách trạng thái tiếp nhận dữ liệu
    ds_trang_thai_tiep_nhan_du_lieu: [{
        id: 0,
        name: "Đang xử lý"
    }, {
        id: 1,
        name: "Đã nhận"
    }, {
        id: 2,
        name: "Xảy ra lỗi"
    }, {
        id: 3,
        name: "Đã đồng bộ"
    }, {
        id: 4,
        name: "Lỗi đồng bộ"
    }],
    // Danh sách loại tiếp nhận dữ liệu
    ds_loai_tiep_nhan_du_lieu: [{
        id: 1,
        name: "Đẩy thông tin đầu năm"
    }, {
        id: 2,
        name: "Đẩy thông tin phát sinh"
    }, {
        id: 3,
        name: "Đẩy thông tin cuối năm"
    }, {
        id: 4,
        name: "Đồng bộ dữ liệu cũ"
    }],
    // Danh sách loại tiếp nhận dữ liệu
    ds_loai_dong_bo_tiep_nhan_du_lieu: [{
        id: 1,
        name: "Sửa học sinh theo lô"
    }, {
        id: 2,
        name: "Sửa giáo viên theo lô"
    }, {
        id: 3,
        name: "Đẩy thông tin đầu năm"
    }, {
        id: 4,
        name: "Đẩy thông tin học sinh biến động"
    }, {
        id: 5,
        name: "Đẩy thông tin điểm"
    }, {
        id: 6,
        name: "Đẩy thông tin cuối năm"
    }, {
        id: 8,
        name: "Đẩy dữ liệu đầu năm (*)"
    }, {
        id: 9,
        name: "Đẩy dữ liệu EQMS giữa năm"
    }],
    // danh sách học kỳ
    LIST_HOC_KY: [{
        id: 1,
        name: "Học kỳ I"
    }, {
        id: 2,
        name: "Học kỳ II"
    }, {
        id: 3,
        name: "Cả năm"
    }],

    CHUAN_TRUONG: [{
        value: 1,
        name: "Chuẩn loại 1"
    }, {
        value: 2,
        name: "Chuẩn loại 2"
    }, {
        value: 0,
        name: "Không đạt chuẩn"
    }],
    NHOM_CAN_BO: [{
        value: 1,
        name: "Cán bộ quản lý"
    }, {
        value: 2,
        name: "Giáo viên"
    }, {
        value: 3,
        name: "Nhân viên"
    }],
    TRINH_DO_CHUYEN_MON: [{
        value: "01",
        name: "Tiến sỹ"
    }, {
        value: "02",
        name: "Thạc sỹ"
    }, {
        value: "03",
        name: "Đại học"
    }, {
        value: "04",
        name: "Cao đẳng"
    }, {
        value: "05",
        name: "Trung cấp"
    }, {
        value: "06",
        name: "Trình độ khác"
    }, {
        value: "07",
        name: "Bác sỹ chuyên khoa 1"
    }, {
        value: "08",
        name: "Bác sỹ chuyên khoa 2"
    }, {
        value: "09",
        name: "TH 12+2"
    }, {
        value: "10",
        name: "TH 9+3"
    }, {
        value: "11",
        name: "Dưới THSP"
    }, {
        value: "13",
        name: "Đại học và có chứng chỉ BDNVSP"
    }, {
        value: "14",
        name: "Cao đẳng và có chứng chỉ BDNVSP"
    }, {
        value: "15",
        name: "Trung cấp và có chứng chỉ BDNVSP"
    }, {
        value: "16",
        name: "Đại học sư phạm"
    }, {
        value: "17",
        name: "Cao đẳng sư phạm"
    }, {
        value: "18",
        name: "Trung cấp sư phạm"
    }],
    LY_DO_THOI_HOC: [{
            value: "01",
            name: "Có hoàn cảnh kinh tế gia đình khó khăn"
        },
        {
            value: "02",
            name: "Học lực yếu kém"
        },
        {
            value: "03",
            name: "Xa trường, đi lại khó khăn"
        },
        {
            value: "04",
            name: "Ảnh hưởng thiên tai, dịch bệnh"
        },
        {
            value: "05",
            name: "Do kỳ thị"
        },
        {
            value: "07",
            name: "Bảo lưu kết quả"
        },
        {
            value: "08",
            name: "Chuyển sang học nghề"
        },
        {
            value: "06",
            name: "Nguyên nhân khác"
        },
    ],
    KHU_VUC: [{
        value: "01",
        name: "Biên giới - hải đảo"
    }, {
        value: "02",
        name: "Đô thị"
    }, {
        value: "03",
        name: "Đồng bằng"
    }, {
        value: "04",
        name: "Miền núi - vùng sâu"
    }],
    LOAI_NHAP_HOC: [
        {
            value: 1,
            name: "Tuyển mới"
        },
        {
            value: 3,
            name: "Chuyển đến từ trường khác"
        },
    ],
    LOAI_CAN_BO: [{
        value: "01",
        name: "Hiệu trưởng"
    }, {
        value: "02",
        name: "Phó hiệu trưởng"
    }, {
        value: "03",
        name: "Tổ trưởng chuyên môn"
    }, {
        value: "04",
        name: "Tổ phó chuyên môn"
    }, {
        value: "05",
        name: "Giám đốc"
    }, {
        value: "06",
        name: "Phó giám đốc"
    }, {
        value: "07",
        name: "Trưởng phòng"
    }, {
        value: "08",
        name: "Phó trưởng phòng"
    }, {
        value: "09",
        name: "Nhân viên thư viện"
    }, {
        value: "10",
        name: "Nhân viên thiết bị"
    }, {
        value: "11",
        name: "Nhân viên y tế"
    }, {
        value: "12",
        name: "Nhân viên khác"
    }, {
        value: "13",
        name: "Nhân viên thí nghiệm"
    }, {
        value: "14",
        name: "Nhân viên kỹ thuật nghiệp vụ"
    }, {
        value: "15",
        name: "Nhân viên kế toán"
    }, {
        value: 16,
        name: "Nhân viên vấn thư"
    }, {
        value: 17,
        name: "Nhân viên bảo vệ"
    }, {
        value: 18,
        name: "Trợ giảng ngôn ngữ L1"
    }, {
        value: 19,
        name: "Trợ giảng ngôn ngữ L2"
    }, {
        value: 20,
        name: "Nhân viên cấp dưỡng"
    }, {
        value: 21,
        name: "Nhân viên bảo mẫu"
    }, {
        value: 22,
        name: "Tổ trưởng"
    }, {
        value: 23,
        name: "Tổ phó"
    }, {
        value: 24,
        name: "Chuyên viên"
    }, {
        value: 25,
        name: "Nhân viên thủ quỹ"
    }, {
        value: 26,
        name: "Nhân viên lái xe"
    }, {
        value: 27,
        name: "Cấp THPT"
    }, {
        value: 28,
        name: "Cấp THCS"
    }, {
        value: 29,
        name: "Cấp tiểu học"
    }, {
        value: 30,
        name: "Cấp mần non"
    }, {
        value: 31,
        name: "Nấu ăn"
    }, {
        value: 32,
        name: "Nhân viên công nghệ thông tin"
    }, {
        value: 33,
        name: "Nhân viên hỗ trợ GD khuyết tật"
    }, {
        value: 34,
        name: "Nhân viên giáo vụ"
    }],
    DO_TUOI: [{
        value: '10',
        name: "Dưới 20 tuổi"
    }, {
        value: '20',
        name: "Từ 20-29 tuổi"
    }, {
        value: '30',
        name: "Từ 30-39 tuổi"
    }, {
        value: '40',
        name: "Từ 40-49 tuổi"
    }, {
        value: '50',
        name: "Từ 50-54 tuổi"
    }, {
        value: '55',
        name: "Từ 55-59 tuổi"
    }, {
        value: '60',
        name: "Trên 60 tuôi"
    }],
    DANH_GIA_CHUAN_NGHE_NGHIEP: [{
        value: 1,
        name: "Tốt"
    }, {
        value: 2,
        name: "Khá"
    }, {
        value: 3,
        name: "Đạt"
    }, {
        value: 4,
        name: "Chưa đánh giá"
    }],
    DANH_SACH_DANH_MUC_SERVICE_HO_SO: [{
        value: "GET_DM_SO",
        name: "Danh mục sở"
    }, {
        value: "GET_DM_PHONG",
        name: "Danh mục phòng"
    }, {
        value: "GET_DM_TRUONG",
        name: "Danh mục trường"
    }],
    DANH_SACH_DANH_MUC_SERVICE: [{
            value: "GET_DM_TINH",
            name: "Danh mục tỉnh"
        }, {
            value: "GET_DM_KHU_VUC",
            name: "Danh mục khu vực"
        }, {
            value: "GET_DM_LOAI_TRUONG",
            name: "Danh mục loại trường"
        }, {
            value: "GET_DM_KHOI",
            name: "Danh mục khối"
        }, {
            value: "GET_DM_NHOM_TUOI",
            name: "Danh mục nhóm tuổi"
        }, {
            value: "GET_DM_TIET_HOC",
            name: "Danh mục tiết học"
        }, {
            value: "GET_DM_HOC_NGOAI_NGU",
            name: "Danh mục học ngoại ngữ"
        }, {
            value: "GET_DM_SO_TIET_NGOAI_NGU",
            name: "Danh mục số tiết ngoại ngữ"
        }, {
            value: "GET_DM_MON_HOC",
            name: "Danh mục môn học"
        }, {
            value: "GET_DM_PHAN_BAN",
            name: "Danh mục phân ban"
        }, {
            value: "GET_DM_HE_CHUYEN",
            name: "Danh mục hệ chuyên"
        }, {
            value: "GET_DM_KIEU_LOP",
            name: "Danh mục kiểu lớp"
        }, {
            value: "GET_DM_HINH_THUC_DAO_TAO_HOC_TAP",
            name: "Danh mục hình thức đào tạo học tập"
        }, {
            value: "GET_DM_LOP_DAO_TAO_BOI_DUONG",
            name: "Danh mục lớp đào tạo bổi dưỡng"
        }, {
            value: "GET_DM_LOP_HUONG_NGHIEP_DAY_NGHE",
            name: "Danh mục lớp hướng nghiệp dạy nghề"
        }, {
            value: "GET_DM_GIOI_TINH",
            name: "Danh mục giới tính"
        }, {
            value: "GET_DM_TRANG_THAI_HOC_SINH",
            name: "Danh mục trạng thái học sinh"
        }, {
            value: "GET_DM_LY_DO_THOI_HOC",
            name: "Danh mục lý do thôi học"
        }, {
            value: "GET_DM_DAN_TOC",
            name: "Danh mục dân tộc"
        }, {
            value: "GET_DM_LOAI_KHUYET_TAT",
            name: "Danh mục loại khuyết tật"
        }, {
            value: "GET_DM_DIEN_CHINH_SACH",
            name: "Danh mục diện chính sách"
        }, {
            value: "GET_DM_TRANG_THAI_CAN_BO",
            name: "Danh mục trạng thái cán bộ"
        }, {
            value: "GET_DM_NHOM_CAN_BO",
            name: "Danh mục nhóm cán bộ"
        }, {
            value: "GET_DM_LOAI_CAN_BO",
            name: "Danh mục loại cán bộ"
        }, {
            value: "GET_DM_NGACH",
            name: "Danh mục ngạch công chức"
        }, {
            value: "GET_DM_MON_DAY_GV",
            name: "Danh mục môn dạy giáo viên"
        }, {
            value: "GET_DM_BAC_LUONG",
            name: "Danh mục bậc lương"
        }, {
            value: "GET_DM_BOI_DUONG_TX",
            name: "Danh mục bồi dưỡng thường xuyên"
        }, {
            value: "GET_DM_TRINH_DO_CHUYEN_MON_NGHIEP_VU",
            name: "Danh mục trình độ chuyên môn nghiệp vụ"
        }, {
            value: "GET_DM_TRINH_DO_LLCT",
            name: "Danh mục trình độ lý luận chính trị"
        }, {
            value: "GET_DM_TRINH_DO_QLGD",
            name: "Danh mục trình độ quản lý giáo dục"
        }, {
            value: "GET_DM_NGOAI_NGU",
            name: "Danh mục ngoại ngữ"
        }, {
            value: "GET_DM_TRINH_DO_NGOAI_NGU",
            name: "Danh mục trình độ ngoại ngữ"
        }, {
            value: "GET_DM_TRINH_DO_TIN_HOC",
            name: "Danh mục trình độ tin học"
        }, {
            value: "GET_DM_CHUYEN_MON",
            name: "Danh mục chuyên môn"
        }, {
            value: "GET_DM_KQ_CHUAN_NGHE_NGHIEP",
            name: "Danh mục kết quả chuẩn nghề nghiệp"
        }, {
            value: "GET_DM_DG_VIEN_CHUC",
            name: "Danh mục đánh giá viên chức"
        }, {
            value: "GET_DM_GIAO_VIEN_GIOI",
            name: "Danh mục giáo viên giỏi"
        }, {
            value: "GET_DM_NHIEM_VU_KIEM_NHIEM",
            name: "Danh mục nhiệm vụ kiêm nhiệm"
        }, {
            value: "GET_DM_NHOM_CHUYEN_NGANH",
            name: "Danh mục nhóm chuyên ngành"
        }, {
            value: "GET_DM_KHEN_THUONG_GV",
            name: "Danh mục khen thưởng giáo viên"
        }, {
            value: "GET_DM_KY_LUAT_GV",
            name: "Danh mục kỷ luật giáo viên"
        }, {
            value: "GET_DM_VUNG_KHO_KHAN",
            name: "Danh mục vùng khó khăn"
        }, {
            value: "GET_DM_CAP_DON_VI",
            name: "Danh mục cấp đơn vị"
        }, {
            value: "GET_DM_CAP_HOC",
            name: "Danh mục cấp học"
        }, {
            value: "GET_DM_CHUAN_DAO_TAO",
            name: "Danh mục chuẩn đào tạo"
        }, {
            value: "GET_DM_CHUC_VU_DANG_VIEN",
            name: "Danh mục chức vụ đảng viên"
        }, {
            value: "GET_DM_CHUC_VU_DOAN_VIEN",
            name: "Danh mục chức vụ đoàn viên"
        }, {
            value: "GET_DM_CHUYEN_NGANH_DAO_TAO",
            name: "Danh mục chuyên ngành đào tạo"
        }, {
            value: "GET_DM_DANG_NGHI_BHXH",
            name: "Danh mục dạng nghỉ bảo hiểu xã hội"
        }, {
            value: "GET_DM_DANH_HIEU",
            name: "Danh mục danh hiệu"
        }, {
            value: "GET_DM_DIEN_UU_TIEN_GD",
            name: "Danh mục diện ưu tiên giáo dục"
        }, {
            value: "GET_DM_DU_AN",
            name: "Danh mục dự án"
        }, {
            value: "GET_DM_GV_GIANG_DAY_VH",
            name: "Danh mục giáo viên giảng dạy văn hóa"
        }, {
            value: "GET_DM_HANG_THUONG_BINH",
            name: "Danh mục hạng thương binh"
        }, {
            value: "GET_DM_HANH_KIEM",
            name: "Danh mục hạnh kiểm"
        }, {
            value: "GET_DM_HINH_THUC_DAO_TAO",
            name: "Danh mục hình thức đào tạo"
        }, {
            value: "GET_DM_HINH_THUC_KHEN_THUONG",
            name: "Danh mục hình thức khen thưởng"
        }, {
            value: "GET_DM_HINH_THUC_KY_LUAT",
            name: "Danh mục hình thức kỷ luật"
        }, {
            value: "GET_DM_HINH_THUC_TUYEN_DUNG",
            name: "Danh mục hình thức tuyển dụng"
        }, {
            value: "GET_DM_HOC_HAM",
            name: "Danh mục học hàm"
        }, {
            value: "GET_DM_HOC_LUC",
            name: "Danh mục học lực"
        }, {
            value: "GET_DM_HOC_VAN_PHO_THONG",
            name: "Danh mục học vấn phổ thông"
        }, {
            value: "GET_DM_HOC_VI",
            name: "Danh mục học vị"
        }, {
            value: "GET_DM_KENH_TANG_TRUONG_CAN_NANG",
            name: "Danh mục kênh tang trưởng cân nặng"
        }, {
            value: "GET_DM_KHEN_THUONG_NHAN_SU",
            name: "Danh mục khen thưởng nhân sự"
        }, {
            value: "GET_DM_LOAI_GV_GIANG_DAY_VAN_HOA",
            name: "Danh mục loại giáo viên giảng dạy văn hóa"
        }, {
            value: "GET_DM_LOP_GHEP",
            name: "Danh mục lớp ghép"
        }, {
            value: "GET_DM_MIEN_GIAM_HOC_PHI",
            name: "Danh mục miễn giảm học phí"
        }, {
            value: "GET_DM_MOI_QUAN_HE",
            name: "Danh mục mối quan hệ"
        }, {
            value: "GET_DM_NGANH_DAO_TAO",
            name: "Danh mục ngành đào tạo"
        }, {
            value: "GET_DM_QUAN_HAM",
            name: "Danh mục quân hàm"
        }, {
            value: "GET_DM_TIENG_DAN_TOC",
            name: "Danh mục tiếng dân tộc"
        }, {
            value: "GET_DM_TINH_TRANG_HON_NHAN",
            name: "Danh mục tình trạng hôn nhân"
        }, {
            value: "GET_DM_TINH_TRANG_SUC_KHOE",
            name: "Danh mục tình trạng sức khỏe"
        }, {
            value: "GET_DM_TON_GIAO",
            name: "Danh mục tôn giáo"
        }, {
            value: "GET_DM_TOT_NGHIEP",
            name: "Danh mục tốt nghiệp"
        }, {
            value: "GET_DM_TRINH_DO",
            name: "Danh mục trình độ"
        }, {
            value: "GET_DM_TRINH_DO_HANH_CHINH_NHA_NUOC",
            name: "Danh mục trình độ hành chính nhà nước"
        }, {
            value: "GET_DM_HOC_BAN_TRU",
            name: "Danh mục học bán trú"
        }, {
            value: "GET_DM_SO_BUOI_HOC_TREN_TUAN",
            name: "Danh mục số buổi học trên tuần"
        }, {
            value: "GET_DM_TRUNG_TAM",
            name: "Danh mục trung tâm"
        }, {
            value: "GET_DM_LOAI_TRUNG_TAM",
            name: "Danh mục loại trung tâm"
        }, {
            value: "GET_DM_GIAI_DOAN_KQHT",
            name: "Danh mục giai đoạn kết quả học tập"
        }, {
            value: "DM_NHOM_CCHI_NNGU",
            name: "	Danh mục nhóm chứng chỉ ngoại ngữ"
        }, {
            value: "DM_LOAI_CCHI_NNGU",
            name: "	Danh mục loại chứng chỉ ngoại ngữ"
        }, {
            value: "DM_KHUNG_NLUC_NNGU	",
            name: "Danh mục khung năng lực ngoại ngữ"
        }, {
            value: "DM_GIAO_VIEN_CHU_NHIEM_GIOI",
            name: "	Danh mục giáo viên chủ nhiệm giỏi"
        }, {
            value: "DM_GV_TONG_PTRACH_DOI_GIOI",
            name: "	Danh mục tổng phụ trách đội giỏi"
        }, {
            value: "DM_CHUNG_CHI_TIENG_DTOC_TSO",
            name: "	Danh mục chứng chỉ tiếng dân tộc thiểu số"
        }, {
            value: "DM_BOI_DUONG_NVU",
            name: "	Danh mục bồi dưỡng nghiệp vụ"
        },
        // {value: "DM_BOI_DUONG_THAY_SACH", name: "	Danh mục tham gia bồi dưỡng thay
        // sách"},   cần năm học
        {
            value: "GET_ALL_HUYEN",
            name: "	Danh mục huyện"
        }, {
            value: "GET_DM_XA",
            name: "	Danh mục xã theo năm học"
        }, {
            value: "GET_DM_LOAI_HINH",
            name: "	Danh mục loại hình"
        }, {
            value: "GET_DM_HINH_THUC_HOP_DONG",
            name: "Danh mục hình thức hợp đồng"
        }, {
            value: "GET_DM_VUNG",
            name: "Danh mục vùng"
        },
        //   cần cấp học
        {
            value: "GET_DM_KHOI_BY_MA_CAP_HOC",
            name: " Danh mục khối theo mã cấp học"
        }, {
            value: "DM_BOI_DUONG_CBQL_COT_CAN",
            name: "Danh mục bồi dưỡng cán bộ quản lý, giáo viên cốt cán"
        }, {
            value: "GET_DM_MON_DAY_GV_BY_CAP_HOC",
            name: "Danh mục môn dạy giáo viên theo mã cấp học"
        }, {
            value: "GET_DM_DIEN_CHINH_SACH_BY_MA_CAP_HOC",
            name: " Danh mục diện chính sách theo cấp học"
        }, {
            value: "GET_DM_NHOM_CAP_HOC",
            name: "Danh mục nhóm cấp học"
        }, {
            value: "GET_DM_MUC_DAT_CHUAN_QUOC_GIA",
            name: "Danh mục đạt chuẩn quốc gia"
        }
    ],
    // Loại hình đào tạo
    list_loai_hinh_dao_tao: [{
        id: 1,
        name: "Công lập"
    }, {
        id: 2,
        name: "Tư thục"
    }, {
        id: 3,
        name: "GDTX"
    }, {
        id: 4,
        name: "Bán công"
    }, {
        id: 5,
        name: "Dân lập"
    }, ],
    // Loại hình trường
    list_loai_hinh_truong: [{
            id: 1,
            name: "Bình thường"
        },
        {
            id: 2,
            name: "Dân tộc nội trú"
        },
        {
            id: 3,
            name: "Khuyết tật"
        },
        {
            id: 4,
            name: "Năng khiếu khuyết tật"
        },
        {
            id: 5,
            name: "Năng khiếu TDTT"
        },
        {
            id: 6,
            name: "Trường chuyên"
        },
        {
            id: 7,
            name: "Dân tộc bán trú"
        },
        {
            id: 8,
            name: "Trường THPT kỹ thuật"
        },
        {
            id: 9,
            name: "Trẻ em thiệt thòi"
        },
        {
            id: 10,
            name: "Chưa rõ"
        },
    ],
    LIST_CAP_HOC_KHONG_LIEN: [{
        id: 1,
        name: "Cấp 1"
    }, {
        id: 2,
        name: "Cấp 2"
    }, {
        id: 3,
        name: "Cấp 3"
    }, {
        id: 4,
        name: "Nhà trẻ"
    }, {
        id: 5,
        name: "Mẫu giáo"
    }],
    // Danh sách loại dữ liệu trong báo cáo tình hình nộp dữ liệu
    list_loai_du_lieu_bao_cao_tinh_hinh_nop_du_lieu: [{
            id: -1,
            name: "Tất cả"
        },
        {
            id: 2,
            name: "Cán bộ"
        },
        {
            id: 3,
            name: "Lớp học"
        },
        {
            id: 4,
            name: "Học sinh"
        },
        {
            id: 5,
            name: "Kết quả học tập"
        },
        // {id:6,name:"Khen thưởng"},
        // {id:7,name:"Hoàn thành chương trình mầm non"},
        // {id:8,name:"Xét tốt nghiệp"},
        // {id:9,name:"Nhập điểm thi lại"},
        // {id:10,name:"Thí sinh tự do"},
        // {id:11,name:"EQMS đầu năm"},
        // {id:12,name:"EQMS giữa năm"},
        // {id:13,name:"EQMS cuối năm"},
        {
            id: 14,
            name: "Phòng học"
        },
        // {id:15,name:"Ngân sách"},
        {
            id: 16,
            name: "Đề án ngoại ngữ"
        },
        // {id:-1,name:"Không xác định"},
    ],
    // Danh sách trạng thái học sinh
    list_trang_thai_hoc_sinh: [{
        id: 1,
        name: "Đang học"
    }, {
        id: 3,
        name: "Chuyển khỏi trường"
    }, {
        id: 4,
        name: "Bỏ học"
    }, ],
    list_khoi_hoc: [{
            name: "Khối 1",
            value: 1
        },
        {
            name: "Khối 2",
            value: 2
        },
        {
            name: "Khối 3",
            value: 3
        },
        {
            name: "Khối 4",
            value: 4
        },
        {
            name: "Khối 5",
            value: 5
        },
        {
            name: "Khối 6",
            value: 6
        },
        {
            name: "Khối 7",
            value: 7
        },
        {
            name: "Khối 8",
            value: 8
        },
        {
            name: "Khối 9",
            value: 9
        },
        {
            name: "Khối 10",
            value: 10
        },
        {
            name: "Khối 11",
            value: 11
        },
        {
            name: "Khối 12",
            value: 12
        },
        {
            name: "Nhóm trẻ",
            value: 13
        },
        {
            name: "Nhóm trẻ",
            value: 14
        },
        {
            name: "Nhóm trẻ",
            value: 15
        },
        {
            name: "Lớp mẫu giáo",
            value: 16
        },
        {
            name: "Lớp mẫu giáo",
            value: 17
        },
        {
            name: "Lớp mẫu giáo",
            value: 18
        },
    ],
    // Danh sách chức vụ cán bộ trong tra cứu giáo viên
    list_chuc_vu_can_bo: [{
            id: 1,
            name: "Hiệu trưởng"
        },
        {
            id: 2,
            name: "Phó hiệu trưởng"
        },
        {
            id: 8,
            name: "Tổ trưởng chuyên môn"
        },
        {
            id: 19,
            name: "Tổ phó chuyên môn"
        },
        {
            id: 16,
            name: "Giám đốc"
        },
        {
            id: 17,
            name: "Phó giám đốc"
        },
        {
            id: 14,
            name: "Nhân viên thư viện"
        },
        {
            id: 15,
            name: "Nhân viên thiết bị"
        },
        {
            id: 3,
            name: "Nhân viên y tế"
        },
        {
            id: 24,
            name: "Giáo viên"
        },
        {
            id: 25,
            name: "Giáo viên mầm non"
        },
        {
            id: 26,
            name: "Giáo viên thính giảng"
        },
        {
            id: 27,
            name: "Hội đồng quản trị"
        },
        {
            id: 6,
            name: "Nhân viên khác"
        },
        {
            id: 4,
            name: "Nhân viên thí nghiệm"
        },
        {
            id: 5,
            name: "Nhân viên kỹ thuật nghiệp vụ"
        },
        {
            id: 10,
            name: "Nhân viên kế toán"
        },
        {
            id: 11,
            name: "Nhân viên văn thư"
        },
        {
            id: 7,
            name: "Bảo vệ"
        },
        {
            id: 18,
            name: "Trợ giảng ngôn ngữ L1"
        },
        {
            id: 19,
            name: "Trợ giảng ngôn ngữ L2"
        },
        {
            id: 12,
            name: "Nhân viên cấp dưỡng"
        },
        {
            id: 13,
            name: "Nhân viên bảo mẫu"
        },
        {
            id: 20,
            name: "Nhân viên thủ quỹ"
        },
        {
            id: 21,
            name: "Nhân viên công nghệ thông tin"
        },
        {
            id: 22,
            name: "Nhân viên hỗ trợ GĐ khuyết tật"
        },
        {
            id: 23,
            name: "Nhân viên giáo vụ"
        },
    ],
    LIST_CAP_HOC_CO_GDTX: [{
        id: 1,
        name: "Cấp 1"
    }, {
        id: 2,
        name: "Cấp 2"
    }, {
        id: 3,
        name: "Cấp 3"
    }, {
        id: 4,
        name: "Nhà trẻ"
    }, {
        id: 5,
        name: "Mẫu giáo"
    }, {
        id: 6,
        name: "GDTX"
    }],
    khoiCapMot: [{
        id: 1,
        name: "Khối 1"
    }, {
        id: 2,
        name: "Khối 2"
    }, {
        id: 3,
        name: "Khối 3"
    }, {
        id: 4,
        name: "Khối 4"
    }, {
        id: 5,
        name: "Khối 5"
    }],
    khoiCapHai: [{
        id: 6,
        name: "Khối 6"
    }, {
        id: 7,
        name: "Khối 7"
    }, {
        id: 8,
        name: "Khối 8"
    }, {
        id: 9,
        name: "Khối 9"
    }],
    khoiCapBa: [{
        id: 10,
        name: "Khối 10"
    }, {
        id: 11,
        name: "Khối 11"
    }, {
        id: 12,
        name: "Khối 12"
    }],

    khoiHocNhaTre: [{
            id: 13,
            name: "Trẻ từ 3-12 tháng"
        },
        {
            id: 14,
            name: "Trẻ từ 13-24 tháng"
        },
        {
            id: 15,
            name: "Trẻ từ 25-36 tháng"
        },
    ],
    khoiHocMauGiao: [{
            id: 16,
            name: "Trẻ từ 3-4 tuổi"
        },
        {
            id: 17,
            name: "Trẻ từ 4-5 tuổi"
        },
        {
            id: 18,
            name: "Trẻ từ 5-6 tuổi"
        },
    ],

    khoiNhaTre: [{
        id: 13,
        name: "Nhà trẻ"
    }, ],
    lopNhaTre: [{
            value: '01',
            name: "3-12 tháng"
        },
        {
            value: '02',
            name: "13-24 tháng"
        },
        {
            value: '03',
            name: "25-36 tháng"
        },
    ],
    lopMauGiao: [{
            value: '04',
            name: "3-4 tuổi"
        },
        {
            value: '05',
            name: "4-5 tuổi"
        },
        {
            value: '06',
            name: "5-6 tuổi"
        },
    ],
    khoiMamNon: [{
        id: 16,
        name: "Mẫu giáo"
    }],
    khoi_mam_non_hai_cap: [

        {
            id: 13,
            name: "Nhà trẻ"
        },
        {
            id: 16,
            name: "Mẫu giáo"
        },
    ],
    // danh sách loại đồng bộ trong kết chuyển dữ liệu (yêu cầu dữ liệu theo trường
    // cũ)
    ds_loai_dong_bo_ket_chuyen_du_lieu: [{
        id: 1,
        name: "Đẩy dữ liệu đầu năm"
    }, {
        id: 2,
        name: "Đẩy dữ liệu điểm"
    }],
    // danh sách loại đồng bộ trong kết chuyển dữ liệu (yêu cầu dữ liệu theo trường
    // cũ)
    ds_trang_thai_ket_chuyen_du_lieu: [{
        id: 0,
        name: "Tất cả"
    }, {
        id: -1,
        name: "Dữ liệu lỗi"
    }, {
        id: 1,
        name: "Mới tạo"
    }, {
        id: 2,
        name: "Đang xử lý"
    }, {
        id: 3,
        name: "Đang đồng bộ"
    }, {
        id: 5,
        name: "Trường hoàn thành"
    }, {
        id: 6,
        name: "Phòng đã duyệt"
    }, {
        id: 7,
        name: "Sở đã duyệt"
    }],
    // Danh sách yêu cầu đẩy dữ liệu lên bộ
    danh_sach_loai_yeu_cau_ddllb: [{
            id: "",
            name: "Chọn"
        },
        {
            id: 1,
            name: "Trường học"
        },
        {
            id: 2,
            name: "Giáo viên"
        },
        {
            id: 3,
            name: "Lóp học"
        },
        {
            id: 4,
            name: "Học sinh"
        },
        {
            id: 5,
            name: "Kết quả học tập"
        },
        {
            id: 6,
            name: "BC EQMS"
        },
        {
            id: 7,
            name: "Hoàn thành chương trình mầm non"
        },
        {
            id: 8,
            name: "Xét tốt nghiệp"
        },
        {
            id: 9,
            name: "Nhập điểm thi lại"
        },
        {
            id: 10,
            name: "Thí sinh tự do"
        },
        {
            id: 11,
            name: "EQMS đầu năm"
        },
        {
            id: 12,
            name: "EQMS giữa năm"
        },
        {
            id: 13,
            name: "EQMS cuối năm"
        },
        {
            id: 14,
            name: "ĐG chuẩn nghề nghiệp"
        },
    ],
    // Danh sách trạng thái đẩy dữ liệu lên bộ
    danh_sach_trang_thai_ddllb: [{
        id: 1,
        name: "Dữ liệu trường"
    }, {
        id: 2,
        name: "Dữ liệu giáo viên"
    }, {
        id: 3,
        name: "Dữ liệu lớp học"
    }, {
        id: 4,
        name: "Dữ liệu học sinh"
    }, {
        id: 5,
        name: "Dữ liệu kết quả học tập"
    }, {
        id: 6,
        name: "Dữ liệu EQMS"
    }],
    list_dong_bo_du_lieu_hk1: [{
            "name": "Trường học",
            "key": "1"
        },
        {
            "name": "Cán bộ",
            "key": "2"
        }, {
            "name": "Học sinh",
            "key": "4"
        }, {
            "name": "Lớp học",
            "key": "3"
        }, {
            "name": "KQ học tập giữa kỳ",
            "key": "51"
        }, {
            "name": "KQ học tập cuối kỳ",
            "key": "52"
        }, {
            "name": "ĐG chuẩn nghề nghiệp",
            "key": "14"
        }
    ],

    list_dong_bo_du_lieu_hk2: [
        {
            "name": "KQ học tập giữa kỳ",
            "key": "51"
        },
        {
            "name": "KQ học tập cuối kỳ",
            "key": "52"
        }, {
            "name": "Hoàn thành chương trình mầm non",
            "key": "7"
        }
    ],

    list_dong_bo_du_lieu_cn: [ {
        "name": "Nhập điểm thi lại",
        "key": "9"
    }, {
        "name": "KQ học tập cả năm",
        "key": "52"
    }, {
        "name": "Xét tốt nghiệp",
        "key": "8"
    }],

    list_dong_bo_du_lieu_full: [{
            "name": "Trường học",
            "key": "1"
        },
        {
            "name": "Cán bộ",
            "key": "2"
        }, {
            "name": "Học sinh",
            "key": "4"
        }, {
            "name": "Lớp học",
            "key": "3"
        }, {
            "name": "KQ học tập giữa kỳ",
            "key": "51"
        }, {
            "name": "KQ học tập cuối kỳ",
            "key": "52"
        }, {
            "name": "ĐG chuẩn nghề nghiệp",
            "key": "14"
        }, {
            "name": "Hoàn thành chương trình mầm non",
            "key": "7"
        }, {
            "name": "Nhập điểm thi lại",
            "key": "9"
        },
    ],
    list_dong_bo_du_lieu_day_len_bo_full: [{
            "name": "Trường học",
            "key": "1"
        },
        {
            "name": "Cán bộ",
            "key": "2"
        },
        {
            "name": "Lớp học",
            "key": "3"
        },
        {
            "name": "Học sinh",
            "key": "4"
        },
        {
            "name": "KQ học tập",
            "key": "5"
        },
        // {"name": "Khen thưởng","key": "6"},
        {
            "name": "Hoàn thành chương trình mầm non",
            "key": "7"
        },
        {"name": "Xét tốt nghiệp","key": "8"},
        {
            "name": "Nhập điểm thi lại",
            "key": "9"
        },
        // {"name": "Thí sinh tự do","key": "10"},
        // {"name": "EQMS đầu năm","key": "11"},
        // {"name": "EQMS giữa năm","key": "12"},
        // {"name": "EQMS cuối năm","key": "13"},
        {
            "name": "ĐG chuẩn nghề nghiệp",
            "key": "14"
        },
    ],

    // Hàm tiện ích để tạo danh sách năm học động
    generateYearList: function(startOffset = 8, endOffset = 2) {
        const currentYear = new Date().getFullYear();
        const years = [];
        for (let i = currentYear - startOffset; i <= currentYear + endOffset; i++) {
            years.push({
                id: i,
                name: `${i}-${i + 1}`
            });
        }
        return years;
    },

    // Hàm tạo danh sách năm học từ năm bắt đầu đến năm kết thúc
    generateYearRange: function(startYear, endYear) {
        const years = [];
        for (let i = startYear; i <= endYear; i++) {
            years.push({
                id: i,
                name: `${i}-${i + 1}`
            });
        }
        return years;
    },

    // Hàm lấy năm học hiện tại
    getCurrentSchoolYear: function() {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth() + 1; // Tháng từ 0-11
        
        // Nếu đang trong tháng 8-12, năm học hiện tại là năm đó
        // Nếu đang trong tháng 1-7, năm học hiện tại là năm trước
        if (currentMonth >= 8) {
            return currentYear;
        } else {
            return currentYear - 1;
        }
    },

    // Hàm tạo danh sách năm học từ năm hiện tại
    generateCurrentYearList: function(backwardYears = 8, forwardYears = 2) {
        const currentSchoolYear = this.getCurrentSchoolYear();
        const years = [];
        for (let i = currentSchoolYear - backwardYears; i <= currentSchoolYear + forwardYears; i++) {
            years.push({
                id: i,
                name: `${i}-${i + 1}`
            });
        }
        return years;
    }

}
