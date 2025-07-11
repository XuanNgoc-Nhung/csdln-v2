export default {

    CAP_HOC_CAP_1: 1,
    CAP_HOC_CAP_2: 2,
    CAP_HOC_CAP_3: 3,
    CAP_HOC_CAP_MAU_GIAO: 4,
    CAP_HOC_CAP_NHA_TRE: 5,

    listCapHoc() {
        let arr = [];
        arr.push({value: this.CAP_HOC_CAP_1, name: "Tiểu học"});
        arr.push({value: this.CAP_HOC_CAP_2, name: "THCS"});
        arr.push({value: this.CAP_HOC_CAP_3, name: "THPT"});
        arr.push({value: this.CAP_HOC_CAP_MAU_GIAO, name: "Mẫu giáo"});
        arr.push({value: this.CAP_HOC_CAP_NHA_TRE, name: "Nhà trẻ"});
        return arr;
    },

    LOAI_DONVI_PHONG: 2,
    LOAI_DONVI_SO: 1,

    LIST_YEARS: [
        {value: 2015, name: "2015-2016"},
        {value: 2016, name: "2016-2017"},
        {value: 2017, name: "2017-2018"},
        {value: 2018, name: "2018-2019"},
        {value: 2019, name: "2019-2020"},
        {value: 2020, name: "2020-2021"},
        {value: 2021, name: "2021-2022"},
        {value: 2022, name: "2022-2023"},
        {value: 2023, name: "2023-2024"},
        {value: 2024, name: "2024-2025"},
    ],
    LIST_CAP_HOC: [
        {value: 1, name: "Cấp 1"},
        {value: 2, name: "Cấp 2"},
        {value: 3, name: "Cấp 3"},
        {value: 4, name: "Nhà trẻ"},
        {value: 5, name: "Mẫu giáo"},
        {value: 45, name: "Trường liên nhà trẻ + mẫu giáo"},
        {value: 12, name: "Trường liên cấp 1+2"},
        {value: 23, name: "Trường liên cấp 2+3"},
        {value: 123, name: "Trường liên cấp 1+2+3"},
        {value: 12345, name: "Trường liên cấp tất cả"},
    ],
    TRANG_THAI_HS: [
        {value: 1, name: "Đang theo học"},
        {value: 2, name: "Chuyển đến kỳ 1"},
        {value: 3, name: "Chuyển đi kỳ 1"},
        {value: 4, name: "Thôi học kỳ 1"},
        {value: 5, name: "Nghỉ học xin học lại kỳ 1"},
        {value: 6, name: "Chuyển đến kỳ 2"},
        {value: 7, name: "Nghỉ học xin học lại kỳ 2"},
        {value: 8, name: "Chuyển đi kỳ 2"},
        {value: 9, name: "Thôi học kỳ 2"},
        {value: 10, name: "Chuyển đến trong hè"},
        {value: 11, name: "Chuyển đi trong hè"},
        {value: 12, name: "Thôi học trong hè"},
    ],
    GIOI_TINH: [
        {value: '1', name: "Nam"},
        {value: '0', name: "Nữ"},
    ],
    LOAI_HINH_TRUONG: [
        {value: 1, name: "Công lập"},
        {value: 2, name: "Tư thục"},
        {value: 3, name: "GDTX"},
        {value: 4, name: "Bán công"},
        {value: 5, name: "Dân lập"},
    ],
    KHU_VUC: [
        {value: "01", name: "Biên giới - hải đảo"},
        {value: "02", name: "Đô thị"},
        {value: "03", name: "Đồng bằng"},
        {value: "04", name: "Miền núi - vùng sâu"},
    ],
    LIST_CAP_HOC_KHONG_LIEN: [
        {value: 1, name: "Cấp 1"},
        {value: 2, name: "Cấp 2"},
        {value: 3, name: "Cấp 3"},
        {value: 4, name: "Nhà trẻ"},
        {value: 5, name: "Mẫu giáo"},
    ],
    KHOI_HOC:[
        {value: 1, name: "Khối 1"},
        {value: 2, name: "Khối 2"},
        {value: 3, name: "Khối 3"},
        {value: 4, name: "Khối 4"},
        {value: 5, name: "Khối 5"},
        {value: 6, name: "Khối 6"},
        {value: 7, name: "Khối 7"},
        {value: 8, name: "Khối 8"},
        {value: 9, name: "Khối 9"},
        {value: 10, name: "Khối 10"},
        {value: 11, name: "Khối 11"},
        {value: 12, name: "Khối 12"},
        {value: 13, name: "Trẻ từ 3-12 tháng"},
        {value: 14, name: "Trẻ từ 13-24 tháng"},
        {value: 15, name: "Trẻ từ 25-36 tháng"},
        {value: 16, name: "Trẻ từ 3-4 tuổi"},
        {value: 17, name: "Trẻ từ 4-5 tuổi"},
        {value: 18, name: "Trẻ từ 5-6 tuổi"},
    ],

    KHUYET_TAT : [
        {value: "01", name: "Khuyết tật vận động"},
        {value: "02", name: "Khuyết tật nghe nói"},
        {value: "03", name: "Khuyết tật nhìn"},
        {value: "04", name: "Khuyết tật thần kinh tâm thần"},
        {value: "05", name: " Khuyết tật trí tuệ"},
        {value: "06", name: " Khuyết tật khác"},
    ],
    LY_DO_THOI_HOC : [
        {value: "01", name: "Có hoàn cảnh kinh tế gia đình khó khăn"},
        {value: "02", name: "Học lực yếu kém"},
        {value: "03", name: "Xa trường, đi lại khó khăn"},
        {value: "04", name: "Ảnh hưởng thiên tai, dịch bệnh"},
        {value: "05", name: "Do kỳ thị"},
        {value: "07", name: "Bảo lưu kết quả"},
        {value: "08", name: "Chuyển sang học nghề"},
        {value: "06", name: "Nguyên nhân khác"},
    ],
    LOAI_NHAP_HOC : [
        {value: 1, name: "Chuyển từ trường khác"},
        {value: 3, name: "Trúng tuyển"},
    ],
    khoiCapMot: [
        {value: 1, name: "Khối 1"},
        {value: 2, name: "Khối 2"},
        {value: 3, name: "Khối 3"},
        {value: 4, name: "Khối 4"},
        {value: 5, name: "Khối 5"},
    ],
    khoiCapHai: [
        {value: 6, name: "Khối 6"},
        {value: 7, name: "Khối 7"},
        {value: 8, name: "Khối 8"},
        {value: 9, name: "Khối 9"},
    ],
    khoiCapBa: [
        {value: 10, name: "Khối 10"},
        {value: 11, name: "Khối 11"},
        {value: 12, name: "Khối 12"},
    ],
    khoiNhaTre: [
        {value: 13, name: "Trẻ từ 3-12 tháng"},
        {value: 14, name: "Trẻ từ 13-24 tháng"},
        {value: 15, name: "Trẻ từ 25-36 tháng"},
    ],
    khoiMamNon: [
        {value: 16, name: "Trẻ từ 3-4 tuổi"},
        {value: 17, name: "Trẻ từ 4-5 tuổi"},
        {value: 18, name: "Trẻ từ 5-6 tuổi"},
    ],
    SYNC_TYPE: [
        {value: 1, name: "Đầu năm"},
        {value: 2, name: "Phát sinh"},
        {value: 3, name: "Cuối năm"},
        {value: 4, name: "Đẩy dữ liệu học sinh năm cũ"},
        {value: 5, name: "Đẩy dữ liệu tức thời"}
    ]

}
