<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AdminSoApiController extends BaseController
{
    public function getListDongBo(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
        );
        $uri = config('url.api_lay_danh_sach_dong_bo');
//        Log::info("Lấy danh sách yêu cầu đồng bộ:");
        $resp = $this->helper->doGet($uri, $params);
//        Log::info($resp);
        return json_encode($resp);
    }

    public function layThongTinDongBo(Request $request)
    {
        $params = array(
            'id' => $request->get("id"),
        );
        $uri = config('url.api_lay_thong_tin_dong_bo');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }

    public function themCauHinhLichDongBo(Request $request)
    {
        Log::info("Thêm cấu hình lịch đồng bộ");
        $params = array(
            'cuoiNamToiNgay' => $request->get("cuoiNamToiNgay"),
            'cuoiNamTuNgay' => $request->get("cuoiNamTuNgay"),
            'dauNamToiNgay' => $request->get("dauNamToiNgay"),
            'dauNamTuNgay' => $request->get("dauNamTuNgay"),
            'namHoc' => $request->get("namHoc"),
            'ycDbdlPhatSinhList' => $request->get("ycDbdlPhatSinhList"),
        );
        $uri = config('url.api_lay_thong_tin_dong_bo');
        $resp = $this->helper->doPost($uri, $params);
        Log::info($resp);
        return json_encode($resp);
    }
    public function xoaCauHinhLichDongBo(Request $request)
    {
        $params = array(
            'id' => $request->get("id"),
        );
        $uri = config('url.api_lay_thong_tin_dong_bo');
        $resp = $this->helper->doDelete($uri,$params);
        Log::info($resp);
        return("12");
        return json_encode($resp);
    }

//    Yêu cầu đồng bộ dữ liệu cũ


    public function getListYeuCauDuLieuCu(Request $request)
    {
        Log::info("Lấy danh sách yêu cầu đồng bộ dữ liệu cũ");
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
        );
        $uri = config('url.api_lay_danh_sach_yeu_cau_du_lieu_cu');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }
    public function ThayDoiTrangThaiYeuCauDuLieuCu(Request $request){
//        $resp = $request->all();
//        Log::info($resp);

        $data = $request->all();
        $uri = config('url.api_thay_doi_trang_thai_yeu_cau_du_lieu_cu');
        Log::info("đường dẫn:");
        Log::info($uri);
        $resp = $this->helper->doPut($uri, $data);
        Log::info($resp);
        return json_encode($resp);

    }

}
