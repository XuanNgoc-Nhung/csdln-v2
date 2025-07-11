<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AdminApiController extends BaseController
{
    public function LayMatKhauKetChuyen(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' =>$request->get("limit"),
            'capHoc' =>$request->get("capHoc"),
            'maTinhThanh' =>$request->get("maTinhThanh"),
            'maDonVi' =>$request->get("maDonVi"),
            'maTruongHoc' =>$request->get("maTruongHoc"),
        );
        Log::info("params:");
        Log::info($params);
        $uri = config('url.api_lay_mat_khau_ket_chuyen');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }
    
    public function NhapLieuDuLieuNamHocCu(Request $request)
    {
        Log::info($request->all());
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

    public function LayThongTinKetChuyenDuLieu(Request $request)
    {
        $params = array(
            'maTruongHoc' => $request->get("maTruongHoc"),
            'namHoc' => $request->get("namHoc"),
        );
        Log::info($params);
        $uri = config('url.api_lay_thong_tin_ket_chuyen');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }
    public function getListStudent(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'maPhongs' => $request->get("maPhongs"),
            'capHocs' => $request->get("capHocs"),
            'gioiTinh' => $request->get("gioiTinh"),
            'keyword' => $request->get("keyword"),
            'maTruongHocs' => $request->get("maTruongHocs"),
            'namHoc' => (int)$request->get("namHoc"),
            'trangThai' => $request->get("trangThai"),
        );
        Log::info($params);
        $uri = config('url.api_lay_danh_sach_hoc_sinh');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    public function getListTeacher(Request $request)
    {
        Log::info("lấy danh sách giáo viên");
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'namHoc' => $request->get('namHoc'),
        );
        $uri = config('url.api_lay_danh_sach_giao_vien');
        $resp = $this->helper->doPost($uri, $params);
//        Log::info($resp);
        return json_encode($resp);
    }

    public function layThongTinGiaoVien(Request $request)
    {
        $uri = config('url.api_lay_thong_tin_giao_vien');
        $params = json_decode(json_encode($request->all()), true);
        $resp = $this->helper->doGet($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }
    public function themNguoiDung(Request $request)
    {
        $data = $request->get("params");
        $uri = config('url.api_them_nguoi_dung');
        $resp = $this->helper->doPost($uri, $data);
        Log::info($resp);
        return json_encode($resp);
    }

    public function chinhSuaNguoiDung(Request $request)
    {
       $params = array(
           'capHocList' => $request->get("capHocList"),
           'email' => $request->get("email"),
           'hoTen' => $request->get("hoTen"),
           'maDonVi' => $request->get("maDonVi"),
           'maTruongHoc' => $request->get("maTruongHoc"),
           'role' => $request->get("role"),
           'sdt' => $request->get("sdt"),
           'maSo' => $request->get("maSo"),
           'username' => $request->get("username"),
       );
        // $data = $request->get("params");
        
        Log::info($params);
        Log::info("Chỉnh sửa");
        $uri = config('url.api_chinh_sua_nguoi_dung');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);

        return json_encode($resp);
    }


    //Change pass người dùng
    public function changePassNguoiDung(Request $request){
        $data = $request->get("params");
        $uri = config('url.api_change_pass_nguoi_dung');
        $resp = $this->helper->doPut($uri, $data);
        Log::info($resp);

        return json_encode($resp);
    }


    public function chinhSuaBcdTieuChi(Request $request)
    {
        $params = array(
            'loaiTieuChi' => $request->get("loaiTieuChi"),
            'maTieuChi' => $request->get("maTieuChi"),
            'nhomTieuChiId' => $request->get("nhomTieuChiId"),
            'phanCap' => $request->get("phanCap"),
            'scriptDongBo' => $request->get("scriptDongBo"),
            'tenTieuChi' => $request->get("tenTieuChi"),
            'tieuChiBaoCaoId' => $request->get("tieuChiBaoCaoId"),
            'tieuChiChaId' => $request->get("tieuChiChaId"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.api_chinh_sua_bcd_tieu_chi');
        Log::info($params);
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }

    public function thayDoiTrangThaiNguoiDung(Request $request)
    {
        $data = $request->get("params");
        $uri = config('url.api_thay_doi_trang_thai_nguoi_dung');
        $resp = $this->helper->doPut($uri, $data);
        Log::info($resp);
        return json_encode($resp);
    }

    public function chinhSuaCauHinhEmail(Request $request)
    {
        $params = array(
            'diaChiEmail' => $request->get("diaChiEmail"),
            'hostEmail' => $request->get("hostEmail"),
            'maDonVi' => $request->get("maDonVi"),
            'maTinhThanh' => $request->get("maTinhThanh"),
            'matKhauEmail' => $request->get("matKhauEmail"),
            'portEmail' => $request->get("portEmail"),
            'tenDangNhap' => $request->get("tenDangNhap"),
            'trangThai' => $request->get("trangThai"),
            'vaiTro' => $request->get("vaiTro"),
            'ma' => $request->get("idEmail"),
        );
        $uri = config('url.api_chinh_sua_cau_hinh_email');
        Log::info($params);
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }

    public function updateNhomTieuChi(Request $request)
    {
        $params = array(
            'nhomTieuChiId' => $request->get("nhomTieuChiId"),
            'tenNhomTieuChi' => $request->get("tenNhomTieuChi"),
            'nhomTieuChiChaId' => $request->get("nhomTieuChiChaId"),
            'capNhom' => $request->get("capNhom"),
            'trangThai' => $request->get("trangThai"),
        );
        $uri = config('url.csdlgd-admin-bcdNhomTieuChi-update');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function chinhSuaCauHinhMauEmail(Request $request)
    {
        $params = array(
            'diaChiEmail' => $request->get("diaChiEmail"),
            'hostEmail' => $request->get("hostEmail"),
            'maDonVi' => $request->get("maDonVi"),
            'maTinhThanh' => $request->get("maTinhThanh"),
            'matKhauEmail' => $request->get("matKhauEmail"),
            'portEmail' => $request->get("portEmail"),
            'tenDangNhap' => $request->get("tenDangNhap"),
            'trangThai' => $request->get("trangThai"),
            'vaiTro' => $request->get("vaiTro"),
            'ma' => $request->get("idEmail"),
        );
        $uri = config('url.api_chinh_sua_cau_hinh_email');
        Log::info($params);
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }

    public function chinhSuaPhanQuyenDongBo(Request $request)
    {
        Log::info("chỉnh sửa phân quyên đồng bộ:");
        Log::info($request->all());
        $params = array(
            'id' => $request->get("id"),
            'maTruongHoc' => $request->get("maTruongHoc"),
            'trangThai' => $request->get("trangThai"),
            'toiNamHoc' => $request->get("toiNamHoc"),
            'tuNamHoc' => $request->get("tuNamHoc"),
        );
        $uri = config('url.api_chinh_sua_phan_quyen_dong_bo');
        Log::info($params);
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }

//
    public function themYeuCauDuLieuTheoTruong(Request $request)
    {
        $params = array(
            'denNgay' => $request->get("denNgay"),
            'loaiDongBo' => (int)$request->get("loaiDongBo"),
            'maTruongHoc' => $request->get("maTruongHoc"),
            'tuNgay' => $request->get("tuNgay"),
            'namHoc' => $request->get("namHoc"),
            'status' => (int)$request->get("status"),
        );
        $uri = config('url.api_them_yeu_cau_du_lieu_theo_truong');
        $resp = $this->helper->doPost($uri, $params);
        Log::info("1213213213");
        Log::info($resp);
        return json_encode($resp);
    }

    public function themYeuCauDuLieuCu(Request $request)
    {
        $params = array(
            'maTruongHoc' => $request->get("maTruongHoc"),
            'tuNamHoc' => (int)$request->get("tuNamHoc"),
            'toiNamHoc' => (int)$request->get("toiNamHoc"),
            'trangThai' => (int)$request->get("trangThai"),
        );
        $uri = config('url.api_them_yeu_cau_du_lieu_cu');
        $resp = $this->helper->doPost($uri, $params);
        Log::info($resp);
        return json_encode($resp);

    }

    public function chinhSuaYeuCauDuLieuCu(Request $request)
    {
        $params = array(
            'id' => $request->get("id"),
            'maTruongHoc' => $request->get("maTruongHoc"),
            'tuNamHoc' => (int)$request->get("tuNamHoc"),
            'toiNamHoc' => (int)$request->get("toiNamHoc"),
            'trangThai' => (int)$request->get("trangThai"),
        );
        $uri = config('url.api_sua_yeu_cau_du_lieu_cu');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);

    }

    public function chinhSuaLichDongBo(Request $request)
    {
        Log::info("chỉnh sửa lịch đồng bộ");
        Log::info($request->all());
        $params = array(
            'cuoiNamToiNgay' => $request->get("cuoiNamToiNgay"),
            'cuoiNamTuNgay' => $request->get("cuoiNamTuNgay"),
            'dauNamToiNgay' => $request->get("dauNamToiNgay"),
            'dauNamTuNgay' => $request->get("dauNamTuNgay"),
            'id' => $request->get("id"),
            'namHoc' => $request->get("namHoc"),
            'ycDbdlPhatSinhList' => $request->get("ycDbdlPhatSinhList"),
        );
        $uri = config('url.api_sua_lich_dong_bo');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }
    public function chinhSuaLichDongBoTN(Request $request)
    {
        Log::info("chỉnh sửa lịch đồng bộ");
        Log::info($request->all());
        $params = array(
            'cuoiNamToiNgay' => $request->get("cuoiNamToiNgay"),
            'cuoiNamTuNgay' => $request->get("cuoiNamTuNgay"),
            'dauNamToiNgay' => $request->get("dauNamToiNgay"),
            'dauNamTuNgay' => $request->get("dauNamTuNgay"),
            'id' => $request->get("id"),
            'namHoc' => $request->get("namHoc"),
            'ycDbdlPhatSinhList' => $request->get("ycDbdlPhatSinhList"),
        );
        $uri = config('url.api_sua_lich_dong_bo_tn');
        $resp = $this->helper->doPut($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }

    public function xoaLichDongBo(Request $request)
    {
        $params = array(
            'id' => $request->get("id"),
        );
        $uri = config('url.api_xoa_lich_dong_bo');
        $uri .= "?id=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        return json_encode($resp);
    }
    public function xoaLichDongBoTN(Request $request)
    {
        $params = array(
            'id' => $request->get("id"),
        );
        $uri = config('url.api_xoa_lich_dong_bo_tn');
        $uri .= "?id=" . $request->get("id");
        $resp = $this->helper->doDelete($uri, $params);
        return json_encode($resp);
    }
}
