<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class ImportDataMoetController extends BaseController
{


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
    public function ImportDuLieuMoetBuocMot(Request $request)
    {
        if($request->hasFile('file'))
        {
            $ngay = Carbon::now()->day;
            if($ngay<10){
                $ngay = '0'.$ngay;
            };
            $thang = Carbon::now()->month;
            if($thang<10){
                $thang = '0'.$thang;
            }
            $nam = Carbon::now()->year;
         $file = $request->file('file');
         $fileName = $ngay.$thang.$nam.'-'.str_random(6).'-'.$file->getClientOriginalName();
         $file->move('uploadExcel', $fileName);
         $res = [
            'rc' => 0,
            'rd' => '',
            'file' => 'uploadExcel/'.$fileName
        ];
         return json_encode($res);
        }

        return;
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
            Log::info("Import bước 1");
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
        $uri = config('url.api_import_buoc_mot_du_lieu_moet');
        $header = $this->getDefaultParams();
        try{
            $response = $client->post($uri, [
                'multipart' => $dataUpload,
                'headers' => $header,
            ]);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return $e->getMessage();
        }
        Log::info($uri);
        return json_encode($response->getBody()->getContents());
    }
    public function ImportBaoCaoDong(Request $request)
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
        $uri = config('url.api_import_bao_cao_dong');
        Log::info("import:");
        Log::info($uri);
        $header = $this->getDefaultParams();

        $response = $client->post($uri, [
            'multipart' => $dataUpload,
            'headers' => $header,
        ]);
        return json_encode($response->getBody()->getContents());
    }

    public function layDanhSachTieuChi(Request $request)
    {
        $tieuChiHeThong = null;
        if($request->get("TieuChiHeThong")==1&&$request->get("tieuChiNguoiDung")==0){
            $tieuChiHeThong = true;
        }
        if($request->get("TieuChiHeThong")==0&&$request->get("tieuChiNguoiDung")==1){
            $tieuChiHeThong = false;
        }
        $params = array(
            'doiTuong' => $request->get("theLoai"),
            'textSreach' =>$request->get("search"),
            'tieuChiHeThong' =>$tieuChiHeThong
        );
        $uri = config('url.api_lay_danh_sach_tieu_chi_bao_cao');
        $url = $uri.'?skip=0&limit=2000';
        Log::info($url);
        $resp = $this->helper->doPost($url, $params);

        return json_encode($resp);
    }
    public function layChiTietTieuChi(Request $request)
    {

        $params = array(
            'maBcChiTiet' => $request->get("maBcChiTiet"),
        );
        $uri = config('url.api_lay_chi_tiet_tieu_chi');
        Log::info("Lấy chi tiết tiêu chí:");
        $resp = $this->helper->doGet($uri, $params);

        return json_encode($resp);
    }
    public function layChiTietTieuChiHtml(Request $request)
    {
        $params = array(
            'id' => $request->get("id"),
        );
        $uri = config('url.api_lay_chi_tiet_tieu_chi_html');
        $resp = $this->helper->doGet($uri, $params);
        Log::info("Lấy html:");
        Log::info($params);

        return json_encode($resp);
    }function htmlspecialchars_custom($string)
    {
      $string = str_replace("\x05\x06", "", $string);
      $string = preg_replace("/&([a-z\d]{2,7}|#\d{2,5});/i", "\x05\x06$1", $string);
      $string = htmlspecialchars($string, ENT_QUOTES);
      $string = str_replace("\x05\x06", "&", $string);

      return $string;
    }
    public function chinhSuaTemplate(Request $request)
    {
        Log::info($request->all());
        $idBaoCao = $request->id;
        $dataHtml = $request->session()->get('dataHtml');
        // dd($dataHtml);
    if(env('BAO_TRI')){
        return view("content.baotri");
    }

    // return view("baocaodong.chinhsuatemplatebaocao",compact('dataHtml','idBaoCao'));
    // return view("baocaodong.index",compact('dataHtml','idBaoCao'));
    return view("baocaodong.chinhsuatemplate",compact('dataHtml','idBaoCao'));
    }
    public function chinhSuaTemplate2(Request $request)
    {

        Log::info("Lấy html:");
        $dataHtml=$request->dataHtml;
        Session::put('dataHtml', $dataHtml);
        return response()->json(array(
            'code'=>'0',
            'msg'=>'Done'
        ));
        $codeview = $header.$dataHtml.$footer;
        echo ($codeview);

        return response()->json($res);
    }
    public function postChinhSuaTemplate(Request $request)
    {
        $id = $request->get("id");
        $danhSachTieuChi = $request->get("danhSachTieuChi");
        $dm = json_decode($danhSachTieuChi);
        Log::info($dm);
        // return;

        $params = array(
            'id' => $id,
            'danhSachTieuChi' => $dm
        );
        Log::info("Update template");
        Log::info($params);
        $uri = config('url.api_update_chi_tiet_tieu_chi_html');
        $resp = $this->helper->doPost($uri, $params);

        return json_encode($resp);
    }
    public function PostThemTieuChi(Request $request){

        $params=$request->all();
        $rule = $request->get('filters');
        $params['filters'] = json_decode($rule);
        Log::info("PostThemTieuChi params:");
        Log::info($params);
        $uri = config('url.api_them_tieu_chi');
        $resp = $this->helper->doPost($uri, $params);

        return json_encode($resp);
    }
    public function PostChinhSuaTieuChi(Request $request){
        $params = $request->all();
        $rule = $request->get('filters');
        $params['filters'] = json_decode($rule);
        $uri = config('url.api_chinh_sua_tieu_chi');
        Log::info("PostChinhSuaTieuChi params:");
        Log::info($params);
        $resp = $this->helper->doPost($uri,$params);
        return json_encode($resp);
    }
    public function layDanhSachSmeTheoDoiTuong(Request $request){
        $params = array(
            'doiTuong' => $request->get("doiTuongApDung"),
        );
        $uri = config('url.api-lay-danh-sach-sme-theo-doi-tuong');
        $resp = $this->helper->doGet($uri, $params);

        return json_encode($resp);
    }
    public function LayDuLieuIOCTheoKhuVuc(Request $request){
        $params = $request->all();
        Log::info("Lấy dữ liệu IOC:");
        Log::info($params);
        $uri = config('url.api-lay-du-lieu-ioc');
        $resp = $this->helper->doPost($uri, $params);

        return json_encode($resp);
    }
    public function LayToanBoDanhSachSmeMoetCode(Request $request){
        $params = array(
            'type' => $request->get("type"),
        );
        $uri = config('url.api-lay-toan-bo-danh-sach-sme-moetCode');
        $resp = $this->helper->doPost($uri, $params);

        return json_encode($resp);
    }
    public function LayToanBoDanhSachSmeMappingCode(Request $request){
        $params = array(
            'type' => $request->get("type"),
        );
        $uri = config('url.api-lay-toan-bo-danh-sach-sme-mappingCode');
        $resp = $this->helper->doPost($uri, $params);

        return json_encode($resp);
    }
    public function layThongTinTieuChi(Request $request){

        Log::info("Lấy thông tin tiêu chí:");
        Log::info($request->all());
        $params = array(
            'maBcChiTiet' => $request->get("idTieuChi"),
        );
        $uri = config('url.api_lay_thong_tin_tieu_chi');
        Log::info($uri);
        $resp = $this->helper->doGet($uri, $params);

        Log::info($resp);
        return json_encode($resp);
    }
    public function nopBieuMauTkPhongSo(Request $request){

        if($request->hasFile('file'))
        {
            $header = $this->getDefaultParams();
            $url = '';
            $type =$request->get("type");
            if($type==1){
                $url = config('app.base_url_api'). '/csdlgd-admin/nop-bieu-mau/upload';//nop-bieu-mau/upload up file biểu mẫu 
                
                $id = $request->get("id");
                $maDonVi = $request->get("maDonVi");
                $userId = $request->get("userId");
                $roleId = $request->get("roleId");
                $maSo = $request->get("maSo");
                $url = $url.'?id='.$id.'&maDonVi='.$maDonVi.'&userId='.$userId.'&roleId='.$roleId.'&maSo='.$maSo;
            }
            if($type==2){
                $url = config('app.base_url_api'). '/csdlgd-admin/nop-bieu-mau/truong-nop-bc';//nop-bieu-mau/truong-nop-bc - nộp dữ liệu
                $id = $request->get("id");
                $maTruongHoc = $request->get("maTruongHoc");
                $maPhong = $request->get("maPhong");
                $roleId = $request->get("roleId");
                $url = $url.'?id='.$id.'&maTruongHoc='.$maTruongHoc.'&maPhong='.$maPhong.'&roleId='.$roleId;
            }

            $file               = request('file');
            $file_path          = $file->getPathname();
            $file_uploaded_name = $file->getClientOriginalName();
            $client = new Client();
                try {
                    $response = $client->request("POST", $url, [

                        'headers' => $header,
                        'multipart' => [
                            [
                                'name'      => 'file',
                                'filename' => $file_uploaded_name,
                                'Mime-Type'=> 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'contents' => fopen($file_path, 'r'),
                            ],
                            ]
                    ]);
                } catch (Exception $e) {
                }

            $code   = $response->getStatusCode();
            $response   = $response->getBody();

            $responseData = json_decode($response, true);
            return $response;
        }

        return;
        $client = new Client();
        $header = null;
        $dataUpload = array();
        $prepareFiles = null;
            Log::info("Import bước 1");
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
        $uri = config('url.api_import_buoc_mot_du_lieu_moet');
        $header = $this->getDefaultParams();
        try{
            $response = $client->post($uri, [
                'multipart' => $dataUpload,
                'headers' => $header,
            ]);
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return $e->getMessage();
        }
        Log::info($uri);
        return json_encode($response->getBody()->getContents());
    }
}
