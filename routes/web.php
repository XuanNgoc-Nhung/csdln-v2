<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
Route::get('/dashboard', 'DashBoardController@dashboard')->name("dashboard");
Route::get('/data-import', 'CSDLController@ImportDataMoet');
Route::post('/login', 'MyLoginController@login')->name('login');
Route::get('/login2', 'MyLoginController@loginWithToken');
Route::get('/test', 'MyLoginController@test');
Route::post('/get_code_sso', 'MyLoginController@getCodeLoginSSO');
// Route::get('/login',function (){
//     return view('login.demologin');
// });
Route::get('/logout', 'MyLoginController@logout');
Route::get('/list-users', 'UserController@listUser');
Route::get('/content-manager', 'ContentController@index');
Route::get('/sso/callback.html', 'MyLoginController@dangNhapSSO')->name('sso-login-1');
Route::get('/sso/callback-smas.html', 'MyLoginController@loginWithTokenSMAS')->name('sso-login-smas');
Route::get('/sso/login.html', 'MyLoginController@dangNhapSSOV2')->name('sso-login');
Route::get('/sso/logout.html', 'MyLoginController@dangXuatSSOV2')->name('sso-logout');
// Route::get('/demologin',function (){
//     return view('login.demologin');
// });
//Route::get('/redirecttosso',function (){
//    return view('login.redirecttosso');
//});
Route::get('/redirecttosso', 'MyLoginController@redirecttosso')->name('redirecttosso');
Route::get('/pdf',function (){
    return view('pdf');
});
Route::get('/', 'MyLoginController@CheckLogin')->name('home');
Route::get('/login', 'MyLoginController@CheckLogin');
Route::get('/admin', function () {
    return view('content.index');
})->name('admin');

Route::get('js/{filename}', function($filename){
    $login = session('isLoggedIn', false);
    if(!$login){
        abort(403);
    }
    return response(Storage::disk('public')->get('js/'.$filename))->header('Content-Type', 'text/javascript');
})->where('filename', '.*');


Route::post('/xuat-excel-bao-cao-dong-hoc-sinh','CSDLController@ExportExcelReportPupil');
Route::post('/xuat-excel-bao-cao-dong-can-bo','CSDLController@ExportExcelReportTeacher');
Route::post('/xuat-excel-bao-cao-dong-truong-hoc','CSDLController@ExportExcelReportSchool');
Route::post("/forward-api", "ApiGatewayController@request");
Route::post("/forward-api-2", "ApiGatewayController@request2");
Route::post("/xuat-excel", "CSDLController@ExportExcel");
Route::post("/xuat-excel-danh-sach-tra-cuu-hoc-sinh", "CSDLController@ExportExcelListStudent");
Route::post("/xuat-excel-danh-sach-truong-nop-thong-ke-theo-bieu-mau", "CSDLController@ExportExcelCacTruongNopBaoCaoTheoBieuMau");
Route::post("/xuat-excel-danh-sach-tra-cuu-kqht", "CSDLController@ExportExcelListKqht");
Route::post("/xuat-excel-danh-sach-tra-cuu-lop-hoc", "CSDLController@ExportExcelListClass");
Route::post("/xuat-excel-danh-sach-can-bo-phong-so", "CSDLController@ExportExcelListCanBoPhongSo");
Route::post("/xuat-excel-ban-ghi-loi-lich-su-chuyen-du-lieu", "CSDLController@ExportExcelListBanGhiLoi");
Route::post("/xuat-excel-lich-su-day-du-lieu-len-bo", "CSDLController@ExportExcelLichSuDayDuLieuLenBo");
Route::post("/xuat-excel-danh-sach-tra-cuu-can-bo", "CSDLController@ExportExcelListTeacher");
Route::post("/xuat-excel-bao-cao-tinh-hinh-nop-du-lieu", "CSDLController@ExportExcelReportSyncStatus");
Route::post("/xuat-excel-danh-sach-truong-hoc", "CSDLController@ExportExcelListSchool");
Route::post("/download-file-import-du-lieu-kqht", "CSDLController@ExportExcelTemplateImportDuLieuNamHoc");
Route::post("/render-excel", "CSDLController@RenderExcelToHtml");
Route::post("/xuat-bao-cao-pdf", "CSDLController@ExportPdf");
Route::post("/xuat-bao-cao-pdf-thong-tin-hoc-sinh", "CSDLController@ExportPdfInfoStudent");
Route::post("/xuat-bao-cao-pdf-thong-tin-can-bo", "CSDLController@ExportPdfInfoTeacher");
Route::post("/csdlgd-report-api/download");

Route::get('/data-receive-status','CSDLController@TinhHinhNopDuLieuCuSo');
Route::post('/doi_mat_khau_ban_than','CSDLController@DoiMatKhauBanThan');
Route::post('/lay_danh_sach_danh_muc_service','CSDLController@GetDanhMucServiceBo');
Route::get('/Report-to-the-ministry','CSDLController@BaoCaoChoBo');
Route::get('/Report-eqms','CSDLController@BaoCaoEQMS');
Route::get('/specific-reports','CSDLController@BaoCaoDuLieuDacThu');
Route::get('/Report-to-the-department','CSDLController@BaoCaoChoSo');
Route::get('/Report-to-school','CSDLController@BaoCaoChoTruong');
Route::get('/Report-submitted','CSDLController@BaoCaoGuiLen');
Route::get('/user-management','CSDLController@QuanLyNguoiDung');
Route::get('/role_management','CSDLController@QuanLyVaiTro');
Route::get('/Email-configuration','CSDLController@CauHinhEmail');
Route::get('/Configure-email-templates','CSDLController@CauHinhMauEmail');
Route::get('/Configuring-path-logo','CSDLController@CauHinhDuongDanLogo');
Route::get('/Configure-sync-calendar','CSDLController@CauHinhLichDongBo');
Route::get('/Configure-sync-calendar-old','CSDLController@CauHinhLichDongBoCu');
Route::get('/Configure-push-moet','CSDLController@CauHinhLichDongBoHangNam');
Route::get('/Decentralize-old-data','CSDLController@PhanQuyenDuLieuCu');
Route::get('/Lookup-requires-synchronization','CSDLController@TraCuuDongBoDuLieu');
Route::get('/Request-to-synchronize-old-data','CSDLController@YeuCauDongBoDuLieuCu');
Route::get('/Request-data-by-school','CSDLController@YeuCauDongBoDuLieuTheoTruong');
Route::get('/Request-data-by-school-ioc','CSDLController@YeuCauDongBoDuLieuTheoTruongIOC');
Route::get('/Request-data-by-school-chuyen-truong','CSDLController@HocSinhGiaoVienChuyenTruong');
Route::get('/Data-criteria','CSDLController@TieuChiDuLieu');
Route::get('/Data-entry-requirements','CSDLController@YeuCauNhapLieu');
Route::get('/See-specific-data','CSDLController@XemDuLieuDacThu');
Route::get('/Data-push-history','CSDLController@LichSuDayDuLieu');
Route::get('/Report-push-data','CSDLController@BaoCaoDayDuLieu');
Route::get('/Look-up-students','CSDLController@TraCuuHocSinh');
Route::get('/import_study_results_data','CSDLController@NhapLieuDuLieuNamHocCu');
Route::get('/import_data_ioc','CSDLController@NhapLieuDuLieuNamHoc');
Route::get('/Look-up-academi-results','CSDLController@TraCuuKetQuaHocTap');
Route::get('/Look-up-officials','CSDLController@TraCuuCanBo');
Route::get('/Look-up-department-officials','CSDLController@TraCuuCanBoPhongSo');
Route::get('/lookup_attendance','CSDLController@TraCuuDuLieuDiemDanh');
Route::get('/Look-up-academi-results-Circulars-22','CSDLController@exportHocSinhTt26');
Route::get('/Lock-data-report','CSDLController@chotDuLieuBaoCao');
Route::get('/Request-sync-to-school','CSDLController@GuiYeuCauDongBoDuLieu');
Route::get('/Look-up-students-in-sync','CSDLController@TraCuuHocSinhDongBo');
Route::get('/Data-transfer-schedule','CSDLController@LichSuChuyenDuLieu');
Route::get('moet-transfer-history','CSDLController@LichSuDayDuLieuLenBo');
Route::get('moet-transfer-history-ioc','CSDLController@LichSuDayDuLieuLenIOC');
Route::get('Submit_statistical_sample','CSDLController@YeuCauNopThongKeTheoBieuMau');
Route::get('Look-up-classes','CSDLController@TraCuuLopHoc');
Route::get('/EMIS-report','CSDLController@BaoCaoEMIS');
Route::get('/report-emis','CSDLController@DemoBaoCaoEMIS');
Route::get('/Report-of-the-unit','CSDLController@BaoCaoCuaDonVi');
Route::get('/update-partners','CSDLController@CapNhatDoiTac');
Route::get('/List-of-data-requests','CSDLController@DanhSachYeuCauDuLieu');
Route::get('/manual-data-input','CSDLController@NhapLieu');
Route::get('/manual-data-input-bte','CSDLController@NhapLieu');
//Biểu đổ
Route::get('/teacher-chart','CSDLController@BieuDoGiaoVien');
Route::get('/student-chart','CSDLController@BieuDoHocSinh');
Route::get('/student-ranking-chart','CSDLController@BieuDoXepLoaiHocSinh');
Route::get('/service-category','CSDLController@DanhMucServiceBo');
Route::get('/report-sync-status','CSDLController@BaoCaoTinhHinhNopDuLieu');
Route::get('/Config-sync-time','CSDLController@CauHinhThoiGianNopDuLieu');
Route::get('/cau-hinh-cap-truong','CSDLController@CauHinhThoiGianNopDuLieu');
Route::get('/config-moet-transfer-permission','CSDLController@CauHinhDuyetDayDuLieu');
Route::get('/sao-luu-du-lieu','CSDLController@SaoLuuDuLieu');


Route::get('/category/unit','SuperAdminController@DonVi');
Route::get('/category/schools','SuperAdminController@TruongHoc');
Route::get('/category/subjects','SuperAdminController@MonHoc');
Route::get('/category/city','SuperAdminController@TinhThanh');
Route::get('/category/district','SuperAdminController@QuanHuyen');
Route::get('/category/wards','SuperAdminController@XaPhuong');
Route::get('/category/village','SuperAdminController@ToThon');
Route::get('/category/nation','SuperAdminController@DanToc');
Route::get('/category/religion','SuperAdminController@TonGiao');
Route::get('/category/specialized-training','SuperAdminController@ChuyenNganhDaoTao');
Route::get('/category/policy-object','SuperAdminController@DoiTuongChinhSach');
Route::get('/category/reason-for-dropping-out','SuperAdminController@LyDoBoHoc');
Route::get('/category/object-type','SuperAdminController@LoaiDoiTuong');
Route::get('/category/field-of-development-evaluation','SuperAdminController@LinhVucDanhGiaVaPhatTrien');
Route::get('/category/index-of-development-evaluation','SuperAdminController@ChiSoDanhGiaVaPhatTrien');
Route::get('/category/standard-weight-height','SuperAdminController@ChieuCaoCanNang');
Route::get('/Partner-management','SuperAdminController@QuanLyDoiTac');
Route::get('/Question-management','SuperAdminController@QuanLyCauHoi');
Route::get('/Report-management-criteria','CSDLController@BaoCaoDong');
Route::get('/bao-cao-tich-hop',function (){
    if(env('BAO_TRI')){
        return view("content.baotri");
    }
    return view('baocao.BaoCaoTichHop');
});
Route::get('/import-kiem-dinh-chat-luong',function (){
    if(env('BAO_TRI')){
        return view("content.baotri");
    }
    return view('import.kiem-dinh-chat-luong');
});
Route::get('/goi-cuoc-giao-vien',function (){
    if(env('BAO_TRI')){
        return view("content.baotri");
    }
    return view('content.goi-cuoc-giao-vien');
});
Route::get('/dong-bo-danh-muc',function (){
    if(env('BAO_TRI')){
        return view("content.baotri");
    }
    return view('content.dong-bo-danh-muc');
});
Route::get('/config-moet-transfer-permission-ioc',function (){
    if(env('BAO_TRI')){
        return view("content.baotri");
    }
    return view('content.cau-hinh-duyet-day-len-ioc');
});
Route::get('/tong-hop-tuyen-sinh',function (){
    if(env('BAO_TRI')){
        return view("content.baotri");
    }
    return view('content.tong-hop-tuyen-sinh');
});
Route::get('/sap-nhap-truong',function (){
    if(env('BAO_TRI')){
        return view("content.baotri");
    }
    return view('sapnhapgiaithe.sap-nhap-truong');
});
Route::get('/giai-the-truong',function (){
    if(env('BAO_TRI')){
        return view("content.baotri");
    }
    return view('sapnhapgiaithe.giai-the-truong');
});

Route::get('/analytic-indicator-manager','CSDLController@BaoCaoDongPA');
Route::get('/analytic-indicator-manager-2','CSDLController@BaoCaoDongPAV2');
Route::get('/manage-criteria-groups','SuperAdminController@QuanLyNhomTieuChi');
Route::get('/manage-criteria','SuperAdminController@QuanLyTieuChi');
Route::get('/synchronous-history-of-EMIS','SuperAdminController@LichSuDongBoEmis');
Route::get('/report/manage-criteria-groups','SuperAdminController@BaoCaoQuanLyNhomTieuChi');
Route::get('/report/manage-criteria','SuperAdminController@BaoCaoQuanLyTieuChi');
Route::get('/configuration-report','SuperAdminController@CauHinhBaoCao');
Route::get('/form-management','SuperAdminController@QuanLyBieuMau');
Route::get('/Form-hierarchy','SuperAdminController@PhanCapBieuMau');
Route::get('/look-up-errors','SuperAdminController@TraCuuLoi');
Route::get('/look-up-data','SuperAdminController@TraCuuDuLieu');
Route::get('/help','SuperAdminController@TroGiup');
//API

Route::get('/api_lay_danh_sach_dan_toc','SuperAdminApiController@getListDanToc');
Route::get('/api_lay_danh_sach_ton_giao','SuperAdminApiController@getListTonGiao');
Route::get('/api_lay_danh_sach_tinh_thanh','SuperAdminApiController@getListTinhThanh');
Route::get('/api_lay_danh_sach_quan_huyen','SuperAdminApiController@getListQuanHuyen');
Route::get('/api_lay_danh_sach_xa_phuong','SuperAdminApiController@getListPhuongXa');
Route::get('/api_lay_danh_sach_chuyen_nganh_dao_tao','SuperAdminApiController@getListChuyenNganhDaoTao');
Route::get('/api_lay_danh_sach_ly_do_bo_hoc','SuperAdminApiController@getListLyDoBoHoc');
Route::get('/api_lay_danh_sach_doi_tuong_chinh_sach','SuperAdminApiController@getListDoiTuongChinhSach');
Route::get('/api_lay_danh_sach_mon_hoc','SuperAdminApiController@getListMonHoc');
Route::get('/api_lay_danh_sach_loai_doi_tuong','SuperAdminApiController@getListLoaiDoiTuong');
Route::get('/api_lay_danh_sach_linh_vuc_danh_gia_phat_trien','SuperAdminApiController@getListLinhVucDGPT');
Route::get('/api_lay_danh_sach_chi_so_danh_gia_phat_trien','SuperAdminApiController@getListChiSoDGPT');
Route::get('/api_lay_danh_sach_chuan_chieu_cao_can_nang','SuperAdminApiController@getListChuanCCCN');
Route::get('/api_lay_danh_sach_don_vi','SuperAdminApiController@getListDonVi');
Route::get('/api_lay_danh_sach_to_thon','SuperAdminApiController@getListToThon');
Route::get('/api_lay_danh_sach_truong_hoc','SuperAdminApiController@getListTruongHoc');

Route::post('/api_them_dan_toc','SuperAdminApiController@themDanToc');
Route::post('/api_them_ton_giao','SuperAdminApiController@themTonGiao');
Route::post('/api_them_tinh_thanh','SuperAdminApiController@themTinhThanh');
Route::post('/api_them_quan_huyen','SuperAdminApiController@themQuanHuyen');
Route::post('/api_them_xa_phuong','SuperAdminApiController@themPhuongXa');
Route::post('/api_them_chuyen_nganh_dao_tao','SuperAdminApiController@themChuyenNganhDaoTao');
Route::post('/api_them_ly_do_bo_hoc','SuperAdminApiController@themLyDoBoHoc');
Route::post('/api_them_doi_tuong_chinh_sach','SuperAdminApiController@themDoiTuongChinhSach');
Route::post('/api_them_mon_hoc','SuperAdminApiController@themMonHoc');
Route::post('/api_them_loai_doi_tuong','SuperAdminApiController@themLoaiDoiTuong');
Route::post('/api_them_linh_vuc_danh_gia_phat_trien','SuperAdminApiController@themLinhVucDGPT');
Route::post('/api_them_chi_so_danh_gia_phat_trien','SuperAdminApiController@themChiSoDGPT');
Route::post('/api_them_tieu_chuan_chieu_cao_can_nang','SuperAdminApiController@themChuanCCCN');
Route::post('/api_them_to_thon','SuperAdminApiController@themToThon');
Route::post('/api_them_don_vi','SuperAdminApiController@themDonVi');
Route::post('/api_them_doi_tac','SuperAdminApiController@themDoiTac');
Route::post('/api_them_yeu_cau_du_lieu_theo_truong','AdminApiController@themYeuCauDuLieuTheoTruong');
Route::post('/api_them_yeu_cau_du_lieu_cu','AdminApiController@themYeuCauDuLieuCu');
Route::post('/api_them_nguoi_dung','AdminApiController@themNguoiDung');

Route::post('/api_chinh_sua_dan_toc','SuperAdminApiController@chinhSuaDanToc');
Route::post('/api_chinh_sua_ton_giao','SuperAdminApiController@chinhSuaTonGiao');
Route::post('/api_chinh_sua_tinh_thanh','SuperAdminApiController@chinhSuaTinhThanh');
Route::post('/api_chinh_sua_chuyen_nganh_dao_tao','SuperAdminApiController@chinhSuaChuyenNganhDaoTao');
Route::post('/api_chinh_sua_ly_do_bo_hoc','SuperAdminApiController@chinhSuaLyDoBoHoc');
Route::post('/api_chinh_sua_doi_tuong_chinh_sach','SuperAdminApiController@chinhSuaDoiTuongChinhSach');
Route::post('/api_chinh_sua_mon_hoc','SuperAdminApiController@chinhSuaMonHoc');
Route::post('/api_chinh_sua_loai_doi_tuong','SuperAdminApiController@chinhSuaLoaiDoiTuong');
Route::post('/api_chinh_sua_linh_vuc_danh_gia_phat_trien','SuperAdminApiController@chinhSuaLinhVucDGPT');
Route::post('/api_chinh_sua_chi_so_danh_gia_phat_trien','SuperAdminApiController@chinhSuaChiSoDGPT');
Route::post('/api_chinh_sua_tieu_chuan_chieu_cao_can_nang','SuperAdminApiController@chinhSuaChuanCCCN');
Route::post('/api_chinh_sua_phuong_xa','SuperAdminApiController@chinhSuaPhuongXa');
Route::post('/api_chinh_sua_to_thon','SuperAdminApiController@chinhSuaToThon');
Route::post('/api_chinh_sua_doi_tac','SuperAdminApiController@chinhSuaDoiTac');
Route::post('/api_chinh_sua_nguoi_dung','AdminApiController@chinhSuaNguoiDung');
Route::post('/api_change_pass_nguoi_dung','AdminApiController@changePassNguoiDung');
Route::post('/api_thay_doi_trang_thai_nguoi_dung','AdminApiController@thayDoiTrangThaiNguoiDung');
Route::post('/chinh-sua-lich-dong-bo','AdminApiController@chinhSuaLichDongBo');
Route::post('/chinh-sua-lich-dong-bo-tn','AdminApiController@chinhSuaLichDongBoTN');
Route::post('/api_chinh_sua_phan_quyen_dong_bo','AdminApiController@chinhSuaPhanQuyenDongBo');

Route::post('/api_chinh_sua_don_vi','SuperAdminApiController@chinhSuaDonVi');
Route::post('/api_chinh_sua_truong_hoc','SuperAdminApiController@chinhSuaTruongHoc');
Route::post('/api_chinh_sua_quan_huyen','SuperAdminApiController@chinhSuaQuanHuyen');


Route::post('/api_xoa_doi_tac','SuperAdminApiController@xoaDoiTac');
Route::post('/api_xoa_lich_dong_bo','AdminApiController@xoaLichDongBo');
Route::post('/api_xoa_lich_dong_bo_tn','AdminApiController@xoaLichDongBoTN');



Route::post('/api_chinh_sua_yeu_cau_du_lieu_cu','AdminApiController@chinhSuaYeuCauDuLieuCu');

Route::post('/api_xoa_dan_toc','SuperAdminApiController@xoaDanToc');
Route::post('/api_xoa_ly_do_bo_hoc','SuperAdminApiController@xoaLyDoBoHoc');
Route::post('/api_xoa_don_vi','SuperAdminApiController@xoaDonVi');
Route::post('/api_xoa_truong_hoc','SuperAdminApiController@xoaTruongHoc');
Route::post('/api_xoa_mon_hoc','SuperAdminApiController@xoaMonHoc');
Route::post('/api_xoa_tinh_thanh','SuperAdminApiController@xoaTinhThanh');
Route::post('/api_xoa_quan_huyen','SuperAdminApiController@xoaQuanHuyen');
Route::post('/api_xoa_phuong_xa','SuperAdminApiController@xoaPhuongXa');
Route::post('/api_xoa_to_thon','SuperAdminApiController@xoaToThon');
Route::post('/api_xoa_dan_toc','SuperAdminApiController@xoaDanToc');
Route::post('/api_xoa_ton_giao','SuperAdminApiController@xoaTonGiao');
Route::post('/api_xoa_yeu_cau_dong_bo_du_lieu','SuperAdminApiController@xoaYeuCauDongBoDuLieu');
Route::post('/api_xoa_chuyen_nganh_dao_tao','SuperAdminApiController@xoaChuyenNganhDaoTao');
Route::post('/api_xoa_doi_tuong_chinh_sach','SuperAdminApiController@xoaDoiTuongChinhSach');
Route::post('/api_xoa_loai_doi_tuong','SuperAdminApiController@xoaLoaiDoiTuong');
Route::post('/api_xoa_linh_vuc_danh_gia_phat_trien','SuperAdminApiController@xoaLinhVucDanhGia');
Route::post('/api_xoa_chi_so_danh_gia_phat_trien','SuperAdminApiController@xoaChiSoDanhGiaPT');
Route::post('/api_xoa_chuan_chieu_cao_can_nang','SuperAdminApiController@xoaChuanChieuCaoCanNang');
Route::post('/api_xoa_can_bo_phong_so','SuperAdminApiController@xoaCanBoPhongSo');

//phần của admin sở

//phần tra cứu
Route::get('/api_lay_danh_sach_hoc_sinh','AdminApiController@getListStudent');
Route::get('/api_tra_cuu_giao_vien','AdminApiController@getListTeacher');
Route::get('/api_lay_thong_tin_giao_vien','AdminApiController@api_lay_danh_sach_don_vi');
//Hệ thống
Route::get('/api_lay_danh_sach_nguoi_dung','AdminApiController@getListUser');
//Quản lý đồng bộ
Route::get('/api_lay_danh_sach_yeu_cau_dong_bo','AdminSoApiController@getListDongBo');
Route::get('/api_lay_danh_sach_yeu_cau_du_lieu_cu','AdminSoApiController@getListYeuCauDuLieuCu');
Route::post('/thay-doi-trang-thai-phan-quyen-du-lieu-cu','AdminSoApiController@ThayDoiTrangThaiYeuCauDuLieuCu');

Route::get('/api_lay_thong_tin_yeu_cau_dong_bo','AdminSoApiController@layThongTinDongBo');


Route::post('/api_them_lich_dong_bo','AdminSoApiController@themCauHinhLichDongBo');


Route::post('/api_xoa_cau_hinh_lich_dong_bo','AdminSoApiController@xoaCauHinhLichDongBo');
Route::post('/api_chinh_sua_bcd_tieu_chi','AdminApiController@chinhSuaBcdTieuChi');
Route::post('/csdlgd-admin-bcdNhomTieuChi-update','AdminApiController@updateNhomTieuChi');


//Xuất file PDF
Route::post("/xuat-excel-truong-hoc-da-nop-bao-cao-theo-bieu-mau", "CSDLController@ExportExcelTruongNopBaoCaoTheoBieuMau");
Route::post("/tong-hop-thong-ke-theo-bieu-mau", "CSDLController@ExportExcelTongHopBaoCaoTheoBieuMau");
Route::post("/xuat-excel-hk", "CSDLController@ExportExcelHk");
Route::post("/xuat-excel-ket-chuyen-du-lieu", "CSDLController@ExportExcelKCDL");
Route::post("/down-load-template-mk-ket-chuyen", "CSDLController@ExportTemplateMkKetChuyen");
Route::post("/xuat-excel-du-lieu-sso", "CSDLController@ExportExcelDuLieuSSO");
Route::post("/xuat-excel-du-lieu-diem-danh", "CSDLController@ExportExcelDuLieuDiemDanh");
Route::post("/xuat-excel-du-thong-tin-y-te-hoc-sinh", "CSDLController@ExportExcelDuLieuThongTinYTe");
Route::post("/xuat-bao-cao-pdf-hk", "CSDLController@ExportPdfHk");
Route::get('/filepdf','UserController@getPDF');
//Import Excel

Route::post('/api-import-goi-cuoc-ca','SuperAdminApiController@ImportGoiCuocCA');
Route::post('/api-import-truong-hoc','SuperAdminApiController@ImportTruongHoc');
Route::post('/api-import-mon-hoc','SuperAdminApiController@ImportMonHoc');
Route::post('/api-import-tinh-thanh','SuperAdminApiController@ImportTinhThanh');
Route::post('/api-import-quan-huyen','SuperAdminApiController@ImportQuanHuyen');
Route::post('/api-import-phuong-xa','SuperAdminApiController@ImportPhuongXa');
Route::post('/api-import-to-thon','SuperAdminApiController@ImportToThon');
Route::post('/api-import-dan-toc','SuperAdminApiController@ImportDanToc');
Route::post('/api-import-ton-giao','SuperAdminApiController@ImportTonGiao');
Route::post('/api-import-chuyen-nganh-dao-tao','SuperAdminApiController@ImportChuyenNganhDaoTao');
Route::post('/api-import-file-nop-yeu-cau-theo-bieu-mau','SuperAdminApiController@ChinhSuaYeuCauNopThongKeTheoBieuMau');
Route::post('/api-import-du-lieu-sso-giao-vien','SuperAdminApiController@ImportDuLieuGiaoVienSSO');
Route::post('/api-import-du-lieu-sso-hoc-sinh','SuperAdminApiController@ImportDuLieuHocSinhSSO');
Route::post('/api-import-du-lieu-sso-can-bo-phong-so','SuperAdminApiController@ImportDuLieuCanBoPhongSoSSO');
Route::post('/nhap-lieu-du-lieu-nam-hoc-cu','AdminApiController@NhapLieuDuLieuNamHocCu');
Route::post('/api-import-doi-tuong-chinh-sach','SuperAdminApiController@ImportDoiTuongChinhSach');
Route::post('/api-import-ly-do-bo-hoc','SuperAdminApiController@ImportLyDoBoHoc');
Route::post('/api-import-loai-doi-tuong','SuperAdminApiController@ImportLoaiDoiTuong');
Route::post('/api-import-linh-vuc-danh-gia-phat-trien','SuperAdminApiController@ImportLinhVucDanhGiaPhatTrien');
Route::post('/api-import-chi-so-danh-gia-phat-trien','SuperAdminApiController@ImportChiSoDanhGiaPhatTrien');
Route::post('/api-import-mat-khau-ket-chuyen','SuperAdminApiController@ImportMatKhauKetChuyen');
Route::post('/api-import-mat-khau-ket-chuyen-ioc','SuperAdminApiController@ImportMatKhauKetChuyenIoc');
Route::post('/api-import-chuan-chieu-cao-can-nang','SuperAdminApiController@ImportChuanChieuCaoCanNang');
Route::post('/api_lay_thong_tin_ket_chuyen','AdminApiController@LayThongTinKetChuyenDuLieu');
Route::post('/api_lay_mat_khau_ket_chuyen','AdminApiController@LayMatKhauKetChuyen');

Route::post('/api-import-don-vi','SuperAdminApiController@ImportDonVi');

Route::get('/api-get-api-link','BaseController@getApiLink');
Route::get('/olap-reports','SuperAdminController@olapReport');
Route::get('/compare-moet','CSDLController@soSanhDuLieuMoet');
Route::get('/pass-data-transfer','CSDLController@MatKhauKetChuyen');
Route::get('/pass-data-transfer-ioc','CSDLController@MatKhauKetChuyenIOC');
Route::get('/submit-data-ioc','CSDLController@nopDuLieuIoc');
Route::get('/data-transfer','CSDLController@KetChuyenDuLieu');
Route::get('/chuyen-huong-yeu-cau-du-lieu','CSDLController@ChuyenHuongYeuCau');
Route::get('/submit-data-sso','CSDLController@NopDuLieuSSO');
Route::get('/data-synchronization','CSDLController@TongHopDuLieuTruong');
Route::get('/data-synchronization-emis','CSDLController@TongHopDuLieuTruongEmis');
Route::get('/analytic-template-edit','CSDLController@ChinhSuaTemplateBaoCao');
Route::get('/dynamic-report-external-indicator','CSDLController@NhapLieuTieuChiNgoai');
Route::get('/Student-medical-information','CSDLController@ThongTinYTeHocSinh');
Route::get('/update-school-partners','CSDLController@CapNhatDoiTacTruong');
Route::post('/api_tong_hop_du_lieu_nha_truong','CSDLController@TongHopDuLieuNhaTruong');
// Route::post('/api_tong_hop_du_lieu_nha_truong','AdminSoApiController@TongHopDuLieuNhaTruong');
// Route::get('/ket-qua-xt-tam-thoi','CSDLController@Demo');
// báo cáo olap
// Import dữ liệu moet

Route::post('/api-import-buoc-mot-du-lieu-moet','ImportDataMoetController@ImportDuLieuMoetBuocMot');
Route::post('/api-import-bao-cao-dong','ImportDataMoetController@ImportBaoCaoDong');
Route::get('/manage-criteria-of-dynamic-reports','CSDLController@ThemTieuChi');
Route::post('/submit-data-sso','ImportDataMoetController@chinhSuaTemplate2');
Route::post('/api-chinh-sua-template','ImportDataMoetController@chinhSuaTemplate');
Route::post('/api-post-chinh-sua-template-bao-cao','ImportDataMoetController@postChinhSuaTemplate');
Route::get('/api-lay-danh-sach-tieu-chi','ImportDataMoetController@layDanhSachTieuChi');
Route::get('/api-lay-chi-tiet-tieu-chi','ImportDataMoetController@layChiTietTieuChi');
Route::get('/api_lay_tieu_chi_html','ImportDataMoetController@layChiTietTieuChiHtml');
Route::get('/api-lay-sme-theo-doi-tuong','ImportDataMoetController@layDanhSachSmeTheoDoiTuong');
Route::get('/api-lay-toan-bo-sme-mappingcode','ImportDataMoetController@LayToanBoDanhSachSmeMappingCode');
Route::get('/lay-sme-moet-code','ImportDataMoetController@LayToanBoDanhSachSmeMoetCode');
Route::get('/lay-sme-mapping-code','ImportDataMoetController@LayToanBoDanhSachSmeMappingCode');
Route::get('/lay-du-du-lieu-ioc-theo-khu-vuc','ImportDataMoetController@LayDuLieuIOCTheoKhuVuc');
Route::get('/api-lay-thong-tin-tieu-chi','ImportDataMoetController@layThongTinTieuChi');
Route::post('/api-post-them-tieu-chi','ImportDataMoetController@PostThemTieuChi');
Route::post('/api-post-chinh-sua-tieu-chi','ImportDataMoetController@PostChinhSuaTieuChi');
Route::get('/lay-toan-bo-tieu-chi','ChinhSuaTemplateBaoCaoController@layToanBoTieuChi');
// Route::get('/dashboard','IOCController@banDo')->name('dashboard');


Route::post('/upload-file-bieu-mau','ImportDataMoetController@nopBieuMauTkPhongSo');

Route::post('test-upload', function(Request $req){
    return $req->all();
});
Route::get('test-upload', function(){
    return view('baocao.BaoCaoTichHop');
});
Route::get('view-excel',function (){
    $path = request()->query('path');
    $currentDomain = 'https://' . request()->getHost();
    $result = str_starts_with($path, $currentDomain);
    if (!$result) {
        $path = preg_replace('/https?:\/\/[^\/]+/', $currentDomain, $path);
        return redirect()->to('view-excel?path=' . $path);
    }
    return view('baocao.view-excel');
});

Route::post('/build-excel', 'ExcelController@renderExcel');

// Test route cho binary file log
Route::post('/api-test-binary-file-log','SuperAdminApiController@testBinaryFileLog');
