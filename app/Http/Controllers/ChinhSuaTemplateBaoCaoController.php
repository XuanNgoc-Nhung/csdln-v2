<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class ChinhSuaTemplateBaoCaoController extends BaseController
{
    public function layToanBoTieuChi(Request $request)
    {
        $params = array(
            'doiTuong' => '',
            'textSreach' =>"",
            'tieuChiHeThong' =>null
        );
        $uri = config('url.api_lay_danh_sach_tieu_chi_bao_cao');
        $url = $uri.'?skip=0&limit=20000';
        Log::info("urrl");
        Log::info($url);
        $resp = $this->helper->doPost($url, $params);
        Log::info("676");
        Log::info($resp);
        
        return json_encode($resp);
    }
}
