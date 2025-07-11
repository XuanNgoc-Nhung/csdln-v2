<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SuperAdminApiController extends BaseController
{
//Danh mục - Dân tộc
    public function getListDanToc(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("nation_name"),
            'loai' => $request->get("nation_type"),
            'trangthai' => $request->get("nation_status"),
        );
        $uri = config('url.api_lay_danh_sach_dan_toc');
        Log::info("Lấy danh sách dân tộc:");
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themDanToc(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'tenDanToc' => $request->get("nation_name"),
            'maDanToc' => $request->get("nation_code"),
            'loaiDanToc' => $request->get("nation_type"),
        );
        $uri = config('url.api_them_danh_sach_dan_toc');
        $resp = $this->helper->doPost($uri, $params);
        Log::info("Thêm dân tộc");
        Log::info($resp);
        return json_encode($resp);
    }

    public function chinhSuaDanToc(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'tenDanToc' => $request->get("nation_name"),
            'maDanToc' => $request->get("nation_code"),
            'loaiDanToc' => $request->get("nation_type"),
            'trangThai' => $request->get("nation_status"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_dan_toc');
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }

//    public function xoaDanToc(Request $request)
//    {
//        Log::info($request->all());
//        $params = array(
//            'ma' => $request->get("id"),
//        );
//        $uri = config('url.api_xoa_danh_sach_dan_toc');
//        $resp = $this->helper->doDelete($uri, $params);
//        return json_encode($resp);
//    }

//Danh mục - tôn giáo
    public function getListTonGiao(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'trangthai' => $request->get("trangThai"),
            'ten' => $request->get("ten_tongiao"),
            'ma' => $request->get("ma_tongiao"),
        );
        $uri = config('url.api_lay_danh_sach_ton_giao');
        $resp = $this->helper->doGet($uri, $params);
        Log::info("Lấy danh sách tôn giáo:");
        Log::info($params);

        return json_encode($resp);
    }

    public function themTonGiao(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'maTonGiao' => $request->get("ma_tongiao"),
            'tenTonGiao' => $request->get("ten_tongiao"),
            'maCuaBo' => $request->get("ma_cuabo"),
        );
        $uri = config('url.api_them_danh_sach_ton_giao');
        $resp = $this->helper->doPost($uri, $params);
        Log::info("Thêm tôn giáo");
        Log::info($resp);
        return json_encode($resp);
    }

    public function chinhSuaTonGiao(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'maTonGiao' => $request->get("ma_tongiao"),
            'tenTonGiao' => $request->get("ten_tongiao"),
            'maCuaBo' => $request->get("ma_cuabo"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_ton_giao');
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }

//    Danh mục - Tình thành
    public function getListTinhThanh(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'trangthai' => $request->get("trangThai"),
            'ten' => $request->get("ten_tinhthanh"),
            'ma' => $request->get("ma_tinhthanh"),
        );
        $uri = config('url.api_lay_danh_sach_tinh_thanh');
        $resp = $this->helper->doGet($uri, $params);
        Log::info("Lấy danh sách tỉnh thành:");
        Log::info($params);

        return json_encode($resp);
    }

    public function themTinhThanh(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'ma' => $request->get("ma_tinhthanh"),
            'ten' => $request->get("ten_tinhthanh"),
            'trangThai' => '0',
        );
        $uri = config('url.api_them_danh_sach_tinh_thanh');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaTinhThanh(Request $request)
    {
        $params = array(
            'ma' => $request->get("ma_tinhthanh"),
            'ten' => $request->get("ten_tinhthanh"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_tinh_thanh');
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }

//    Danh mục - quận huyện


    public function getListQuanHuyen(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'trangthai' => $request->get("trangThai"),
            'ten' => $request->get("ten_quanhuyen"),
            'ma' => $request->get("ma_quanhuyen"),
            'maTinhThanh' => $request->get("ma_tinhthanh"),
        );
        $uri = config('url.api_lay_danh_sach_quan_huyen');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }

    public function themQuanHuyen(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'ma' => $request->get("ma_quanhuyen"),
            'ten' => $request->get("ten_quanhuyen"),
            'maTinhThanh' => $request->get("ma_tinhthanh"),
        );
        $uri = config('url.api_them_danh_sach_quan_huyen');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaQuanHuyen(Request $request)
    {
        $params = array(
            'ma' => $request->get("ma_quanhuyen"),
            'ten' => $request->get("ten_quanhuyen"),
            'maTinhThanh' => $request->get("ma_tinhthanh"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_quan_huyen');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }
//
//    public function xoaQuanHuyen(Request $request)
//    {
//        $params = array(
//            'ma' => $request->get("maQuanHuyen"),
//        );
//        $uri = config('url.api_xoa_danh_sach_quan_huyen');
//        $resp = $this->helper->doDelete($uri, $params);
//        Log::info($uri);
//        return json_encode($resp);
//    }

//    Danh mục - Phường xã


    public function getListPhuongXa(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'trangthai' => $request->get("trangThai"),
            'ten' => $request->get("ten_phuongxa"),
            'ma' => $request->get("ma_phuongxa"),
            'maQuanHuyen' => $request->get("ma_quanhuyen"),
            'maTinhThanh' => $request->get("ma_tinhthanh"),
        );
        $uri = config('url.api_lay_danh_sach_phuong_xa');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }

    public function themPhuongXa(Request $request)
    {
        Log::info("param là:");
        $params = array(
            'ma' => $request->get("ma_phuongxa"),
            'ten' => $request->get("ten_phuongxa"),
            'maQuanHuyen' => $request->get("ma_quanhuyen"),
            'slTo' => $request->get("soluong_to"),
        );
        Log::info($params);
        $uri = config('url.api_them_danh_sach_phuong_xa');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaPhuongXa(Request $request)
    {
        $params = array(
            'ma' => $request->get("ma_phuongxa"),
            'ten' => $request->get("ten_phuongxa"),
            'maQuanHuyen' => $request->get("ma_quanhuyen"),
            'trangThai' => $request->get("trangThai"),
            'slTo' => $request->get("soluong_to"),
        );
        $uri = config('url.api_chinh_sua_danh_tinh_phuong_xa');
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }


//    Danh mục - chuyên ngành đào tạo
    public function getListChuyenNganhDaoTao(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_chuyennganh"),
            'ma' => $request->get("ma_chuyennganh"),
            'trangthai' => $request->get("trangThai"),
        );
        Log::info($params);
        $uri = config('url.api_lay_danh_sach_chuyen_nganh_dao_tao');
        Log::info("Lấy danh sách chuyên ngành đào tạo:");
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themChuyenNganhDaoTao(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'ma' => $request->get("ma_chuyennganh"),
            'ten' => $request->get("ten_chuyennganh"),
        );
        $uri = config('url.api_them_danh_sach_chuyen_nganh_dao_tao');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaChuyenNganhDaoTao(Request $request)
    {
        $params = array(
            'ma' => $request->get("ma_chuyennganh"),
            'ten' => $request->get("ten_chuyennganh"),
            'trangThai' => $request->get("trangThai"),
        );
        Log::info('lấy danh sách chuyên ngành đào tạo');
        Log::info($params);
        $uri = config('url.api_chinh_sua_danh_sach_chuyen_nganh_dao_tao');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

//Danh mục - Lý do bỏ học
    public function getListLyDoBoHoc(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_lydo"),
            'ma' => $request->get("ma_lydo"),
            'trangthai' => $request->get("trangThai"),
        );
        $uri = config('url.api_lay_danh_sach_ly_do_bo_hoc');
        Log::info("Lấy danh sách lý do bỏ học:");
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themLyDoBoHoc(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'ma' => $request->get("ma_lydo"),
            'ten' => $request->get("ten_lydo"),
        );
        $uri = config('url.api_them_danh_sach_ly_do_bo_hoc');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaLyDoBoHoc(Request $request)
    {
        $params = array(
            'ma' => $request->get("ma_lydo"),
            'ten' => $request->get("ten_lydo"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_ly_do_bo_hoc');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

//    Danh mục - đối tượng chính sách

    public function getListDoiTuongChinhSach(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_doituong"),
            'ma' => $request->get("ma_doituong"),
            'trangthai' => $request->get("trangThai"),
        );
        $uri = config('url.api_lay_danh_sach_doi_tuong_chinh_sach');
        Log::info("Lấy danh sách lý do bỏ học:");
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themDoiTuongChinhSach(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'ma' => $request->get("ma_doituong"),
            'ten' => $request->get("ten_doituong"),
        );
        $uri = config('url.api_them_danh_sach_doi_tuong_chinh_sach');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaDoiTuongChinhSach(Request $request)
    {
        $params = array(
            'ma' => $request->get("ma_doituong"),
            'ten' => $request->get("ten_doituong"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_doi_tuong_chinh_sach');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

//Danh mục - môn học
    public function getListMonHoc(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_mon"),
            'ma' => $request->get("ma_mon"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_lay_danh_sach_mon_hoc');
        Log::info("Lấy danh sách môn học:");
        $resp = $this->helper->doGet($uri, $params);
//        Log::info($resp);
        return json_encode($resp);
    }

    public function themMonHoc(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'ma' => $request->get("ma_monhoc"),
            'ten' => $request->get("ten_monhoc"),
            'tenVietTat' => $request->get("ten_viettat"),
            'tiengDanToc' => $request->get("tieng_dan_toc"),
            'ngoaiNgu' => $request->get("mon_ngoai_ngu"),
            'monNghe' => $request->get("mon_nghe"),
            'nhomNghe' => $request->get("nhom_nghe"),
            'mienGiam' => $request->get("mien_giam"),
            'thucHanh' => $request->get("thuc_hanh"),
            'capHoc' => $request->get("caphoc"),
            'loaiDanhGia' => $request->get("loai_danh_gia"),
        );
        $uri = config('url.api_them_danh_sach_mon_hoc');
        $resp = $this->helper->doPost($uri, $params);
        Log::info($params);
        return json_encode($resp);
    }

    public function chinhSuaMonHoc(Request $request)
    {
        $params = array(
            'ma' => $request->get("ma_monhoc"),
            'ten' => $request->get("ten_monhoc"),
            'tenVietTat' => $request->get("ten_viettat"),
            'tiengDanToc' => $request->get("tieng_dan_toc"),
            'ngoaiNgu' => $request->get("mon_ngoai_ngu"),
            'monNghe' => $request->get("mon_nghe"),
            'nhomNghe' => $request->get("nhom_nghe"),
            'mienGiam' => $request->get("mien_giam"),
            'thucHanh' => $request->get("thuc_hanh"),
            'capHoc' => $request->get("caphoc"),
            'loaiDanhGia' => $request->get("loai_danh_gia"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_mon_hoc');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

//Danh mục - Loại đối tượng
    public function getListLoaiDoiTuong(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_doituong"),
            'ma' => $request->get("ma_doituong"),
            'trangthai' => $request->get("trangThai"),
        );
        $uri = config('url.api_lay_danh_sach_loai_doi_tuong');
        Log::info("Lấy danh sách loại đối tượng:");
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themLoaiDoiTuong(Request $request)
    {
        Log::info($request->all());
        $params = array(
            'ma' => $request->get("ma_doituong"),
            'ten' => $request->get("ten_doituong"),
            'type' => $request->get("ten_bang")
        );
        $uri = config('url.api_them_danh_sach_loai_doi_tuong');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaLoaiDoiTuong(Request $request)
    {
        $params = array(
            'ma' => $request->get("ma_doituong"),
            'ten' => $request->get("ten_doituong"),
            'trangThai' => $request->get("trangThai"),
            'type' =>$request->get("ten_bang")
        );
        $uri = config('url.api_chinh_sua_danh_sach_loai_doi_tuong');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

//    Danh mục - Lĩnh Vực đánh giá và phát triển
    public function getListLinhVucDGPT(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_linhvuc"),
            'ma' => $request->get("ma_linhvuc"),
            'caphoc' => $request->get("caphoc"),
            'khoihoc' => $request->get("khoihoc"),
            'trangthai' => $request->get("trangThai"),
        );
        $uri = config('url.api_lay_danh_sach_linh_vuc_danh_gia_phat_trien');
        Log::info("Lấy danh sách loại đối tượng:");
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themLinhVucDGPT(Request $request)
    {
        Log::info("thêm lĩnh vực");
        $params = array(
            'ma' => $request->get("ma_linhvuc"),
            'ten' => $request->get("ten_linhvuc"),
            'capHoc' => $request->get("caphoc"),
            'khoiHoc' => $request->get("khoihoc"),
        );
        $uri = config('url.api_them_danh_sach_linh_vuc_danh_gia_phat_trien');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaLinhVucDGPT(Request $request)
    {
        $params = array(
            'ma' => $request->get("ma_linhvuc"),
            'ten' => $request->get("ten_linhvuc"),
            'capHoc' => $request->get("caphoc"),
            'khoiHoc' => $request->get("khoihoc"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_linh_vuc_danh_gia_phat_trien');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

//    Danh mục - chỉ số đánh giá và phát triển

    public function getListChiSoDGPT(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_chiso"),
            'ma' => $request->get("ma_chiso"),
            'caphoc' => $request->get("caphoc"),
            'khoihoc' => $request->get("khoihoc"),
            'trangthai' => $request->get("trangThai"),
        );
        $uri = config('url.api_lay_danh_sach_chi_so_danh_gia_phat_trien');
        Log::info("Lấy danh sách loại đối tượng:");
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themChiSoDGPT(Request $request)
    {
        Log::info("thêm lĩnh vực");
        $params = array(
            'maLinhVuc' => $request->get("ma_linhvuc"),
            'ma' => $request->get("ma_chiso"),
            'ten' => $request->get("ten_chiso"),
            'capHoc' => $request->get("caphoc"),
            'khoiHoc' => $request->get("khoihoc"),
        );
        $uri = config('url.api_them_danh_sach_chi_so_danh_gia_phat_trien');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaChiSoDGPT(Request $request)
    {
        Log::info("Chỉnh sửa chỉ số");
        $params = array(
            'maLinhVuc' => $request->get("ma_linhvuc"),
            'ten' => $request->get("ten_chiso"),
            'ma' => $request->get("ma_chiso"),
            'capHoc' => $request->get("caphoc"),
            'khoiHoc' => $request->get("khoihoc"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_chi_so_danh_gia_phat_trien');
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }

//    Danh mục - chuẩn chiều cao cân nặng
    public function getListChuanCCCN(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_chiso"),
            'ma' => $request->get("ma_chiso"),
            'caphoc' => $request->get("caphoc"),
            'khoihoc' => $request->get("khoihoc"),
            'trangthai' => $request->get("trangThai"),
        );
        $uri = config('url.api_lay_danh_sach_chuan_chieu_cao_can_nang');
        Log::info("Lấy danh sách loại đối tượng:");
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themChuanCCCN(Request $request)
    {
        Log::info("thêm chuẩn chiều cao cân nặng");
        $params = array(
            'ma' => $request->get("ma_tieuchuan"),
            'loai' => $request->get("loai_tieuchuan"),
            'standardSub3' => $request->get("standardSub3"),
            'standardSub2' => $request->get("standardSub2"),
            'standardSub1' => $request->get("standardSub1"),
            'standard0' => $request->get("standard0"),
            'standard1' => $request->get("standard1"),
            'standard2' => $request->get("standard2"),
            'standard3' => $request->get("standard3"),
            'thang' => $request->get("thang"),
        );
        $uri = config('url.api_them_danh_sach_chuan_chieu_cao_can_nang');
        $resp = $this->helper->doPost($uri, $params);
        Log::info($params);
        return json_encode($resp);
    }

    public function chinhSuaChuanCCCN(Request $request)
    {
        Log::info("Chỉnh sửa chuẩn chiều cao cân nặng");
        $params = array(
            'ma' => $request->get("ma_tieuchuan"),
            'loai' => $request->get("loai_tieuchuan"),
            'standardSub3' => $request->get("standardSub3"),
            'standardSub2' => $request->get("standardSub2"),
            'standardSub1' => $request->get("standardSub1"),
            'standard0' => $request->get("standard0"),
            'standard1' => $request->get("standard1"),
            'standard2' => $request->get("standard2"),
            'standard3' => $request->get("standard3"),
            'thang' => $request->get("thang"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_chuan_chieu_cao_can_nang');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($params);
        return json_encode($resp);
    }

//    Danh mục - Đơn vị
    public function getListDonVi(Request $request)
    {
        Log::info("lấy đơn vị");
        Log::info($request->all());
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_chiso"),
            'ma' => $request->get("ma_chiso"),
            'caphoc' => $request->get("caphoc"),
            'maTinhThanh' => $request->get("maSo"),
            'khoihoc' => $request->get("khoihoc"),
            'trangthai' => $request->get("trangThai"),
        );
        Log::info($params);
        $uri = config('url.api_lay_danh_sach_don_vi');
        Log::info("Lấy danh sách đơn vị:");
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }

//    Danh mục - tổ thôn

    public function getListToThon(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_tothon"),
            'ma' => $request->get("ma_tothon"),
            'trangthai' => $request->get("trangThai"),
        );
        $uri = config('url.api_lay_danh_sach_to_thon');
        Log::info("Lấy danh sách loại đối tượng:");
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themToThon(Request $request)
    {
        Log::info("thêm tổ thôn");
        $params = array(
            'maToThon' => $request->get("ma_tothon"),
            'tenToThon' => $request->get("ten_tothon"),
            'maPhuongXa' => $request->get("ma_phuongxa"),
        );
        $uri = config('url.api_them_danh_sach_to_thon');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaToThon(Request $request)
    {
        Log::info("Chỉnh sửa chuẩn chiều cao cân nặng");
        $params = array(
            'maToThon' => $request->get("ma_tothon"),
            'tenToThon' => $request->get("ten_tothon"),
            'maPhuongXa' => $request->get("ma_phuongxa"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_danh_sach_to_thon');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($params);
        return json_encode($resp);
    }

//    Danh mục - trường học
    public function getListTruongHoc(Request $request)
    {
        Log::info("Lấy danh sách trường học:");
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'ten' => $request->get("ten_truonghoc"),
            'ma' => $request->get("ma_truonghoc"),
            'idso' => $request->get("maSo"),
            'trangthai' => $request->get("trangThai"),
        );
        $uri = config('url.api_lay_danh_sach_truong_hoc');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }

//    Đối tác
    public function themDoiTac(Request $request)
    {
        $params = array(
            'maDoiTac' => $request->get("maDoiTac"),
            'matKhau' => $request->get("matKhau"),
            'tenDangNhap' => $request->get("tenDangNhap"),
            'tenDoiTac' => $request->get("tenDoiTac"),
            'trangThai' => $request->get("trangThai"),
            'whileListIp' => $request->get("whileListIp"),
            'maService' => $request->get("maService"),
            'email' => $request->get("email"),
        );
        $uri = config('url.api_them_doi_tac');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaDoiTac(Request $request)
    {
        Log::info("Chỉnh sửa đối tác");
        $params = array(
            'maDoiTac' => $request->get("maDoiTac"),
            'maService' => $request->get("maService"),
            'matKhau' => $request->get("matKhau"),
            'tenDangNhap' => $request->get("trangThai"),
            'email' => $request->get("email"),
            'tenDoiTac' => $request->get("tenDoiTac"),
            'trangThai' => $request->get("trangThai"),
            'whileListIp' => $request->get("whileListIp"),
        );
        $uri = config('url.api_chinh_sua_doi_tac');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaDoiTac(Request $request)
    {
        $params = array(
            'id' => $request->get("id"),
        );
        $uri = config('url.api_xoa_doi_tac');
        $uri .= "?id=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaLyDoBoHoc(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_ly_do_bo_hoc');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }
    public function xoaDonVi(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_don_vi');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaTruongHoc(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_truong_hoc');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }
    public function xoaCanBoPhongSo(Request $request)
    {
        $params = array(
            'maCanBo' => $request->get("maCanBo"),
        );
        $uri = config('url.api_xoa_can_bo_phong_so');
        $uri .= "?maCanBo=" . $request->get("maCanBo");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaMOnHoc(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_mon_hoc');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaTinhThanh(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_tinh_thanh');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaQuanHuyen(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_quan_huyen');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaPhuongXa(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_phuong_xa');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaToThon(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_to_thon');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaDanToc(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_dan_toc');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaTonGiao(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_ton_giao');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }
    public function xoaYeuCauDongBoDuLieu(Request $request)
    {
        $params = array(
            'idXoa' => $request->get("idXoa"),
        );
        $id = $request->get("idXoa");
        $uri = config('url.api_xoa_yeu_cau_dong_bo_du_lieu').$id;
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaChuyenNganhDaoTao(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_chuyen_nganh_dao_tao');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaDoiTuongChinhSach(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_doi_tuong_chinh_sach');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaLoaiDoiTuong(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_loai_doi_tuong');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaLinhVucDanhGia(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_linh_vuc_danh_gia');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaChiSoDanhGiaPT(Request $request)
    {
        Log::info("qưertyu");
        Log::info($request->all());
        Log::info("xóa lý do bỏ học");
        $params = array(
            'ma' => $request->get("id"),
        );
        $uri = config('url.api_xoa_chi_so_danh_gia_phat_trien');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaChuanChieuCaoCanNang(Request $request)
    {
        Log::info($request->all());
//        $params = array(
//            'ma' => $request->get("id"),
//        );
        $uri = config('url.api_xoa_chuan_chieu_cao_can_nang');
        $uri .= "?ma=" . $request->get("id");
        $resp = $this->helper->doDelete($uri,[]);
        Log::info($resp);
        return json_encode($resp);
    }

    public function themDonVi(Request $request)
    {
        $params = array(
            'address' => $request->get("diachi_donvi"),
            'donViQuanLy' => $request->get("donvi_quanly"),
            'email' => $request->get("email_donvi"),
            'loaiDonVi' => $request->get("loai_donvi"),
            'ma' => $request->get("ma_donvi"),
            'maDonViCha' => $request->get("don_vi_cha"),
            'maPhuongXa' => $request->get("ma_phuong_xa"),
            'maQuanHuyen' => $request->get("ma_quan_huyen"),
            'maTinhThanh' => $request->get("ma_tinh_thanh"),
            'maToThon' => $request->get("ma_to_thon"),
//            'maToThon' => 012,
            'soDienThoai' => $request->get("sdt_donvi"),
            'ten' => $request->get("ten_donvi"),
//            'trangThai' => $request->get("diachi_donvi"),
            'trangThai' => 0,
            'website' => $request->get("website_donvi"),
        );
        Log::info($params);
        $uri = config('url.api_them_don_vi');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

//    Import danh mục

    private function getDefaultParams()
    {
        $defaults = array();
        if (is_login()) {
            $defaults["token"] = get_user_info("token");
//            $defaults['Content-Type'] = 'multipart/form-data';
            Log::info("Token: " . get_user_info("token"));
        }
        return $defaults;
    }


    public function ImportTruongHoc(Request $request)
    {
        Log::info("ImportTruongHoc:");
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_truong_hoc');
        Log::info($uri);
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        
        Log::info("response");
        Log::info(json_encode($response));
        return json_encode($response->getBody()->getContents());
    }

    public function ImportMonHoc(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_mon_hoc');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }
    public function ImportGoiCuocCA(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_goi_cuoc_ca');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportTinhThanh(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_tinh_thanh');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportQuanHuyen(Request $request)
    {
        Log::info("ImportQuanHuyen");
        Log::info("Request data: " . json_encode($request->all()));
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        
        if ($request->hasFile('file')) {
            Log::info("File found in request");
            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $file_size = $file->getSize();
            
            Log::info("File details - Name: {$file_name}, Path: {$file_path}, Size: {$file_size} bytes");
            
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        } else {
            Log::warning("No file found in request");
        }
        
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
                Log::info("Prepared file for upload: " . strtolower($file['name']));
            }
        }
        
        $uri = config('url.api_import_quan_huyen');
        $header = $this->getDefaultParams();
        
        Log::info("API URI: " . $uri);
        Log::info("Headers: " . json_encode($header));
        Log::info("Data upload count: " . count($dataUpload));

        try {
            $response = $client->post($uri, [
                'multipart' => $dataUpload,
                'headers' => $header,
            ]);
            
            Log::info("Response status: " . $response->getStatusCode());
            Log::info("Response headers: " . json_encode($response->getHeaders()));
            $responseBody = $response->getBody()->getContents();
            Log::info("Response body: " . $responseBody);
            
            return json_encode($responseBody);
            
        } catch (\Exception $e) {
            Log::error("Error in ImportQuanHuyen: " . $e->getMessage());
            Log::error("Error trace: " . $e->getTraceAsString());
            return json_encode([
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    public function ImportPhuongXa(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_phuong_xa');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportToThon(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_to_thon');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportDanToc(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_dan_toc');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }
    public function ImportTonGiao(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_ton_giao');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportChuyenNganhDaotao(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_chuyen_nganh_dao_tao');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }
    public function ChinhSuaYeuCauNopThongKeTheoBieuMau(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        Log::info("1234567890");
        if ($request->hasFile('file')) {
            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }

        Log::info("đến fo each");
        Log::info($request->all());
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        Log::info($dataUpload);
        $uri = config('url.api_import_file_yeu_cau_thong_ke_theo_bieu_mau');
        $header = $this->getDefaultParams();

        try{
            $response = $client->post($uri.'?id='.$request->id, [
                'multipart' => $dataUpload,
                'headers' => $header,
            ]);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return $e->getMessage();
        }
        Log::info($uri.'?namHoc='.$request->namHoc);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportDuLieuGiaoVienSSO(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
            if ($request->hasFile('file')) {
                $prepareFiles = [];
                $file = $request->file('file');
                $file_name = $file->getClientOriginalName();
                $file_path = $file->getRealPath();
                $upload = array(
                    'name' => $file_name,
                    'path' => $file_path,
                );
                $prepareFiles[] = $upload;
            }
            foreach ($prepareFiles as $file) {
                if (array_key_exists('path', $file)) {
                    $upload = array(
                        'name' => 'file',
                        'contents' => fopen($file['path'], 'r'),
                        'filename' => strtolower($file['name']),
                    );
                    $dataUpload[] = $upload;
                }
            }
            Log::info($dataUpload);
        $uri = config('url.api_import_du_lieu_giao_vien_sso');
        $header = $this->getDefaultParams();
        try{
            $response = $client->post($uri.'?namHoc='.$request->namHoc, [
                'multipart' => $dataUpload,
                'headers' => $header,
            ]);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return $e->getMessage();
        }
        Log::info($uri.'?namHoc='.$request->namHoc);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportDuLieuCanBoPhongSoSSO(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
            Log::info("1234567890");
            if ($request->hasFile('file')) {
                $prepareFiles = [];
                $file = $request->file('file');
                $file_name = $file->getClientOriginalName();
                $file_path = $file->getRealPath();
                $upload = array(
                    'name' => $file_name,
                    'path' => $file_path,
                );
                $prepareFiles[] = $upload;
            }
            foreach ($prepareFiles as $file) {
                if (array_key_exists('path', $file)) {
                    $upload = array(
                        'name' => 'file',
                        'contents' => fopen($file['path'], 'r'),
                        'filename' => strtolower($file['name']),
                    );
                    $dataUpload[] = $upload;
                }
            }
            Log::info($dataUpload);
        $uri = config('url.api_import_du_lieu_can_bo_phong_so_sso');
        $header = $this->getDefaultParams();
        try{
            $response = $client->post($uri.'?namHoc='.$request->namHoc, [
                'multipart' => $dataUpload,
                'headers' => $header,
            ]);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return $e->getMessage();
        }
        Log::info($uri.'?namHoc='.$request->namHoc);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportDuLieuHocSinhSSO(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        Log::info("1234567890");
        if ($request->hasFile('file')) {
            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        Log::info($dataUpload);
        $uri = config('url.api_import_du_lieu_hoc_sinh_sso');
        $header = $this->getDefaultParams();

        try{
            $response = $client->post($uri.'?namHoc='.$request->namHoc, [
                'multipart' => $dataUpload,
                'headers' => $header,
            ]);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return $e->getMessage();
        }
        Log::info($uri.'?namHoc='.$request->namHoc);
        return json_encode($response->getBody()->getContents());
    }


    public function ImportDoiTuongChinhSach(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_doi_tuong_chinh_sach');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportLyDoBoHoc(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_ly_do_bo_hoc');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportLoaiDoiTuong(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_loai_doi_tuong');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportLinhVucDanhGiaPhatTrien(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_linh_vuc_danh_gia_phat_trien');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function ImportChiSoDanhGiaPhatTrien(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_chi_so_danh_gia_phat_trien');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }
    public function ImportMatKhauKetChuyen(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_mat_khau_ket_chuyen');
        Log::info("import:");
        Log::info($uri);
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }
    public function ImportMatKhauKetChuyenIoc(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_mat_khau_ket_chuyen_ioc');
        Log::info("import:");
        Log::info($uri);
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }
    public function ImportChuanChieuCaoCanNang(Request $request)
    {
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_chuan_chieu_cao_can_nang');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }
    public function ImportDonVi(Request $request){
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
        if ($request->hasFile('file')) {

            $prepareFiles = [];
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file_path = $file->getRealPath();
            $upload = array(
                'name' => $file_name,
                'path' => $file_path,
            );
            $prepareFiles[] = $upload;
        }
        foreach ($prepareFiles as $file) {
            if (array_key_exists('path', $file)) {
                $upload = array(
                    'name' => 'file',
                    'contents' => fopen($file['path'], 'r'),
                    'filename' => strtolower($file['name']),
                );
                $dataUpload[] = $upload;
            }
        }
        $uri = config('url.api_import_don_vi');
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }
    public function chinhSuaDonVi(Request $request){
        Log::info("Chỉnh sửa đơn vị");
        $params = array(
              "address"=> $request->address,
              "donViQuanLy"=> $request->donViQuanLy,
              "email"=> $request->email,
              "loaiDonVi"=> $request->loaiDonVi,
              "ma"=> $request->ma,
              "maDonViCha"=> $request->maDonViCha,
              "maPhuongXa"=> $request->maPhuongXa,
              "maQuanHuyen"=> $request->maQuanHuyen,
              "maTinhThanh"=> $request->maTinhThanh,
              "maToThon"=> $request->maToThon,
              "soDienThoai"=> $request->soDienThoai,
              "ten"=> $request->ten,
              "trangThai"=> $request->trangThai,
              "website"=> $request->website
        );
        $uri = config('url.api_chinh_sua_don_vi');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($params);
        return json_encode($resp);
    }

    public function chinhSuaTruongHoc(Request $request){
        $params = array(
            // "capHoc"=> $request->capHoc,
            "capHocs"=> $request->capHocs,
            "chiBoDang"=> $request->chiBoDang,
            "chuanQuocGia"=> $request->chuanQuocGia,
            "diaChi"=> $request->diaChi,
            "email"=> $request->email,
            "fax"=> $request->fax,
            "idPhong"=> $request->idPhong,
            "idSo"=> $request->idSo,
            "loaiHinhDaoTao"=> $request->loaiHinhDaoTao,
            "loaiHinhTruong"=> $request->loaiHinhTruong,
            "ma"=> $request->ma,
            "maDonVi"=> $request->maDonVi,
            "maPhuongXa"=> $request->maPhuongXa,
            "maQuanHuyen"=> $request->maQuanHuyen,
            "maTinhThanh"=> $request->maTinhThanh,
            "maToThon"=> $request->maToThon,
            "ngayThanhLap"=> $request->ngayThanhLap,
            "sdt"=> $request->sdt,
            "tenHieuTruong"=> $request->tenHieuTruong,
            "ten"=> $request->ten,
            "trangThai"=> $request->trangThai,
            "vungBienGioi"=> $request->vungBienGioi,
            "vungKhoKhan"=> $request->vungKhoKhan,
            "website"=> $request->website
        );
        $uri = config('url.api_chinh_sua_truong_hoc');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($params);
        return json_encode($resp);
    }
}
