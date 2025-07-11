<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Str;

use GuzzleHttp\Psr7\Request as GRequest;

class CSDLController extends BaseController
{
    // Biến dùng chung để kiểm soát đường dẫn lưu file
    private $fileStorageType = 'public'; // 'config', 'storage', 'public'
    
    /**
     * Constructor - đọc cấu hình từ config
     */
    public function __construct()
    {
        $this->fileStorageType = 'public';
    }

    /**
     * Helper method để lưu file theo cấu hình
     * @param string $fileName Tên file
     * @param string $content Nội dung file
     * @return string Đường dẫn đầy đủ của file
     */
    private function saveFile($fileName, $content) {
        switch ($this->fileStorageType) {
            case 'config':
                $path = config('app.path_file');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                file_put_contents($path . $fileName, $content);
                return asset('storage/exportExcel/' . $fileName); // Giả sử config path cũng accessible qua web
                break;
                
            case 'public':
                $path = public_path('exportExcel/');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                file_put_contents($path . $fileName, $content);
                return asset('exportExcel/' . $fileName);
                break;
                
            case 'storage':
            default:
                $path = storage_path('app/public/exportExcel/');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                file_put_contents($path . $fileName, $content);
                return asset('storage/exportExcel/' . $fileName);
                break;
        }
    }

    /**
     * Method để thay đổi cấu hình đường dẫn lưu file
     * @param string $storageType 'config', 'storage', 'public'
     */
    public function setFilePathConfig($storageType) {
        $allowedTypes = ['config', 'storage', 'public'];
        if (in_array($storageType, $allowedTypes)) {
            $this->fileStorageType = $storageType;
        }
    }

    /**
     * Method để lấy cấu hình hiện tại
     * @return string Loại storage hiện tại
     */
    public function getFilePathConfig() {
        return $this->fileStorageType;
    }

    /**
     * Method để kiểm tra xem thư mục lưu file có tồn tại không
     * @return bool
     */
    public function checkStorageDirectory() {
        switch ($this->fileStorageType) {
            case 'config':
                $path = config('app.path_file');
                break;
            case 'public':
                $path = public_path('exportExcel/');
                break;
            case 'storage':
            default:
                $path = storage_path('app/public/exportExcel/');
                break;
        }
        return file_exists($path) && is_dir($path);
    }

    /**
     * Method để tạo thư mục lưu file nếu chưa tồn tại
     * @return bool
     */
    public function createStorageDirectory() {
        switch ($this->fileStorageType) {
            case 'config':
                $path = config('app.path_file');
                break;
            case 'public':
                $path = public_path('exportExcel/');
                break;
            case 'storage':
            default:
                $path = storage_path('app/public/exportExcel/');
                break;
        }
        
        if (!file_exists($path)) {
            return mkdir($path, 0755, true);
        }
        return true;
    }

    /**
     * Method để lấy đường dẫn đầy đủ của thư mục lưu file
     * @return string
     */
    public function getStoragePath() {
        switch ($this->fileStorageType) {
            case 'config':
                return config('app.path_file');
            case 'public':
                return public_path('exportExcel/');
            case 'storage':
            default:
                return storage_path('app/public/exportExcel/');
        }
    }

    /**
     * Method để reset về cấu hình mặc định từ config
     */
    public function resetToDefaultConfig() {
        $this->fileStorageType = config('app.file_storage_type', 'storage');
    }

    /**
     * Method để lấy thông tin chi tiết về cấu hình hiện tại
     * @return array
     */
    public function getStorageInfo() {
        return [
            'current_type' => $this->fileStorageType,
            'default_type' => config('app.file_storage_type', 'storage'),
            'storage_path' => $this->getStoragePath(),
            'directory_exists' => $this->checkStorageDirectory(),
            'web_url' => $this->getWebUrl(),
        ];
    }

    /**
     * Method để lấy URL web của file
     * @param string $fileName Tên file (optional)
     * @return string
     */
    public function getWebUrl($fileName = '') {
        switch ($this->fileStorageType) {
            case 'config':
                return asset('storage/exportExcel/' . $fileName);
            case 'public':
                return asset('exportExcel/' . $fileName);
            case 'storage':
            default:
                return asset('storage/exportExcel/' . $fileName);
        }
    }

    public function ThemTieuChi(Request $request){
    $type = $request->get('type');
    $idTieuChi = $request->get('id');
    if(config('app.bao_tri')){
        return view("content.baotri");
    }
    if($type=='add'){
        return view("content.themtieuchi");
    }
    else if($type=='clone'){
        return view("content.clonetieuchi",compact('idTieuChi'));
    }
    else{
        return view("content.chinhsuatieuchi",compact('idTieuChi'));
    }
    }
    public function ImportDataMoet(Request $request)
    {

    if(config('app.bao_tri')){
        return view("content.baotri");
    }
    return view("content.importfilemoet");
    }
    public function ChuyenHuongYeuCau(Request $request){
        return("12346");
    }
    public function NhapLieu(Request $request){
        return view('hethong.nhaplieu');
    }
    public function ChinhSuaTemplateBaoCao(Request $request){
        Log::info($request->all());
        $idBaoCao = $request->id;
        $dataHtml = $request->session()->get('dataHtml');
        return view('baocao.chinhsuatemplate',compact('dataHtml','idBaoCao'));
    }

    public function ExportExcelReportSyncStatus(Request $request){
        Log::info($request->all());
        $params = array(
            'capHocList' => $request->get("capHocList"),
            'hocKy' => $request->get("hocKy"),
            'loaiDuLieu' => $request->get("loaiDuLieu"),
            'maDonViList' => $request->get("maDonViList"),
            'maTruongHocList' => $request->get("maTruongHocList"),
            'namHoc' => $request->get("namHoc"),
        );
        $uri = config('url.api_dowload_excel_bao_cao_tinh_hinh_nop_du_lieu');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array('token' => get_user_info('token')),
        ]);
        // đặt tên file
        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = "Bao_cao_tinh_hinh_nop_du_lieu";
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcel(Request $request){
        $params = array(
            'capHoc' => $request->get("capHoc"),
            'namHoc' => $request->get("namHoc"),
            'collectionName' => $request->get("collectionName"),
            'maTruongHoc' => $request->get("maTruongHoc"),
            'maDonVi' => $request->get("maDonVi"),
            'maDonVis' => $request->get("maDonVis"),
            'maTruongs' => $request->get("maTruongs"),
        );
        $uri = config('url.api_dowload_excel');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array('token' => get_user_info('token')),
        ]);
        // đặt tên file
        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = $request->collectionName;
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';
        // Hết đặt tên file
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function Demo(Request $request){
        Log::info($request->all());
        return("123456");
    }

    public function RenderExcelToHtml(Request $request){
        $params = array(
            'emisReportName' => $request->get("emisReportName"),
            'namHoc' => $request->get("namHoc"),
            'maTruongHoc' => $request->get("maTruongHoc"),
        );
        $uri = config('url.api_render_emis');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array('token' => get_user_info('token')),
        ]);
        return base64_encode($res->getBody());
    }

    public function ExportPdf(Request $request){
        Log::info("xuất file pdf");
        Log::info($request->all());
        $params = array(
            'capHoc' => $request->get("capHoc"),
            'namHoc' => $request->get("namHoc"),
            'collectionName' => $request->get("collectionName"),
            'maTruongHoc' => $request->get("maTruongHoc"),
            'maDonVi' => $request->get("maDonVi"),
            'maDonVis' => $request->get("maDonVis"),
            'maTruongs' => $request->get("maTruongs"),
        );
        $uri = config('url.api_dowload_pdf');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        $fileName = Str::random(10).'_'.$request->collectionName.'_export.pdf';
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        Log::info("123456");
        Log::info($res);
        return json_encode($res);
    }

    public function ExportPdfInfoStudent(Request $request){
        Log::info($request->all());
        $params = array(
            'maHocSinh' => $request->get("maHocSinh"),
            'namHoc' => $request->get("namHoc"),
        );
        $uri = config('url.api_dowload_pdf_thong_tin_hoc_sinh');
        $uri = $uri.'?maHocSinh='.$request->maHocSinh;
        Log::info("123456");
        Log::info($uri);
        $client = new Client();
        $res = $client->request('GET', $uri, [
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = $request->get("maHocSinh");
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.pdf';
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        Log::info("123456");
        Log::info($res);
        return json_encode($res);
    }
    public function ExportPdfInfoTeacher(Request $request){
        Log::info($request->all());
        $params = array(
            'canBoTheoNamId' => $request->get("canBoTheoNamId"),
        );
        $uri = config('url.api_dowload_pdf_thong_tin_can_bo');
        $uri = $uri.'?canBoTheoNamId='.$request->canBoTheoNamId;
        Log::info("123456");
        Log::info($uri);
        $client = new Client();
        $res = $client->request('GET', $uri, [
            'headers' => array( 'token' => get_user_info('token')),
        ]);

        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = $request->get("maCanBo");
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.pdf';
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        Log::info("123456");
        Log::info($res);
        return json_encode($res);
    }

    public function ExportPdfHk(Request $request){
        Log::info("xuất file pdf");
        Log::info($request->all());
        $params = array(
            'capHoc' => $request->get("capHoc"),
            'namHoc' => $request->get("namHoc"),
            'collectionName' => $request->get("collectionName"),
            'maTruongHoc' => $request->get("maTruongHoc"),
            'maDonVi' => $request->get("maDonVi"),
            "hocKy"=> $request->get("hocKy"),
            'maDonVis' => $request->get("maDonVis"),
            'maTruongs' => $request->get("maTruongs"),
        );
        $uri = config('url.api_dowload_pdf');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
//        //Log::info($res->getBody());
        $fileName = Str::random(10).'_'.$request->collectionName.'_export.pdf';
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        Log::info("123456");
        Log::info($res);
        return json_encode($res);
    }
    public function ExportExcelHk(Request $request){
        Log::info($request->all());
        $params = array(
            'capHoc' => $request->get("capHoc"),
            'namHoc' => $request->get("namHoc"),
            'collectionName' => $request->get("collectionName"),
            'maTruongHoc' => $request->get("maTruongHoc"),
            'maDonVi' => $request->get("maDonVi"),
            "hocKy"=> $request->get("hocKy"),
            'maDonVis' => $request->get("maDonVis"),
            'maTruongs' => $request->get("maTruongs"),
        );
        $uri = config('url.api_dowload_excel');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
//            'headers' => array('X-MA-DON-VI' => get_user_info('maDonVi'), 'X-ROLE-ID' => get_user_info('role'), 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());
        $fileName = Str::random(10).'_'.$request->collectionName.'_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelKCDL(Request $request){
        Log::info($request->all());
        $params = array(
            'loaiDongBo' => $request->get("loaiDongBo"),
            'namHoc' => $request->get("namHoc"),
            'hocKy' => $request->get("hocKy"),
            'status' => $request->get("status"),
            'maDonViList' => $request->get("maDonViList"),
            'matruongHocList' => $request->get("matruongHocList"),
            'maTruongHoc' => $request->get("maTruongHoc"),
            "capHocList"=> $request->get("capHocList"),
        );
        Log::info("Nội dung test");
        $uri = config('url.api_dowload_excel_kcdl');
        Log::info($uri);
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        Log::info("Nội dung test");
        //Log::info($res->getBody());
        $fileName = Str::random(10).'_'."DanhSachKetChuyenDuLieu".'_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelTruongNopBaoCaoTheoBieuMau(Request $request){
        Log::info($request->all());
        $params = array(
            "bmTruongId"=> $request->get("bmTruongId"),
        );
        $uri = config('url.api_dowload_truong_da_nop_bao_cao_theo_bieu_mau');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());
        $fileName = Str::random(10).'_'."DanhSachTruongHocDaNopBaoCaoTheoBieuMau".'_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelTongHopBaoCaoTheoBieuMau(Request $request){
        Log::info($request->all());
        $params = array(
        );
        $uri = config('url.api_tong_hop_bao_cao_theo_bieu_mau');
        $uri = $uri.'?id='.$request->id;
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        $response = $res->getBody()->getContents();
        $jsona = json_decode($response);
        if(isset($jsona)){
            $stt_code = $jsona->rc;
            Log::info("Không có file");
            return json_encode($jsona);
        }else{
            Log::info("Có file");
            $fileName = Str::random(10).'_'."FileTongHopNopBaoCaoTheoBieuMau".'_export.xlsx';
//            file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
            $filePath = $this->saveFile($fileName, $res->getBody());
            $res = [
                'rc' => 0,
                'rd' => '',
                'file' => $filePath
            ];
            return json_encode($res);
        }
    }
    public function ExportTemplateMkKetChuyen(Request $request){
        Log::info($request->all());
        $params = array(
        );
        $uri = config('url.api_dowload_template_mk_ket_chuyen');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());
        $fileName = Str::random(10).'_'."DanhSachKetChuyenDuLieu".'_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelDuLieuSSO(Request $request){
        Log::info("Thông tin xuất excel dữ liệu sso:");
        Log::info($request->all());
        $params = $request->all();
        $uri = config('url.api_dowload_excel_du_lieu_sso');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());
        $fileName = Str::random(10).'_'."DanhSachDuLieuSSO".'_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelDuLieuDiemDanh(Request $request){
        $params = $request->all();
        $uri = config('url.api_dowload_excel_du_lieu_diem_danh');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        $fileName = Str::random(10).'_'."DanhSachDuLieuDiemDanh".'_export.xlsx';
        $filePath = $this->saveFile($fileName, $res->getBody());
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelDuLieuThongTinYTe(Request $request){
        Log::info($request->all());
        $params = array(
            'namHoc' => $request->get("namHoc"),
            'maTruongHoc' => $request->get("maTruongHoc"),
        );
        $uri = config('url.api_dowload_excel_du_lieu_thong_tin_y_te_hoc_sinh');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        Log::info("Thông tin xuất excel:");
        Log::info($res->getBody());
        $fileName = Str::random(10).'_'."ThongTinYTeHocSinh".'_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelListBanGhiLoi(Request $request){
        Log::info($request->all());
        $params = array(
            'messageId' => $request->get("messageId"),
        );
        $uri = config('url.api_dowload_excel_ban_ghi_loi_kcdl');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());
        $fileName = Str::random(10).'_'."DanhSachBanGhiLoi".'_export.xlsx';
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelLichSuDayDuLieuLenBo(Request $request){
        $params = array(
            'loaiYeuCau' => $request->get("loaiYeuCau"),
            'hocKy' => $request->get("hocKy"),
            'capHoc' => $request->get("capHoc"),
            'maTruongHoc' => $request->get("maTruongHoc"),
            'trangThai' => $request->get("trangThai"),
            'namHoc' => $request->get("namHoc"),
            'maDoiTacs' => $request->get("maDoiTacs"),
            'maTruongs' => $request->get("maTruongs"),
            'maDonVis' => $request->get("maDonVis"),
            'maCapHocs' => $request->get("maCapHocs"),
        );
        Log::info($params);
        $uri = config('url.api_dowload_excel_lich_su_day_du_lieu_len_bo');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        Log::info("Thông tin xuất excel:");
        Log::info($res->getBody());
        $fileName = Str::random(10).'_'."DanhSachLichSuDayDuLieuLenBo".'_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelListStudent(Request $request){
        $params = array(
            'capHocs' => $request->get("capHocs"),
            'gioiTinh' => $request->get("gioiTinh"),
            'keyword' => $request->get("keyword"),
            'maTruongHocs' => $request->get("maTruongHocs"),
            'maPhongs' => $request->get("maPhongs"),
            'dataSreachList' => $request->get("dataSreachList"),
            "namHoc"=> $request->get("namHoc"),
            "start"=> $request->get("start"),
            "limit"=> $request->get("limit"),
            "countInPage"=> $request->get("countInPage"),
            "trangThai"=> $request->get("trangThai"),
            "lstKhoiHoc"=> $request->get("lstKhoiHoc"),
            "tenLopHoc"=> $request->get("tenLopHoc"),
            "colExcels"=> $request->get("colExcels"),
        );
        Log::info("Xuất excel tra cứu học sinh");
        Log::info($params);
        $uri = config('url.api_dowload_excel_list_student');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());


        // Đặt tên file

        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        }
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = "Danh_sach_hoc_sinh";
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';

//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    
    public function ExportExcelCacTruongNopBaoCaoTheoBieuMau(Request $request){
        $params = array(
        );
        Log::info("Xuất excel danh sách các trường đã nộp báo cáo");
        Log::info($params);
        $uri = config('url.api_dowload_excel_truong_nop_bao_cao_theo_bieu_mau').'/'.$request->get("id");
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        }
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = "Danh_sach_truong_nop_bao_cao";
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';

//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelListKqht(Request $request){
        $params = array(
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'capHocs' => $request->get("capHocs"),
            'khoiHocs' => $request->get("khoiHocs"),
            'hocKy' => $request->get("hocKy"),
            "keyword"=> $request->get("keyword"),
            "giaiDoan"=> $request->get("giaiDoan"),
            "maTruongHocs"=> $request->get("maTruongHocs"),
            "namHoc"=> $request->get("namHoc"),
            "colExcels"=> $request->get("colExcels"),
            "maPhongs"=> $request->get("maPhongs"),
            "dataSreachList"=> $request->get("dataSreachList"),
        );
        Log::info("Xuất excel tra cứu kqht");
        Log::info($params);
        $uri = config('url.api_dowload_excel_list_kqht');
        Log::info("uri");
        Log::info($uri);
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());

        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        }
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = "Danh_sach_kqht_hoc_sinh";
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';

//        $fileName = Str::random(10).'_'."DanhSachHocSinh".'_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelListClass(Request $request){
        $params = array(
            "start"=> $request->get("start"),
            "limit"=> $request->get("limit"),
            "capHoc"=> $request->get("capHoc"),
            "keySearch"=> $request->get("keySearch"),
            "khoiHoc"=> $request->get("khoiHoc"),
            "listMaDonViReq"=> $request->get("listMaDonViReq"),
            "dataSreachList"=> $request->get("dataSreachList"),
            "listMaTruongHocReq"=> $request->get("listMaTruongHocReq"),
            "namHoc"=> $request->get("namHoc"),
            "colExcels"=> $request->get("colExcels"),
            "tenGvcn"=> $request->get("tenGvcn"),
        );
        $uri = config('url.api_dowload_excel_list_class');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());

        // Đặt tên file

        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = "Danh_sach_lop_hoc";
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelListCanBoPhongSo(Request $request){
        $params = array(
            "lstMaDonVi"=> $request->get("lstMaDonVi"),
            "lstMaTruong"=> $request->get("lstMaTruong"),
            "maSo"=> $request->get("maSo"),
        );
        $uri = config('url.api_dowload_excel_list_can_bo_phong_so');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());
        // Đặt tên file

        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        $tenBaoCao = "Danh_sach_can_bo_phong_so";
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';

//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function TongHopDuLieuNhaTruong(Request $request){
        $params = array(
            'namHoc' => $request->get("namHoc"),
            'maTruongHoc' => $request->get("maTruongHoc"),
        );
        // $resp = $this->helper->doPost('http://27.71.225.43:44462/csdlgd-report-fetch/refetch/dasboartBc', $params);
        $resp = $this->helper->doPost('http://27.71.225.47:44461/csdlgd-report-fetch/refetch/dasboartBc', $params);
        Log::info($resp);
        Log::info("*********");
        return json_encode($resp);
    }
    public function ExportExcelListSchool(Request $request){
        $params = $request->all();
        // http://27.71.225.43:44462/internal-api/dmTruongHoc/dowloadExcel?start=0&limit=100
        $uri = config('url.api_dowload_excel_list_school');
        $uri = $uri.'?ma='.$request->ma;
        $uri = $uri.'&ten='.$request->ten;
        $uri = $uri.'&trangthai='.$request->trangthai;
        $uri = $uri.'&maNhomCapHoc='.$request->maNhomCapHoc;
        $uri = $uri.'&caphoc='.$request->caphoc;
        $uri = $uri.'&matinhthanh='.$request->matinhthanh;
        $uri = $uri.'&madonvi='.$request->madonvi;
        $uri = $uri.'&loaihinhdaotao='.$request->loaihinhdaotao;
        $uri = $uri.'&start='.$request->start;
        $uri = $uri.'&limit='.$request->limit;
        Log::info('url lấy danh sách trường:');
        Log::info($uri);
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        //Log::info($res->getBody());
        // Đặt tên file
        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        $tenBaoCao = "Danh_sach_truong_hoc";
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function ExportExcelListTeacher(Request $request){
        $params = $request->all();
        $uri = config('url.api_dowload_excel_list_teacher');
        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array( 'token' => get_user_info('token')),
        ]);
        Log::info($params);
        //Log::info($res->getBody());

        // Đặt tên file

        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = "Danh_sach_can_bo";
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';

//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return json_encode($res);
    }
    public function TinhHinhNopDuLieuCuSo(){
        return view('content.tinhhinhnopdulieucuaso');
    }
    public function BaoCaoChoBo()
    {
        return view('content.baocaochobo');
    }
    public function BaoCaoEQMS()
    {
        return view('content.baocaoeqms');
    }
    public function BaoCaoDuLieuDacThu(){
        return view('content.baocaodulieudacthu');
    }
    public function GetDanhMucServiceBo(Request $request){
        $tenDanhMuc=$request->get("tenDanhMuc");
        $params = array(
            'ma_cap_hoc' => "2019",
        );
        $uri = config('url.api_lay_danh_sach_danh_muc_service').$tenDanhMuc;
        Log::info($uri);
        $resp = $this->helper->doGet($uri,$params);
        Log::info($resp);
        return;
        return json_encode($resp);
    }
    public function DoiMatKhauBanThan(Request $request){

        $params = array(
            'password' => $request->get("password"),
            'username' => $request->get("username"),
        );
        $uri = config('url.api_doi_mat_khau_ban_than');
        $resp = $this->helper->doPut($uri, $params);
        return json_encode($resp);
    }
    public function BaoCaoChoSo()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.baocaochoso');
    }
    public function exportHocSinhTt26(){

        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('traCuu.hocSinhThongTu26');
    }
    public function chotDuLieuBaoCao(){

        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        $user = session("user", []);
        $role = $user['role'];
        if($role==2||$role==3){
            return view('baocao.chotDuLieuBaoCaoCapSo');
        }else{
            return view('baocao.chotDuLieuBaoCao');
        }
    }
    public function ThongTinYTeHocSinh(){

        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.thongtinytehocsinh');
    }
    public function BaoCaoChoTruong()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.baocaochotruong');
    }

    public function BaoCaoGuiLen()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.baocaoguilen');
    }

    public function QuanLyNguoiDung()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }

        $tm = $_SERVER['HTTP_HOST'];
        if($tm == 'csdl.bentre.edu.vn'){
            return redirect('https://sso.bentre.edu.vn/Users');
        }else{
            return view('content.quanlynguoidung');
        }
    }

    public function QuanLyVaiTro()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.quanlyvaitro');
    }

    public function CauHinhEmail()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.cauhinhemail');
    }
    public function BaoCaoTinhHinhNopDuLieu(Request $request){
        $type = $request->get("type");
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        if($type==2){
            return view('content.baocaotinhhinhnopdulieu');
        }
        elseif($type==1){
            return view('content.baocaotinhhinhnopdulieutheodonvi');
        }
        else{
            return view('content.baocaotinhhinhnopdulieu');
            return view("errors.404");
        }
    }
    public function CauHinhThoiGianNopDuLieu(Request $request){
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.nopdulieu');
    }
    public function CauHinhDuyetDayDuLieu(){
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        $url = get_full_url();
        $domain = substr($url,0,-19);
        return view('content.cauhinhduyetdaydulieu',compact('domain'));
    }

    public function CauHinhMauEmail()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.cauhinhmauemail');
    }

    public function CauHinhDuongDanLogo()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.cauhinhduongdanlogo');
    }

    public function CauHinhLichDongBo(Request $request)
    {
        $type = $request->get("type");
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        if($type==2){
        return view('content.nopdulieu');
        }
        elseif($type==1){
            return view('content.cauhinhlichdongbo');
        }
        else{
            return view("errors.404");
        }
    }
    public function CauHinhLichDongBoCu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.cauhinhlichdongbocu');
    }
    public function CauHinhLichDongBoHangNam()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.cauhinhlichdongbohangnam');
    }

    public function PhanQuyenDuLieuCu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.phanquyendulieucu');
    }

    public function TraCuuDongBoDuLieu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.tracuudongbodulieu');
    }
    public function SaoLuuDuLieu(){
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.saoluudulieu');
    }

    public function YeuCauDongBoDuLieuCu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.yeucaudongbodulieucu');
    }

    public function YeuCauDongBoDuLieuTheoTruong()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.yeucaudongbodulieutheotruong');
    }
    public function YeuCauDongBoDuLieuTheoTruongIOC()
    {
        Log::info('YeuCauDongBoDuLieuTheoTruongIOC');
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.yeucaudongbodulieutheotruongioc');
    }
    public function HocSinhGiaoVienChuyenTruong()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.hocsinhgiaovienchuyentruong');
    }

    public function TieuChiDuLieu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.tieuchidulieu');
    }

    public function YeuCauNhapLieu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.yeucaunhaplieu');
    }

    public function XemDuLieuDacThu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.xemdulieudacthu');
    }

    public function LichSuDayDuLieu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.lichsudaydulieu');
    }

    public function BaoCaoDayDuLieu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.baocaodaydulieu');
    }

    public function TraCuuHocSinh(Request $request)
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        $data = $request->all();
        $data = json_encode($data);
        return view('content.tracuuhocsinh',compact('data'));
    }
    public function TraCuuKetQuaHocTap(Request $request)
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        $data = $request->all();
        $data = json_encode($data);
        return view('content.tracuuketquahoctap',compact('data'));
    }
    public function TraCuuDuLieuDiemDanh()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view("content.tracuudiemdanh");
    }

    public function TraCuuCanBo(Request $request)
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        $data = $request->all();
        $data = json_encode($data);
        return view('content.tracuucanbo',compact('data'));
    }
    public function TraCuuCanBoPhongSo(){
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.tracuucanbophongso');
    }
    public function GuiYeuCauDongBoDuLieu(){
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.guiyeucaudongbodulieu');
    }
    public function TraCuuHocSinhDongBo()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.tracuuhocsinhdongbo');
    }

    public function LichSuChuyenDuLieu(Request $request)
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        $data = null;
        $data = $request->all();
        $total = count($data);
        if($total>0){
            $data = json_encode($data);
        }
        else{
            $data = 0;
        }

        return view('content.lichsuchuyendulieu',compact('data'));
    }

    public function LichSuDayDuLieuLenBo(Request $request)
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        $data = $request->all();
        $data = json_encode($data);
        return view('content.lichsudaydulieulenbo',compact('data'));
    }
    public function LichSuDayDuLieuLenIOC(Request $request)
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        $data = $request->all();
        $data = json_encode($data);
        return view('content.lichsudaydulieulenioc',compact('data'));
    }
    public function YeuCauNopThongKeTheoBieuMau()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.yeucaunopthongketheobieumau');
    }

    public function BaoCaoEMIS()
    {

        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.baocaoemis');
    }
    public function NhapLieuTieuChiNgoai(Request $request)
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        $data = $request->all();
        $data = json_encode($data);
        return view('content.nhaplieutieuchingoai',compact('data'));
    }
    public function DemoBaoCaoEMIS()
    {

        if(config('app.bao_tri')){
            return view("content.baotri");
        }

        $user = session("user", []);
        $maSo = $user['maSo'];
        // dd($maSo);
        if($maSo == 30){
            return view('baocao.BaoCaoEmis');
        }
        return view('content.demobaocaoemis');
    }
    public function NhapLieuDuLieuCu()
    {

        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.nhapLieuDuLieuCu');
    }

    public function BaoCaoCuaDonVi()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.baocaocuadonvi');
    }
    public function TraCuuLopHoc(Request $request){

    if(config('app.bao_tri')){
        return view("content.baotri");
    }
        $data = $request->all();
        $data = json_encode($data);
        return view('content.tracuulophoc',compact('data'));
    }

    public function CapNhatDoiTac()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.capnhatdoitac');
    }

    public function DanhSachYeuCauDuLieu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.danhsachyeucaudulieu');
    }

    public function BieuDoGiaoVien()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.bieudogiaovien');

    }
    public function BieuDoHocSinh()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.bieudohocsinh');

    }
    public function BieuDoXepLoaiHocSinh()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.bieudoxeploaihocsinh');

    }
    public function soSanhDuLieuMoet()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.sosanhdulieumoet');

    }
    public function MatKhauKetChuyen()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.matkhauketchuyen');

    }
    public function MatKhauKetChuyenIOC()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.matkhauketchuyenioc');

    }
    public function nopDuLieuIoc(){

        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.nopdulieuioc');
    }
    public function BaoCaoDong()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('baocaodong.baocaodong');

    }
    public function BaoCaoTichHop(){
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('baocao.BaoCaoTichHop');
    }
    public function BaoCaoDongPA()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('baocaodong.baocaodongpa');

    }
    public function BaoCaoDongPAV2()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
            return view('baocaodong.baocaodongpav2');

    }
    public function QuanLyBaoCao()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('baocaodong.quanlybaocao');

    }
     public function KetChuyenDuLieu()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.ketchuyendulieu');

    }
    public function NopDuLieuSSO()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.nopdulieusso');

    }
    public function TongHopDuLieuTruong()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.tonghopdulieu');

    }
    public function TongHopDuLieuTruongEmis()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.tonghopdulieuemis');

    }
    public function CapNhatDoiTacTruong()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.capnhatdoitactruong');

    }
    public function NhapLieuDuLieuNamHocCu(){
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.nhaplieudulieunamhoccu');
    }
    public function NhapLieuDuLieuNamHoc(){
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('content.nhaplieudulieunamhoc');
    }
    public function DanhMucServiceBo()
    {
        if(config('app.bao_tri')){
            return view("content.baotri");
        }
        return view('hethong.danhmucservicebo');

    }
    public function ExportExcelReportTeacher(Request $request){
//        return response()->json(123);
        $params = array(
            'colList' => $request->get("colList"),
            'requestLists' => $request->get("requestLists"),
            'requestList' => $request->get("requestList"),
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
            'turn' => $request->get("turn")? false : true,
        );
        $uri = config('url.api_xuat_excel_bao_cao_dong_can_bo');

        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array('token' => get_user_info('token')),
        ]);

        $fileName = uniqid().'_report_teacher_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return response()->json($res);
    }

    public function ExportExcelReportPupil(Request $request){
        $params = array(
            'colList' => $request->get("colList"),
            'requestLists' => $request->get("requestLists"),
            'requestList' => $request->get("requestList"),
            'start' => 0,
            'limit' => 10000,
            'turn' => $request->get("turn")? false : true,
        );
        $uri = config('url.api_xuat_excel_bao_cao_dong_hoc_sinh');

        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array('token' => get_user_info('token')),
        ]);

        $fileName = uniqid().'_report_pupil_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return response()->json($res);
    }

    public function ExportExcelReportSchool(Request $request){
        $params = array(
            'colList' => $request->get("colList"),
            'requestLists' => $request->get("requestLists"),
            'requestList' => $request->get("requestList"),
            'start' => 0,
            'limit' => 10000,
            'turn' => $request->get("turn")? false : true,
        );
        $uri = config('url.api_xuat_excel_bao_cao_dong_truong_hoc');

        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array('token' => get_user_info('token')),
        ]);
        // Đặt tên file

        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $user = session("user", []);
        $maSo = $user['maDonVi'];
        if($user['role']==5){
            $maSo = $user['maTruongHoc'];
        }
        $tenBaoCao = "BaoCaoDongTruongHoc";
        $tenFile = $maSo.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';
        Log::info("Báo cáo động trường học:");
        Log::info($fileName);
        // $fileName = uniqid().'_report_school_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => '',
            'file' => $filePath
        ];
        return response()->json($res);
    }
    public function ExportExcelTemplateImportDuLieuNamHoc(Request $request){
        $params = array(
            'maTruongHoc' => $request->get("maTruongHoc"),
            'namHoc' => $request->get("namHoc"),
        );
        $uri = config('url.api_lay_template_import_kqht');

        $client = new Client();
        $res = $client->request('POST', $uri, [
            'json' => $params,
            'headers' => array('token' => get_user_info('token')),
        ]);
        // Đặt tên file

        $ngay = Carbon::now()->day;
        if($ngay<1){
            $ngay = '0'.$ngay;
        };
        $thang = Carbon::now()->month;
        if($thang<10){
            $thang = '0'.$thang;
        }
        $nam = Carbon::now()->year;
        $maTruong = $request->get("maTruongHoc");
        $tenBaoCao = "FileImportDuLieuKqht";
        $tenFile = str_random(5).'_'.$maTruong.'_'.$tenBaoCao.'_'.$ngay.$thang.$nam;
        $fileName = $tenFile.'.xlsx';
        // $fileName = uniqid().'_report_school_export.xlsx';
//        file_put_contents(public_path('exportExcel/'.$fileName), $res->getBody());
        $filePath = $this->saveFile($fileName, $res->getBody());
        $res = [
            'rc' => -1,
            'rd' => $res,
            'file' => $filePath
        ];
        return response()->json($res);
    }

}
