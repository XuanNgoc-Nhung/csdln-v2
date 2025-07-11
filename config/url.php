<?php
if (!defined("BASE_URL_API")) {
    define("BASE_URL_API", env("BASE_URL_API"));
}
if (!defined("BASE_URL_DOWNLOAD")) {
    define("BASE_URL_DOWNLOAD", env("BASE_URL_DOWNLOAD"));
}

if (!defined("WEBSOCKET_URI")) {
    define("WEBSOCKET_URI", env("WEBSOCKET_URI"));
}
/**
 * Created by PhpStorm.
 * User: The
 * Date: 2/25/2019
 * Time: 12:111114170 1112P012M12
1 1*/
return [
    //Báo cáo động
    "api_xuat_excel_bao_cao_dong_can_bo" => BASE_URL_API . "/csdlgd-report-fetch/BaoCaoDongExcel/exportGiaoVien",
    "api_xuat_excel_bao_cao_dong_hoc_sinh" => BASE_URL_API . "/csdlgd-report-fetch/BaoCaoDongExcel/exportHocSinh",
    "api_xuat_excel_bao_cao_dong_truong_hoc" => BASE_URL_API . "/csdlgd-report-fetch/BaoCaoDongExcel/exportTruongHoc",
    "api_load_template_bao_cao" => BASE_URL_API . "/csdlgd-report-fetch/template/search",
    "api_dowload_truong_da_nop_bao_cao_theo_bieu_mau" => BASE_URL_API . "/csdlgd-admin/nop-bieu-mau/download-truong",
    "api_dowload_excel_bao_cao_tinh_hinh_nop_du_lieu" => BASE_URL_API . "/csdlgd-report-api/bao-cao-tinh-hinh-nop-du-lieu/excel",
    "api_dowload_excel_list_school" => BASE_URL_API . "/internal-api/dmTruongHoc/dowloadExcel",
    "api_lay_template_import_kqht" => BASE_URL_API . "/csdlgd-report-api/excel-form/kqht",
    //Quản lý danh mục
    "api_lay_danh_sach_dan_toc" => BASE_URL_API . "/internal-api/dmDanToc/filter",
    "api_them_danh_sach_dan_toc" => BASE_URL_API . "/internal-api/dmDanToc/create",
    "api_chinh_sua_danh_sach_dan_toc" => BASE_URL_API . "/internal-api/dmDanToc/update",
    "api_xoa_danh_sach_dan_toc" => BASE_URL_API . "/internal-api/dmDanToc/delete",

    "api_lay_danh_sach_ton_giao" => BASE_URL_API . "/internal-api/dmTonGiao/filter",
    "api_them_danh_sach_ton_giao" => BASE_URL_API . "/internal-api/dmTonGiao/create",
    "api_chinh_sua_danh_sach_ton_giao" => BASE_URL_API . "/internal-api/dmTonGiao/update",
    "api_xoa_danh_sach_ton_giao" => BASE_URL_API . "/internal-api/dmTonGiao/delete",

    "api_lay_danh_sach_tinh_thanh" => BASE_URL_API . "/internal-api/dmTinhThanh/filter",
    "api_them_danh_sach_tinh_thanh" => BASE_URL_API . "/internal-api/dmTinhThanh/create",
    "api_chinh_sua_danh_sach_tinh_thanh" => BASE_URL_API . "/internal-api/dmTinhThanh/update",
    "api_xoa_danh_sach_tinh_thanh" => BASE_URL_API . "/internal-api/dmTinhThanh/delete",

    "api_lay_danh_sach_quan_huyen" => BASE_URL_API . "/internal-api/dmQuanHuyen/filter",
    "api_them_danh_sach_quan_huyen" => BASE_URL_API . "/internal-api/dmQuanHuyen/create",
    "api_chinh_sua_quan_huyen" => BASE_URL_API . "/internal-api/dmQuanHuyen/update",
    "api_xoa_danh_sach_quan_huyen" => BASE_URL_API . "/internal-api/dmQuanHuyen/delete",

    "api_lay_danh_sach_phuong_xa" => BASE_URL_API . "/internal-api/dmPhuongXa/filter",
    "api_them_danh_sach_phuong_xa" => BASE_URL_API . "/internal-api/dmPhuongXa/create",
    "api_chinh_sua_danh_tinh_phuong_xa" => BASE_URL_API . "/internal-api/dmPhuongXa/update",
    "api_xoa_danh_sach_phuong_xa" => BASE_URL_API . "/internal-api/dmPhuongXa/delete",

    "api_lay_danh_sach_to_thon" => BASE_URL_API . "/internal-api/dmToThon/filter",
    "api_them_danh_sach_to_thon" => BASE_URL_API . "/internal-api/dmToThon/create",
    "api_chinh_sua_danh_sach_to_thon" => BASE_URL_API . "/internal-api/dmToThon/update",
    "api_xoa_danh_sach_to_thon" => BASE_URL_API . "/internal-api/dmToThon/delete",

    "api_lay_danh_sach_chuyen_nganh_dao_tao" => BASE_URL_API . "/internal-api/dmCNganhDTao/filter",
    "api_them_danh_sach_chuyen_nganh_dao_tao" => BASE_URL_API . "/internal-api/dmCNganhDTao/create",
    "api_chinh_sua_danh_sach_chuyen_nganh_dao_tao" => BASE_URL_API . "/internal-api/dmCNganhDTao/update",
    "api_xoa_danh_sach_chuyen_nganh_dao_tao" => BASE_URL_API . "/internal-api/dmCNganhDTao/delete",

    "api_lay_danh_sach_ly_do_bo_hoc" => BASE_URL_API . "/internal-api/dmLyDoBoHoc/filter",
    "api_them_danh_sach_ly_do_bo_hoc" => BASE_URL_API . "/internal-api/dmLyDoBoHoc/create",
    "api_chinh_sua_danh_sach_ly_do_bo_hoc" => BASE_URL_API . "/internal-api/dmLyDoBoHoc/update",
    "api_xoa_danh_sach_ly_do_bo_hoc" => BASE_URL_API . "/internal-api/dmLyDoBoHoc/delete",

    "api_lay_danh_sach_doi_tuong_chinh_sach" => BASE_URL_API . "/internal-api/dmDTuongCSach/filter",
    "api_them_danh_sach_doi_tuong_chinh_sach" => BASE_URL_API . "/internal-api/dmDTuongCSach/create",
    "api_chinh_sua_danh_sach_doi_tuong_chinh_sach" => BASE_URL_API . "/internal-api/dmDTuongCSach/update",
    "api_xoa_danh_sach_doi_tuong_chinh_sach" => BASE_URL_API . "/internal-api/dmDTuongCSach/delete",

    "api_lay_danh_sach_mon_hoc" => BASE_URL_API . "/internal-api/dmMonHoc/filter",
    "api_them_danh_sach_mon_hoc" => BASE_URL_API . "/internal-api/dmMonHoc/create",
    "api_chinh_sua_danh_sach_mon_hoc" => BASE_URL_API . "/internal-api/dmMonHoc/update",
    "api_xoa_danh_sach_mon_hoc" => BASE_URL_API . "/internal-api/dmMonHoc/delete",

    "api_lay_danh_sach_loai_doi_tuong" => BASE_URL_API . "/internal-api/dmLoaiDoiTuong/filter",
    "api_them_danh_sach_loai_doi_tuong" => BASE_URL_API . "/internal-api/dmLoaiDoiTuong/create",
    "api_chinh_sua_danh_sach_loai_doi_tuong" => BASE_URL_API . "/internal-api/dmLoaiDoiTuong/update",
    "api_xoa_danh_sach_loai_doi_tuong" => BASE_URL_API . "/internal-api/dmLoaiDoiTuong/delete",

    "api_lay_danh_sach_linh_vuc_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmLinhVucDanhGiaSuPT/filter",
    "api_them_danh_sach_linh_vuc_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmLinhVucDanhGiaSuPT/create",
    "api_chinh_sua_danh_sach_linh_vuc_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmLinhVucDanhGiaSuPT/update",
    "api_xoa_danh_sach_linh_vuc_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmLinhVucDanhGiaSuPT/delete",

    "api_lay_danh_sach_chi_so_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmChiSoDanhGiaSuPT/filter",
    "api_them_danh_sach_chi_so_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmChiSoDanhGiaSuPT/create",
    "api_chinh_sua_danh_sach_chi_so_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmChiSoDanhGiaSuPT/update",
    "api_xoa_danh_sach_chi_so_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmChiSoDanhGiaSuPT/delete",

    "api_lay_danh_sach_chuan_chieu_cao_can_nang" => BASE_URL_API . "/internal-api/dmChuanChieuCaoCanNang/filter",
    "api_them_danh_sach_chuan_chieu_cao_can_nang" => BASE_URL_API . "/internal-api/dmChuanChieuCaoCanNang/create",
    "api_chinh_sua_danh_sach_chuan_chieu_cao_can_nang" => BASE_URL_API . "/internal-api/dmChuanChieuCaoCanNang/update",
    "api_xoa_danh_sach_chuan_chieu_cao_can_nang" => BASE_URL_API . "/internal-api/dmChuanChieuCaoCanNang/delete",

    "api_lay_danh_sach_don_vi" => BASE_URL_API . "/internal-api/dmDonVi/filter",
    "api_them_danh_sach_don_vi" => BASE_URL_API . "/internal-api/dmDonVi/create",
    "api_chinh_sua_danh_sach_don_vi" => BASE_URL_API . "/internal-api/dmDonVi/update",
    "api_xoa_danh_sach_don_vi" => BASE_URL_API . "/internal-api/dmDonVi/delete",

    "api_lay_danh_sach_truong_hoc" => BASE_URL_API . "/internal-api/dmTruongHoc/filter",
    "api_them_danh_sach_truong_hoc" => BASE_URL_API . "/internal-api/dmTruongHoc/create",
    "api_chinh_sua_danh_sach_truong_hoc" => BASE_URL_API . "/internal-api/dmTruongHoc/update",
    "api_xoa_danh_sach_truong_hoc" => BASE_URL_API . "/internal-api/dmTruongHoc/delete",

    // cán bộ phòng sở
    "api_xoa_can_bo_phong_so"=>BASE_URL_API . "/csdlgd-admin/canBoPhongSoQl/delete",


//    Đơn vị

    "api_lay_don_vi" => BASE_URL_API . "/internal-api/dmDonVi/filter",
    "api_them_don_vi" => BASE_URL_API . "/internal-api/dmDonVi/create/",
    "api_chinh_sua_don_vi" => BASE_URL_API . "/internal-api/dmDonVi/update/",
    "api_chinh_sua_truong_hoc" => BASE_URL_API . "/internal-api/dmTruongHoc/update/",

// Học sinh

    "api_lay_danh_sach_hoc_sinh" => BASE_URL_API . "/csdlgd-admin/hocSinh/search",
    "api_lay_danh_sach_giao_vien" => BASE_URL_API . "/csdlgd-admin/giaoVien/search",
    "api_lay_thong_tin_giao_vien" => BASE_URL_API . "/csdlgd-admin/giaoVien/",
    "api_lay_danh_sach_dong_bo" => BASE_URL_API . "/csdlgd-admin/yeuCauDongBo/list",
    "api_lay_thong_tin_dong_bo" => BASE_URL_API . "/csdlgd-admin/yeuCauDongBo/",
    "api_lay_danh_sach_yeu_cau_du_lieu_cu" => BASE_URL_API . "/csdlgd-admin/yeuCauDuLieuCu/search",

    // Api đăng nhập
    "api_dang_nhap" => BASE_URL_API . "/csdlgd-user/auth/login",
    "api_dang_nhap_voi_token" => BASE_URL_API . "/csdlgd-user/auth/loginToken",
    "api_dang_nhap_voi_token_smas" => BASE_URL_API . "/csdlgd-user/auth/login-smas",
    "api_logout" => BASE_URL_API . "/csdlgd-user/auth/logout",
    "api_get_hash_sso" => BASE_URL_API . "/csdlgd-user/adminUser/getSSOHash",

//Hệ thống

    "lay_danh_sach_nguoi_dung" => BASE_URL_API . "/csdlgd-user/adminUser/search",
    "api_them_nguoi_dung" => BASE_URL_API . "/csdlgd-user/adminUser",
    "api_chinh_sua_nguoi_dung" => BASE_URL_API . "/csdlgd-user/adminUser",
    "api_change_pass_nguoi_dung" => BASE_URL_API . "/csdlgd-user/adminUser/password",
    "api_thay_doi_trang_thai_nguoi_dung" => BASE_URL_API . "/csdlgd-user/adminUser/trangThai",
    "api_doi_mat_khau_ban_than" => BASE_URL_API . "/csdlgd-user/adminUser/changeSelfPassword",
    "api_lay_captcha" => BASE_URL_API. "/csdlgd-user/auth/getCaptcha",

//    cấu hình email
    "api_chinh_sua_cau_hinh_email" => BASE_URL_API . "/internal-api/cauHinhEmail/update/",
    "api_dowload_excel" => BASE_URL_API . "/csdlgd-report-api/download-excel",
    // "api_dowload_excel_kcdl" => BASE_URL_API . "/csdlgd-admin/ExportExcel/DanhSachTruong",
    "api_dowload_excel_kcdl" => BASE_URL_API . "/csdlgd-admin/ketChuyenDuLieu/excel",
    "api_dowload_template_mk_ket_chuyen" => BASE_URL_DOWNLOAD . "/csdlgd-push/KetChuyenDL/dowloadTemplate",
    // "api_dowload_excel_list_student" => BASE_URL_API . "/csdlgd-admin/ExportExcel/SreachHocSinh",
    "api_dowload_excel_list_student" => BASE_URL_API . "/csdlgd-admin/ExportExcel/HocSinh",
    "api_dowload_excel_truong_nop_bao_cao_theo_bieu_mau" => BASE_URL_API . "/csdlgd-admin/nop-bieu-mau/export-excel",
    "api_dowload_excel_list_class" => BASE_URL_API . "/csdlgd-admin/ExportExcel/SreachLopHoc2",
    "api_dowload_excel_list_kqht" => BASE_URL_API . "/csdlgd-admin/ExportExcel/exportTraCuuKQHTHocSinh",
    // "api_dowload_excel_list_teacher" => BASE_URL_API . "/csdlgd-admin/ExportExcel/SreachGiaoVien",
    "api_dowload_excel_list_teacher" => BASE_URL_API . "/csdlgd-admin/ExportExcel/GiaoVien",
    "api_dowload_excel_ban_ghi_loi_kcdl" => BASE_URL_API . "/csdlgd-push/Export/detailErr",
    "api_dowload_excel_du_lieu_sso" => BASE_URL_API . "/csdlgd-admin/ExportExcelSSo/DanhSach",
    "api_dowload_excel_du_lieu_diem_danh" => BASE_URL_API . "/csdlgd-report-api/bc-diem-danh/bao-cao",
    // "api_dowload_excel_lich_su_day_du_lieu_len_bo" => BASE_URL_API . "/csdlgd-push/Export/danhSachTruongDDL",
    "api_dowload_excel_lich_su_day_du_lieu_len_bo" => BASE_URL_API . "/csdlgd-push/Export/dayDuLieuLenBo",
    "api_dowload_excel_list_can_bo_phong_so" => BASE_URL_API . "/csdlgd-admin/canBoPhongSoQl/excel",
    "api_dowload_pdf" => BASE_URL_API . "/csdlgd-report-api/download-pdf",
    "api_dowload_pdf_thong_tin_hoc_sinh" => BASE_URL_API . "/csdlgd-admin/ExportPdf/hoSoHocSinh",
    "api_dowload_pdf_thong_tin_can_bo" => BASE_URL_API . "/csdlgd-admin/ExportPdf/hoSoCanBo",
    "api_tong_hop_bao_cao_theo_bieu_mau" => BASE_URL_API . "/csdlgd-admin/nop-bieu-mau/tongHop-download",
    "api_import_buoc_mot_du_lieu_moet" => BASE_URL_API . "/csdlgd-data-import/import-task/upload-import-file",
    "api_import_bao_cao_dong" => BASE_URL_API . "/csdlgd-analytic-api/BcChiTiet/uploadBcChiTiet",



//    đối tác
    "api_them_doi_tac" => BASE_URL_API . "/internal-api/heThongDoiTac/create/",
    "api_chinh_sua_doi_tac" => BASE_URL_API . "/internal-api/heThongDoiTac/update/",
    "api_xoa_doi_tac" => BASE_URL_API . "/internal-api/heThongDoiTac/delete/",


//
    "api_them_yeu_cau_du_lieu_theo_truong" => BASE_URL_API . "/csdlgd-admin/yeuCauDuLieuTruong",
    "api_them_yeu_cau_xoa_du_lieu_theo_truong" => BASE_URL_API . "/csdlgd-admin/yeuCauDuLieuTruong/clear-data",
    "api_them_yeu_cau_du_lieu_cu" => BASE_URL_API . "/csdlgd-admin/yeuCauDuLieuCu",
    "api_sua_yeu_cau_du_lieu_cu" => BASE_URL_API . "/csdlgd-admin/yeuCauDuLieuCu",
    "api_chinh_sua_bcd_tieu_chi" => BASE_URL_API . "/csdlgd-admin/bcdTieuChi",
    "csdlgd-admin-bcdNhomTieuChi-update" => BASE_URL_API . "/csdlgd-admin/bcdNhomTieuChi",
//
//cấu hình lịch đồng bộ
    "api_sua_lich_dong_bo" => BASE_URL_API . "/csdlgd-admin/yeuCauDongBo",
    "api_sua_lich_dong_bo_tn" => BASE_URL_API . "/csdlgd-admin/yeuCauDongBoTn",
    "api_xoa_lich_dong_bo" => BASE_URL_API . "/csdlgd-admin/yeuCauDongBo",
    "api_xoa_lich_dong_bo_tn" => BASE_URL_API . "/csdlgd-admin/yeuCauDongBoTn",
    "api_xoa_ly_do_bo_hoc" => BASE_URL_API . "/internal-api/dmLyDoBoHoc/delete",
    "api_xoa_don_vi" => BASE_URL_API . "/internal-api/dmDonVi/delete",
    "api_xoa_truong_hoc" => BASE_URL_API . "/internal-api/dmTruongHoc/delete",
    "api_xoa_mon_hoc" => BASE_URL_API . "/internal-api/dmMonHoc/delete",
    "api_xoa_tinh_thanh" => BASE_URL_API . "/internal-api/dmTinhThanh/delete",
    "api_xoa_quan_huyen" => BASE_URL_API . "/internal-api/dmQuanHuyen/delete",
    "api_xoa_phuong_xa" => BASE_URL_API . "/internal-api/dmPhuongXa/delete",
    "api_xoa_to_thon" => BASE_URL_API . "/internal-api/dmToThon/delete",
    "api_xoa_dan_toc" => BASE_URL_API . "/internal-api/dmDanToc/delete",
    "api_xoa_ton_giao" => BASE_URL_API . "/internal-api/dmTonGiao/delete",
    "api_xoa_chuyen_nganh_dao_tao" => BASE_URL_API . "/internal-api/dmCNganhDTao/delete",
    "api_xoa_doi_tuong_chinh_sach" => BASE_URL_API . "/internal-api/dmDTuongCSach/delete",
    "api_xoa_loai_doi_tuong" => BASE_URL_API . "/internal-api/dmLoaiDoiTuong/delete",
    "api_xoa_linh_vuc_danh_gia" => BASE_URL_API . "/internal-api/dmLinhVucDanhGiaSuPT/delete",
    "api_xoa_chi_so_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmChiSoDanhGiaSuPT/delete",
    "api_xoa_chuan_chieu_cao_can_nang" => BASE_URL_API . "/internal-api/dmChuanChieuCaoCanNang/delete",
    "api_xoa_yeu_cau_dong_bo_du_lieu" => BASE_URL_API . "/csdlgd-admin/guiYeuCau/delete/",
    "api_chinh_sua_phan_quyen_dong_bo" => BASE_URL_API . "/csdlgd-admin/yeuCauDuLieuCu",
    "api_thay_doi_trang_thai_yeu_cau_du_lieu_cu" => BASE_URL_API . "/csdlgd-admin/yeuCauDuLieuCu/trang-thai",

//Import

    "api_import_goi_cuoc_ca" => BASE_URL_API . "/csdlgd-admin/chung-thu-so/import-exel",
    "api_import_truong_hoc" => BASE_URL_API . "/internal-api/dmTruongHoc/import",
    "api_import_mon_hoc" => BASE_URL_API . "/internal-api/dmMonHoc/import",
    "api_import_tinh_thanh" => BASE_URL_API . "/internal-api/dmTinhThanh/import",
    "api_import_quan_huyen" => BASE_URL_API . "/internal-api/dmQuanHuyen/import",
    "api_import_phuong_xa" => BASE_URL_API . "/internal-api/dmPhuongXa/import",
    "api_import_to_thon" => BASE_URL_API . "/internal-api/dmToThon/import",
    "api_import_ton_giao" => BASE_URL_API . "/internal-api/dmTonGiao/import",
    "api_import_chuyen_nganh_dao_tao" => BASE_URL_API . "/internal-api/dmCNganhDTao/import",
    "api_import_du_lieu_giao_vien_sso" => BASE_URL_API . "/csdlgd-admin/giaoVien/upload-sso",
    "api_import_du_lieu_hoc_sinh_sso" => BASE_URL_API . "/csdlgd-admin/hocSinh/upload-sso",
    "api_import_du_lieu_can_bo_phong_so_sso" => BASE_URL_API . "/csdlgd-admin/giaoVien/canBo/upload-sso",
    "api_dowload_excel_du_lieu_thong_tin_y_te_hoc_sinh" => BASE_URL_API . "/csdlgd-report-api/download-excel/bc-suckhoe-hocsinh",
    "api_import_doi_tuong_chinh_sach" => BASE_URL_API . "/internal-api/dmDTuongCSach/import",
    "api_import_quan" => BASE_URL_API . "/internal-api/dmLoaiDoiTuong/import",
    "api_import_chuan_chieu_cao_can_nang" => BASE_URL_API . "/internal-api/dmChuanChieuCaoCanNang/import",
    "api_import_don_vi" => BASE_URL_API . "/internal-api/dmDonVi/import",
    "api_import_ly_do_bo_hoc" => BASE_URL_API . "/internal-api/dmLyDoBoHoc/import",
    "api_import_dan_toc" => BASE_URL_API . "/internal-api/dmDanToc/import",
    "api_import_loai_doi_tuong" => BASE_URL_API . "/internal-api/dmLoaiDoiTuong/import",
    "api_import_linh_vuc_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmLinhVucDanhGiaSuPT/import",
    "api_import_chi_so_danh_gia_phat_trien" => BASE_URL_API . "/internal-api/dmChiSoDanhGiaSuPT/import",
    "api_import_mat_khau_ket_chuyen" => BASE_URL_API . "/csdlgd-push/KetChuyenDL/importMatKhau",
    "api_import_mat_khau_ket_chuyen_ioc" => BASE_URL_API . "/csdlgd-push/KetChuyenDlIoc/importMatKhau",
    "api_lay_thong_tin_ket_chuyen" => BASE_URL_API . "/csdlgd-push/LichSuDay/Sreach",
    "api_lay_mat_khau_ket_chuyen" => BASE_URL_API . "/csdlgd-push/KetChuyenDL/filterMatKhauKc",
    "api_import_chuan_chieu_cao_can_nang" => BASE_URL_API . "/internal-api/dmChuanChieuCaoCanNang/import",
    // báo cáo ems api_render_emis
    "api_render_emis" => BASE_URL_API . "/csdlgd-report-api/emis/download-excel",
    // Đăng nhập SSO
    'api_get_access_token' => 'https://sso-edu.viettel.vn/api/Core/OAuth/AuthCode/accessToken',
    'api_get_access_tokenv2' => 'https://id.smartup.edu.vn/connect/token',
    // 'api_login_sso' => BASE_URL_API . "/csdlgd-user/auth/loginSso",
    'api_login_sso' => BASE_URL_API . "/csdlgd-user/auth/loginSso2",
    // lấy danh sách danh mục service
    'api_lay_danh_sach_danh_muc_service' => BASE_URL_API . "/csdlgd-push/API/DanhMuc/",
    'api_import_file_yeu_cau_thong_ke_theo_bieu_mau' => BASE_URL_API . "/csdlgd-admin/nop-bieu-mau/upload",
    'api_lay_danh_sach_tieu_chi_bao_cao' => BASE_URL_API . "/csdlgd-analytic-api/criteria/search",
    'api_lay_chi_tiet_tieu_chi' => BASE_URL_API . "/csdlgd-analytic-api/criteria/infor",
    'api_lay_chi_tiet_tieu_chi_html' => BASE_URL_API . "/csdlgd-analytic-api/BcChiTiet/convertExcelFileToHtml",
    'api_update_chi_tiet_tieu_chi_html' => BASE_URL_API . "/csdlgd-analytic-api/BcChiTiet/updateDanhSachTieuChi",
    'api-lay-danh-sach-sme-theo-doi-tuong' => BASE_URL_API . "/csdlgd-admin/sme/getSmeTheoDoiTuong",
    'api-lay-toan-bo-danh-sach-sme-mappingCode' => BASE_URL_API . "/csdlgd-admin/sme/getDanhSachSme",
    'api-lay-toan-bo-danh-sach-sme-moetCode' => BASE_URL_API . "/csdlgd-admin/sme/getDanhSachSmeMoetCode",
    'api_them_tieu_chi' => BASE_URL_API . "/csdlgd-analytic-api/criteria/create",
    'api_lay_thong_tin_tieu_chi' => BASE_URL_API . "/csdlgd-analytic-api/criteria/infor",
    'api_chinh_sua_tieu_chi' => BASE_URL_API . "/csdlgd-analytic-api/criteria/update",
    // IOC
    'api-lay-du-lieu-ioc' => BASE_URL_API . "/csdlgd-report-api/ioc/data",

];
