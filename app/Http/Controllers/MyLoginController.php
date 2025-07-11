<?php

namespace App\Http\Controllers;

use App\Connection\ConnectionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MyLoginController extends Controller
{
    private $conn;

    public function __construct(ConnectionHelper $connectionHelper)
    {
        $this->conn = $connectionHelper;
    }

    public function dangXuatSSOV2()
    {
        session(['isLoggedIn' => false, 'user' => null]);
        return redirect('/');
    }
    public function test(){
        $aa = 'Thiện';
        $marks = array(
            'id_ve'=>$aa,
            'harry'=>80,
            'John'=>78,
            'Clark'=>90
        );
        $a = json_encode($marks);
        $qr = 'https://chart.googleapis.com/chart?cht=qr&chl='.$a.'&chs=160x160&chld=L|0&choe=UTF-8';
        dd($qr);
        return view("test",compact('qr'));
    }

    public function logout(Request $request)
    {
        Log::info('Đăng xuất', []);
        $user = session('user', []);
        if ($user['sso'] == true) {
            Log::info('Đăng xuất tk sso', []);
            $id_token = session('id_token');
            $sate = Str::random(5);
            $post_logout_redirect_uri = route('sso-logout');
            $base_url = 'https://id.nentanggiaoduc.edu.vn/connect/endsession?id_token_hint=';
            $tm = $_SERVER['HTTP_HOST'];
            if($tm == 'csdl.bentre.edu.vn'){
                Log::info('Bến Tre', []);
                $base_url = 'https://id.bentre.edu.vn/connect/endsession?id_token_hint=';
            }
            $logout_url = $base_url . $id_token . '&state=' . $sate . '&post_logout_redirect_uri=' . $post_logout_redirect_uri;
            $request->session()->flush();
            session(['user' => null]);
            session(['isLoggedIn' => false]);
            return redirect($logout_url);
        } else {
            Log::info('Đăng xuất tk thường', []);
            session(['isLoggedIn' => false, 'user' => null]);
            return redirect('/');
        }
    }
    public function loginWithToken(Request $request)
    {
        Log::info('loginWithToken', []);
        $id_token = isset($request->id_token) ? $request->id_token : '';
        session(['id_token' => $id_token]);
        $url = config('url.api_dang_nhap_voi_token');
        $username = $request->username;
        $token = $request->token;
        $params = array('token' => $token, 'username' => $username);
        $response = $this->conn->doGetJsonObject($url, $params);
        $response = (object)$response;
        \Log::info('Đăng nhập bằng token sso:' . json_encode($response), []);
        if ($response == null || !isset($response->code)) {
            // return("Không tồn tại res");
            Log::info('Không đăng nhập được.', []);
            Log::info('response', []);
            Log::info($response, []);
            $message = "Vui lòng thử lại.";
            return redirect('/')->withErrors(['password' => $message]);
        }
        $errCode = $response->rc;
        $message = $response->rd;
        if ($errCode != 0) {
            // return("rc khác 0");
            session(['isLoggedIn' => false]);
            return redirect('/')->withErrors(['password' => $message]);
        }
        $ten = $response->display_name;
        $tenDacBiet = $this->htmlspecialchars_custom($ten);
        $role = $response->parentRole;
        $role2 = $response->role;
        $username = $response->username;
        $display_name = $tenDacBiet;
        $token = $response->token;
        $ma_so = $response->ma_so;
        $sso = $response->sso;
        $ma_don_vi = $response->ma_don_vi;
        $ma_truong_hoc = $response->ma_truong_hoc;
        $list_cap_hoc = $response->capHocList;
        $cap_mam_non = false;
        if ($list_cap_hoc == [4, 5] || $list_cap_hoc == [4] || $list_cap_hoc == [5] || $list_cap_hoc == [45]) {
            $cap_mam_non = true;
        } else {
            $cap_mam_non = false;
        }
        $permission = isset($response->permission) ? $response->permission : [];
        $permission = json_decode(json_encode($permission));
        \Log::info('permission login with token sso: ' . json_encode($permission), []);
        $listCapHoc = [];
        if ($list_cap_hoc == null || $list_cap_hoc == []) {
            $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
        }
        $bieuDo = [];
        $bieuDo = (object)$bieuDo;
        $bieuDo->cap_mot = false;
        $bieuDo->cap_hai = false;
        $bieuDo->cap_ba = false;
        $bieuDo->cap_mam_non = false;
        $bieuDo->cap_gdtx = false;
        if ($list_cap_hoc == null || $list_cap_hoc == []) {
            $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
        }
        foreach ($list_cap_hoc as $ch) {
            if ($ch == 1) {
                array_push($listCapHoc, ['name' => "Cấp 1", 'id' => 1]);
                $bieuDo->cap_mot = true;
            }
            if ($ch == 2) {
                array_push($listCapHoc, ['name' => "Cấp 2", 'id' => 2]);
                $bieuDo->cap_hai = true;
            }
            if ($ch == 3) {
                array_push($listCapHoc, ['name' => "Cấp 3", 'id' => 3]);
                $bieuDo->cap_ba = true;
            }
            if ($ch == 4) {
                array_push($listCapHoc, ['name' => "Nhà trẻ", 'id' => 4]);
                $bieuDo->cap_mam_non = true;
            }
            if ($ch == 5) {
                array_push($listCapHoc, ['name' => "Mẫu giáo", 'id' => 5]);
                $bieuDo->cap_mam_non = true;
            }
            if ($ch == 45) {
                array_push($listCapHoc, ['name' => "Mầm non", 'id' => 45]);
                $bieuDo->cap_mam_non = true;
            }
            if ($ch == 6) {
                array_push($listCapHoc, ['name' => "GDTX", 'id' => 6]);
                $bieuDo->cap_gdtx = true;
            }
        }
        session(['cate_menu' => $permission]);
        $user_data = array(
            "username" => $username,
            "fullName" => $display_name,
            "server_role" => $role,
            "maSo" => $ma_so,
            "sso" => $sso,
            "maTruongHoc" => $ma_truong_hoc,
            "maDonVi" => $ma_don_vi,
            "listCapHoc" => $response->capHocList,
            "token" => $token,
            "capMamNon" => $cap_mam_non,
            "bieuDo" => $bieuDo,
            "role" => $response->parentRole,
            "role2" => $response->role,
            "imgavatar" => (empty($response->user->avatar) ? asset('images/user_empty.png') : $response->user->avatar),
        );
        $tm = $_SERVER['HTTP_HOST'];
        $tenmien = "https://" . $tm;

        $thang = Carbon::now()->month;
        $namHocHienTai = Carbon::now()->year;
        if ($thang < 8) {
            $namHocHienTai = $namHocHienTai - 1;
        }
        // return $ahihi;
        $common_info = array(
            "role" => $response->parentRole,
            "role2" => $response->role,
            "province" => $response->province,
            "district" => $response->district,
            "ma_so" => $response->ma_so,
            "sso" => $response->sso,
            "ma_phong" => $response->ma_phong,
            "ma_don_vi" => $response->ma_don_vi,
            "capMamNon" => $cap_mam_non,
            "display_name" => $tenDacBiet,
            "listCapHoc" => $response->capHocList,
            "ma_truong_hoc" => $response->ma_truong_hoc,
            "username" => $response->username,
            "bieuDo" => $bieuDo,
            "tenMien" => $tenmien,
            "namHocHienTai" => $namHocHienTai,
        );
        $user_data["common_info"] = $common_info;
        session(['user' => $user_data]);
        Session::put('listCapHoc', $listCapHoc);
        session(['isLoggedIn' => true]);
        return redirect(get_first_route());
    }
    public function loginWithTokenSMAS(Request $request)
    {
        Log::info('loginWithTokenSMAS', []);
        $smas_token = isset($request->code) ? $request->code : '';
        session(['smas_token' => $smas_token]);
        $url = config('url.api_dang_nhap_voi_token_smas');
        $params = array('smas_token' => $smas_token);
        $response = $this->conn->doPostJsonObject($url, $params);
        $response = (object)$response;
        \Log::info('url:' .$url, []);
        \Log::info('Đăng nhập bằng token smas:' . json_encode($response), []);
        if ($response == null || !isset($response->code)) {
            // return("Không tồn tại res");
            Log::info('Không đăng nhập được.', []);
            Log::info('response', []);
            // Log::info($response);
            $message = "Vui lòng thử lại.";
            return redirect('/')->withErrors(['password' => $message]);
        }
        $errCode = $response->rc;
        $message = $response->rd;
        if ($errCode != 0) {
            // return("rc khác 0");
            session(['isLoggedIn' => false]);
            return redirect('/')->withErrors(['password' => $message]);
        }
        $ten = $response->display_name;
        $tenDacBiet = $this->htmlspecialchars_custom($ten);
        $role = $response->parentRole;
        $role2 = $response->role;
        $username = $response->username;
        $display_name = $tenDacBiet;
        $token = $response->token;
        $ma_so = $response->ma_so;
        $sso = $response->sso;
        $ma_don_vi = $response->ma_don_vi;
        $ma_truong_hoc = $response->ma_truong_hoc;
        $list_cap_hoc = $response->capHocList;
        $cap_mam_non = false;
        if ($list_cap_hoc == [4, 5] || $list_cap_hoc == [4] || $list_cap_hoc == [5] || $list_cap_hoc == [45]) {
            $cap_mam_non = true;
        } else {
            $cap_mam_non = false;
        }
        $permission = isset($response->permission) ? $response->permission : [];
        $permission = json_decode(json_encode($permission));
        \Log::info('permission login with token sso: ' . json_encode($permission), []);
        $listCapHoc = [];
        if ($list_cap_hoc == null || $list_cap_hoc == []) {
            $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
        }
        $bieuDo = [];
        $bieuDo = (object)$bieuDo;
        $bieuDo->cap_mot = false;
        $bieuDo->cap_hai = false;
        $bieuDo->cap_ba = false;
        $bieuDo->cap_mam_non = false;
        $bieuDo->cap_gdtx = false;
        if ($list_cap_hoc == null || $list_cap_hoc == []) {
            $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
        }
        foreach ($list_cap_hoc as $ch) {
            if ($ch == 1) {
                array_push($listCapHoc, ['name' => "Cấp 1", 'id' => 1]);
                $bieuDo->cap_mot = true;
            }
            if ($ch == 2) {
                array_push($listCapHoc, ['name' => "Cấp 2", 'id' => 2]);
                $bieuDo->cap_hai = true;
            }
            if ($ch == 3) {
                array_push($listCapHoc, ['name' => "Cấp 3", 'id' => 3]);
                $bieuDo->cap_ba = true;
            }
            if ($ch == 4) {
                array_push($listCapHoc, ['name' => "Nhà trẻ", 'id' => 4]);
                $bieuDo->cap_mam_non = true;
            }
            if ($ch == 5) {
                array_push($listCapHoc, ['name' => "Mẫu giáo", 'id' => 5]);
                $bieuDo->cap_mam_non = true;
            }
            if ($ch == 45) {
                array_push($listCapHoc, ['name' => "Mầm non", 'id' => 45]);
                $bieuDo->cap_mam_non = true;
            }
            if ($ch == 6) {
                array_push($listCapHoc, ['name' => "GDTX", 'id' => 6]);
                $bieuDo->cap_gdtx = true;
            }
        }
        session(['cate_menu' => $permission]);
        $user_data = array(
            "username" => $username,
            "fullName" => $display_name,
            "server_role" => $role,
            "maSo" => $ma_so,
            "sso" => $sso,
            "maTruongHoc" => $ma_truong_hoc,
            "maDonVi" => $ma_don_vi,
            "listCapHoc" => $response->capHocList,
            "token" => $token,
            "capMamNon" => $cap_mam_non,
            "bieuDo" => $bieuDo,
            "role" => $response->parentRole,
            "role2" => $response->role,
            "imgavatar" => (empty($response->user->avatar) ? asset('images/user_empty.png') : $response->user->avatar),
        );
        $tm = $_SERVER['HTTP_HOST'];
        $tenmien = "https://" . $tm;

        $thang = Carbon::now()->month;
        $namHocHienTai = Carbon::now()->year;
        if ($thang < 8) {
            $namHocHienTai = $namHocHienTai - 1;
        }
        // return $ahihi;
        $common_info = array(
            "role" => $response->parentRole,
            "role2" => $response->role,
            "province" => $response->province,
            "district" => $response->district,
            "ma_so" => $response->ma_so,
            "sso" => $response->sso,
            "ma_phong" => $response->ma_phong,
            "ma_don_vi" => $response->ma_don_vi,
            "capMamNon" => $cap_mam_non,
            "display_name" => $tenDacBiet,
            "listCapHoc" => $response->capHocList,
            "ma_truong_hoc" => $response->ma_truong_hoc,
            "username" => $response->username,
            "bieuDo" => $bieuDo,
            "tenMien" => $tenmien,
            "namHocHienTai" => $namHocHienTai,
        );
        $user_data["common_info"] = $common_info;
        session(['user' => $user_data]);
        Session::put('listCapHoc', $listCapHoc);
        session(['isLoggedIn' => true]);
        return redirect(get_first_route());
    }

    public function login(Request $request)
    {

        $url = config('url.api_dang_nhap');
        $username = $request->get("username");
        $password = $request->get("password");
        $xForwardedFor = $request->header('X-Forwarded-For')?$request->header('X-Forwarded-For'):null;
        $UserAgent = $request->header('User-Agent')?$request->header('User-Agent'):null;
        $captcha = $request->get('captcha') ? $request->get('captcha') : '';
        $tokenCap = $request->get('tokenCap') ? $request->get('tokenCap') : '';
        $params = array('username' => $username, 'password' => $password, 'captcha' => $captcha, 'captcha_token' => $tokenCap,'ipAddress'=>$xForwardedFor,'userAgent'=>$UserAgent);
        Log::debug('params login:');
        Log::warning(json_encode($params));
        Log::warning(json_encode($url));
        $response = $this->conn->doPostJsonObject($url, $params);
        Log::debug('Kết quả đăng nhập:');
        Log::info(json_encode($response), []);
        if ($response&&$response->domain&& $response->ma_so!=45&&false) {
            $tokenSend = $response->token;
            $userNameSend = $response->username;
            $urlSend = $response->domain;
            $urlLogin = "https://" . $urlSend . "/login2?&token=" . $tokenSend . "&username=" . $userNameSend;
            return redirect()->away($urlLogin);
        } else {
            $message = 'Tên tài khoản hoặc mật khẩu không chính xác.';
            $errCode = $response->rc;
            if ($response == null || !isset($response->code)) {
                return redirect()->back()->withInput($request->all)->withErrors(['errorCode' => $errCode]);
            }
            $failCount = $response->failCount;
            try {
                Log::info("==>login respone code=" . $errCode . ", msg=" . $response->rd, []);
                $message = $response->rc;
                if ($errCode != 0) {
                    session(['isLoggedIn' => false]);
                    if ($errCode == 3) {
                        Session::forget(['tokenCap', 'dataImage']);
                        return redirect()->back()->withInput($request->all)->withErrors(['errorCode' => $message]);
                    } elseif (($errCode == 27 && $failCount >= 5) || $errCode == -96) {
                        Log::info("Lấy capcha", []);
                        $message = $response->rc;
                        $captcha = $this->getCaptCha();
                        if ($captcha) {
                            if ($captcha->rc == 0) {
                                Session::flash('tokenCap', $captcha->tokenCap);
                                Session::flash('dataImage', $captcha->dataImg);
                                return redirect()->back()->withInput($request->all)->withErrors(['errorCode' => $message]);
                            }
                        }
                        Session::forget(['tokenCap', 'dataImage']);
                        return redirect()->back()->withInput($request->all)->withErrors(['errorCode' => $message]);
                    } else {
                        Session::forget(['tokenCap', 'dataImage']);
                        return redirect()->back()->withInput($request->all)->withErrors(['errorCode' => $message]);
                    }


                }
                $ten = $response->display_name;
                $tenDacBiet = $this->htmlspecialchars_custom($ten);
                $role = $response->parentRole;
                $role2 = $response->role;
                $username = $response->username;
                // $display_name = $response->display_name;
                $display_name = $tenDacBiet;
                $token = $response->token;
                $ma_so = $response->ma_so;
                $sso = $response->sso;
                $doipass = $response->passwordOutdated;
                $doiMkMacDinh = $response->needChangePassword;
                $ma_don_vi = $response->ma_don_vi;
                $ma_truong_hoc = $response->ma_truong_hoc;
                $list_cap_hoc = $response->capHocList;
                // dd($res);
                $cap_mam_non = false;
                if ($list_cap_hoc == [4, 5] || $list_cap_hoc == [4] || $list_cap_hoc == [5] || $list_cap_hoc == [45]) {
                    $cap_mam_non = true;
                } else {
                    $cap_mam_non = false;
                }
                $permission = isset($response->permission) ? $response->permission : [];
                $permission = json_decode(json_encode($permission));
                // dd($permission);
                $listCapHoc = [];
                $bieuDo = [];
                $bieuDo = (object)$bieuDo;
                $bieuDo->cap_mot = false;
                $bieuDo->cap_hai = false;
                $bieuDo->cap_ba = false;
                $bieuDo->cap_mam_non = false;
                $bieuDo->cap_gdtx = false;
                if ($list_cap_hoc == null || $list_cap_hoc == []) {
                    $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
                }
                foreach ($list_cap_hoc as $ch) {
                    if ($ch == 1) {
                        array_push($listCapHoc, ['name' => "Cấp 1", 'id' => 1]);
                        $bieuDo->cap_mot = true;
                    }
                    if ($ch == 2) {
                        array_push($listCapHoc, ['name' => "Cấp 2", 'id' => 2]);
                        $bieuDo->cap_hai = true;
                    }
                    if ($ch == 3) {
                        array_push($listCapHoc, ['name' => "Cấp 3", 'id' => 3]);
                        $bieuDo->cap_ba = true;
                    }
                    if ($ch == 4) {
                        array_push($listCapHoc, ['name' => "Nhà trẻ", 'id' => 4]);
                        $bieuDo->cap_mam_non = true;
                    }
                    if ($ch == 5) {
                        array_push($listCapHoc, ['name' => "Mẫu giáo", 'id' => 5]);
                        $bieuDo->cap_mam_non = true;
                    }
                    if ($ch == 45) {
                        array_push($listCapHoc, ['name' => "Mầm non", 'id' => 45]);
                        $bieuDo->cap_mam_non = true;
                    }
                    if ($ch == 6) {
                        array_push($listCapHoc, ['name' => "GDTX", 'id' => 6]);
                        $bieuDo->cap_gdtx = true;
                    }
                }
                session(['cate_menu' => $permission]);
                $user_data = array(
                    "username" => $username,
                    "fullName" => $display_name,
                    "server_role" => $role,
                    "doipass" => $doipass,
                    "doiPassMd" => $doiMkMacDinh,
                    "maSo" => $ma_so,
                    "sso" => $sso,
                    "maDonVi" => $ma_don_vi,
                    "maTruongHoc" => $ma_truong_hoc,
                    "listCapHoc" => $response->capHocList,
                    "token" => $token,
                    "capMamNon" => $cap_mam_non,
                    "bieuDo" => $bieuDo,
                    "role" => $response->parentRole,
                    "role2" => $response->role,
                    "imgavatar" => (empty($response->user->avatar) ? asset('images/user_empty.png') : $response->user->avatar),
                );
                $tm = $_SERVER['HTTP_HOST'];
                $tenmien = "https://" . $tm;

                $thang = Carbon::now()->month;
                $namHocHienTai = Carbon::now()->year;
                if ($thang < 8) {
                    $namHocHienTai = $namHocHienTai - 1;
                }
                 // $namHocHienTai = 2023;
                $common_info = array(
                    "role" => $response->parentRole,
                    "role2" => $response->role,
                    "province" => $response->province,
                    "district" => $response->district,
                    "ma_so" => $response->ma_so,
                    "sso" => $response->sso,
                    "ma_phong" => $response->ma_phong,
                    "doipass" => $doipass,
                    "doiPassMd" => $doiMkMacDinh,
                    "listCapHoc" => $response->capHocList,
                    "capMamNon" => $cap_mam_non,
                    "ma_don_vi" => $response->ma_don_vi,
                    "username" => $response->username,
                    // "display_name" => $response->display_name,
                    "display_name" => $tenDacBiet,
                    "ma_truong_hoc" => $response->ma_truong_hoc,
                    "bieuDo" => $bieuDo,
                    "tenMien" => $tenmien,
                    "namHocHienTai" => $namHocHienTai,
                );
                $user_data["common_info"] = $common_info;
                Session::forget(['tokenCap', 'dataImage']);
                Session::put('listCapHoc', $listCapHoc);
                session(['user' => $user_data]);
                session(['isLoggedIn' => true]);
                return redirect(get_first_route());
            } catch (\Exception $ex) {
                Log::info("Exception login failed: " . $ex, []);
                $message = "-1";
                return redirect()->back()->withInput()->withErrors(['errorCode' => $message]);
            }
        }

    }

    public function getCodeLoginSSO()
    {
        \Log::info('getCodeLoginSSO', []);
//        $url = 'http://27.71.225.47:44461/csdlgd-user/adminUser/getSSOHash';
        $url = config("url.api_get_hash_sso");
        $client = new Client();
        $resp = $client->request('GET', $url, []);
        $json = $resp->getBody()->getContents();
        $code_verifier = json_decode($json)->code_verifier;
        $code_challenge = json_decode($json)->code_challenge;
        Session::put('code_verifyer', $code_verifier);
        return ($json);

    }

    public function dangNhapSMAS(Request $request)
    {
        \Log::info('dangNhapSSOV2', []);

        $code = $request->get('code');
        $uriAuthToken = 'https://id.nentanggiaoduc.edu.vn/connect/token';
        $tm = $_SERVER['HTTP_HOST'];
        if($tm == 'csdl.bentre.edu.vn'){
            Log::info('Bến tre', []);
            $uriAuthToken = 'https://id.bentre.edu.vn/connect/token';
        }
        $code_verifyer = $request->session()->get('code_verifyer');
        $paramsAuthToken = [
            "grant_type" => "authorization_code",
            "code" => $request->code,
            "redirect_uri" => route('sso-login'),
            "client_id" => 'csdln_client',
            "code_verifier" => $code_verifyer,
        ];

        try {
            $client = new Client();

            \Log::info(' lấy thông tin accessToken', []);
            $resp = $client->request('POST', $uriAuthToken, [
                'form_params' => $paramsAuthToken,
                'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
            ]);
            $jsona = $resp->getBody()->getContents();
            $message = 'Có lỗi xảy ra. Vui lòng thử lại.';
            $jsona = json_decode($jsona);
            \Log::info(' lấy xong accessToken', []);
            $accessToken = $jsona->access_token;
            $id_token = $jsona->id_token;
            session(['id_token' => $id_token]);
            $uriGetInfo = config("url.api_login_sso");
            $paramsGetInfo = ["accessToken" => $accessToken];
            $response = $this->conn->doGetJsonObject($uriGetInfo, $paramsGetInfo);
            $response = (object)$response;

            \Log::info('response login sso: ' . json_encode($response), []);
            \Log::info(' *****************', []);
            if (isset($response) && $response->rc == 0) {
                if (!isset($response->domain)||true) {
                    $ten = $response->display_name;
                    $tenDacBiet = $this->htmlspecialchars_custom($ten);
                    $role = $response->parentRole;
                    $role2 = $response->role;
                    $username = $response->username;
                    $display_name = $tenDacBiet;
                    $token = $response->token;
                    $sso = $response->sso;
                    $ma_so = $response->ma_so;
                    $ma_don_vi = $response->ma_don_vi;
                    $ma_truong_hoc = $response->ma_truong_hoc;
                    $list_cap_hoc = $response->capHocList;
                    $cap_mam_non = false;
                    if ($list_cap_hoc == [4, 5] || $list_cap_hoc == [4] || $list_cap_hoc == [5] || $list_cap_hoc == [45]) {
                        $cap_mam_non = true;
                    } else {
                        $cap_mam_non = false;
                    }
                    $permission = isset($response->permission) ? $response->permission : [];
                    $permission = json_decode(json_encode($permission));
                    \Log::info('permission login: ' . json_encode($permission), []);
                    $listCapHoc = [];
                    if ($list_cap_hoc == null || $list_cap_hoc == []) {
                        $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
                    }
                    if ($list_cap_hoc == null || $list_cap_hoc == []) {
                        $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
                    }
                    foreach ($list_cap_hoc as $ch) {
                        if ($ch == 1) {
                            array_push($listCapHoc, ['name' => "Cấp 1", 'id' => 1]);
                        }
                        if ($ch == 2) {
                            array_push($listCapHoc, ['name' => "Cấp 2", 'id' => 2]);
                        }
                        if ($ch == 3) {
                            array_push($listCapHoc, ['name' => "Cấp 3", 'id' => 3]);
                        }
                        if ($ch == 4) {
                            array_push($listCapHoc, ['name' => "Nhà trẻ", 'id' => 4]);
                        }
                        if ($ch == 5) {
                            array_push($listCapHoc, ['name' => "Mẫu giáo", 'id' => 5]);
                        }
                        if ($ch == 45) {
                            array_push($listCapHoc, ['name' => "Mầm non", 'id' => 45]);
                        }
                        if ($ch == 6) {
                            array_push($listCapHoc, ['name' => "GDTX", 'id' => 6]);
                        }
                    }
                    session(['cate_menu' => $permission]);
                    $user_data = array(
                        "username" => $username,
                        "fullName" => $display_name,
                        "maSo" => $ma_so,
                        "maTruongHoc" => $ma_truong_hoc,
                        "sso" => $sso,
                        "maDonVi" => $ma_don_vi,
                        "token" => $token,
                        "listCapHoc" => $response->capHocList,
                        "role" => $response->parentRole,
                        "role2" => $response->role,
                        "imgavatar" => (empty($response->user->avatar) ? asset('images/user_empty.png') : $response->user->avatar),
                    );
                    $tm = $_SERVER['HTTP_HOST'];
                    $tenmien = "https://" . $tm;

                    $thang = Carbon::now()->month;
                    $namHocHienTai = Carbon::now()->year;
                    if ($thang < 8) {
                        $namHocHienTai = $namHocHienTai - 1;
                    }
                    $common_info = array(
                        "role" => $response->parentRole,
                        "role2" => $response->role,
                        "province" => $response->province,
                        "district" => $response->district,
                        "ma_so" => $response->ma_so,
                        "ma_phong" => $response->ma_phong,
                        "sso" => $response->sso,
                        "ma_don_vi" => $response->ma_don_vi,
                        "listCapHoc" => $response->capHocList,
                        // "display_name" => $tenDacBiet,
                        "ma_truong_hoc" => $response->ma_truong_hoc,
                        "username" => $response->username,
                        "tenMien" => $tenmien,
                        "namHocHienTai" => $namHocHienTai,
                    );
                    $user_data["common_info"] = $common_info;
                    session(['user' => $user_data]);
                    Session::put('listCapHoc', $listCapHoc);
                    session(['isLoggedIn' => true]);
                    return redirect(get_first_route());
                    dd("Thực hiện đăng nhập");

                } else {
                    $tokenSend = $response->token;
                    $userNameSend = $response->username;
                    $urlSend = $response->domain??'';
                    $urlLogin = "https://" . $urlSend . "/login2?&token=" . $tokenSend . "&username=" . $userNameSend . '&id_token=' . $id_token;
                    return redirect()->away($urlLogin);
                }
            } else {
                $message = "Vui lòng thử lại sau ít phút.";
                return redirect('/')->withErrors(['password' => $message]);
            }
            dd($response);
        } catch (\Exception $ex) {
            \Log::error("Login error: " . $ex->getMessage());
            $message = "Tên tài khoản hoặc mật khẩu không chính xác.";
            return redirect('/')->withErrors(['password' => $message]);
        }

    }
    public function dangNhapSSOV2(Request $request)
    {
        Log::info('Đăng nhập từ luồng SSO', []);
        $code = $request->get('code');
        Log::info('code:', []);
        Log::info($code, []);
        $uriAuthToken = 'https://id.nentanggiaoduc.edu.vn/connect/token';
        $tm = $_SERVER['HTTP_HOST'];
        if($tm == 'csdl.bentre.edu.vn'){
            Log::info('Bến tre', []);
            $uriAuthToken = 'https://id.bentre.edu.vn/connect/token';
        }
        $code_verifyer = $request->session()->get('code_verifyer');
        Log::info('$uriAuthToken:', []);
        Log::info($uriAuthToken, []);
        $paramsAuthToken = [
            "grant_type" => "authorization_code",
            "code" => $request->code,
            "redirect_uri" => route('sso-login'),
            "client_id" => 'csdln_client',
            "code_verifier" => $code_verifyer,
        ];

        try {
            $client = new Client();

            \Log::info(' lấy thông tin accessToken', []);
            $resp = $client->request('POST', $uriAuthToken, [
                'form_params' => $paramsAuthToken,
                'headers' => array('Content-Type' => 'application/x-www-form-urlencoded'),
            ]);

            $jsona = $resp->getBody()->getContents();
            $message = 'Có lỗi xảy ra. Vui lòng thử lại.';
            $jsona = json_decode($jsona);
            \Log::info(' lấy xong accessToken', []);
            $accessToken = $jsona->access_token;
            $id_token = $jsona->id_token;
            session(['id_token' => $id_token]);
            $uriGetInfo = config("url.api_login_sso");
            $paramsGetInfo = ["accessToken" => $accessToken];
            $response = $this->conn->doGetJsonObject($uriGetInfo, $paramsGetInfo);
            $response = (object)$response;

            \Log::info('response login sso: ' . json_encode($response), []);
            \Log::info(' *****************', []);
            if (isset($response) && $response->rc == 0) {
                if (!isset($response->domain)||true) {
                    $ten = $response->display_name;
                    $tenDacBiet = $this->htmlspecialchars_custom($ten);
                    $role = $response->parentRole;
                    $role2 = $response->role;
                    $username = $response->username;
                    $display_name = $tenDacBiet;
                    $token = $response->token;
                    $sso = $response->sso;
                    $ma_so = $response->ma_so;
                    $ma_don_vi = $response->ma_don_vi;
                    $ma_truong_hoc = $response->ma_truong_hoc;
                    $list_cap_hoc = $response->capHocList;
                    $cap_mam_non = false;
                    if ($list_cap_hoc == [4, 5] || $list_cap_hoc == [4] || $list_cap_hoc == [5] || $list_cap_hoc == [45]) {
                        $cap_mam_non = true;
                    } else {
                        $cap_mam_non = false;
                    }
                    $permission = isset($response->permission) ? $response->permission : [];
                    $permission = json_decode(json_encode($permission));
                    \Log::info('permission login: ' . json_encode($permission), []);
                    $listCapHoc = [];
                    if ($list_cap_hoc == null || $list_cap_hoc == []) {
                        $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
                    }
                    if ($list_cap_hoc == null || $list_cap_hoc == []) {
                        $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
                    }
                    foreach ($list_cap_hoc as $ch) {
                        if ($ch == 1) {
                            array_push($listCapHoc, ['name' => "Cấp 1", 'id' => 1]);
                        }
                        if ($ch == 2) {
                            array_push($listCapHoc, ['name' => "Cấp 2", 'id' => 2]);
                        }
                        if ($ch == 3) {
                            array_push($listCapHoc, ['name' => "Cấp 3", 'id' => 3]);
                        }
                        if ($ch == 4) {
                            array_push($listCapHoc, ['name' => "Nhà trẻ", 'id' => 4]);
                        }
                        if ($ch == 5) {
                            array_push($listCapHoc, ['name' => "Mẫu giáo", 'id' => 5]);
                        }
                        if ($ch == 45) {
                            array_push($listCapHoc, ['name' => "Mầm non", 'id' => 45]);
                        }
                        if ($ch == 6) {
                            array_push($listCapHoc, ['name' => "GDTX", 'id' => 6]);
                        }
                    }
                    session(['cate_menu' => $permission]);
                    $user_data = array(
                        "username" => $username,
                        "fullName" => $display_name,
                        "maSo" => $ma_so,
                        "maTruongHoc" => $ma_truong_hoc,
                        "sso" => $sso,
                        "maDonVi" => $ma_don_vi,
                        "token" => $token,
                        "listCapHoc" => $response->capHocList,
                        "role" => $response->parentRole,
                        "role2" => $response->role,
                        "imgavatar" => (empty($response->user->avatar) ? asset('images/user_empty.png') : $response->user->avatar),
                    );
                    $tm = $_SERVER['HTTP_HOST'];
                    $tenmien = "https://" . $tm;

                    $thang = Carbon::now()->month;
                    $namHocHienTai = Carbon::now()->year;
                    if ($thang < 8) {
                        $namHocHienTai = $namHocHienTai - 1;
                    }
                    $common_info = array(
                        "role" => $response->parentRole,
                        "role2" => $response->role,
                        "province" => $response->province,
                        "district" => $response->district,
                        "ma_so" => $response->ma_so,
                        "ma_phong" => $response->ma_phong,
                        "sso" => $response->sso,
                        "ma_don_vi" => $response->ma_don_vi,
                        "listCapHoc" => $response->capHocList,
                        // "display_name" => $tenDacBiet,
                        "ma_truong_hoc" => $response->ma_truong_hoc,
                        "username" => $response->username,
                        "tenMien" => $tenmien,
                        "namHocHienTai" => $namHocHienTai,
                    );
                    $user_data["common_info"] = $common_info;
                    session(['user' => $user_data]);
                    Session::put('listCapHoc', $listCapHoc);
                    session(['isLoggedIn' => true]);
                    return redirect(get_first_route());
                    dd("Thực hiện đăng nhập");

                } else {
                    $tokenSend = $response->token;
                    $userNameSend = $response->username;
                    $urlSend = $response->domain??'';
                    $urlLogin = "https://" . $urlSend . "/login2?&token=" . $tokenSend . "&username=" . $userNameSend . '&id_token=' . $id_token;
                    return redirect()->away($urlLogin);
                }
            } else {
                $message = "Vui lòng thử lại sau ít phút.";
                return redirect('/')->withErrors(['password' => $message]);
            }
            dd($response);
        } catch (\Exception $ex) {
            \Log::error("Login error: " . $ex->getMessage());
            $message = "Tên tài khoản hoặc mật khẩu không chính xác.";
            return redirect('/')->withErrors(['password' => $message]);
        }

    }

    public function dangNhapSSO(Request $request)
    {
        $code = $request->get('code');
        $uriAuthToken = config("url.api_get_access_token");
        $paramsAuthToken = [
            "grant_type" => "authorization_code",
            "code" => $code,
            "client_id" => config('app.client_id'),
            "client_secret" => "csdlver2",
            "redirect_uri" => route('sso-login'),
        ];
        try {
            $resp = $this->conn->doPostJsonObject($uriAuthToken, $paramsAuthToken);
            $message = 'Tên tài khoản hoặc mật khẩu không chính xác.';

            if (!isset($resp->access_token) || (isset($resp->status) && $resp->status == 'FAIL')) {
                \Log::info("Access token req: " . json_encode($resp), []);
                return redirect('/')->withErrors(['password' => $message]);
            }
            $accessToken = $resp->access_token;
            \Log::info('Access token: ' . $accessToken, []);
            $refreshToken = $resp->refresh_token;
            $expiresIn = $resp->expires_in;
            $uri = config("url.api_login_sso");
            $params = ["accessToken" => $accessToken];
            $response = $this->conn->doGetJsonObject($uri, $params);
            $response = (object)$response;

            if ($response&&$response->domain&&$response->ma_so!=45) {
                $tokenSend = $response->token;
                $userNameSend = $response->username;
                $urlSend = $response->domain;
                $urlLogin = "https://" . $urlSend . "/login2?&token=" . $tokenSend . "&username=" . $userNameSend;
                return redirect()->away($urlLogin);
            } else {
                \Log::info('SSO login: ' . json_encode($response), []);
                if ($response == null || !isset($response->code)) {
                    // return("Không tồn tại res");
                    return redirect('/')->withErrors(['password' => $message]);
                }
                $errCode = $response->rc;
                $message = $response->rd;
                if ($errCode != 0) {
                    // return("rc khác 0");
                    session(['isLoggedIn' => false]);
                    return redirect('/')->withErrors(['password' => $message]);
                }
                $ten = $response->display_name;
                $tenDacBiet = $this->htmlspecialchars_custom($ten);
                $role = $response->parentRole;
                $role2 = $response->role;
                $username = $response->username;
                $display_name = $tenDacBiet;
                $token = $response->token;
                $sso = $response->sso;
                $ma_so = $response->ma_so;
                $ma_don_vi = $response->ma_don_vi;
                $ma_truong_hoc = $response->ma_truong_hoc;
                $list_cap_hoc = $response->capHocList;
                $cap_mam_non = false;
                if ($list_cap_hoc == [4, 5] || $list_cap_hoc == [4] || $list_cap_hoc == [5] || $list_cap_hoc == [45]) {
                    $cap_mam_non = true;
                } else {
                    $cap_mam_non = false;
                }
                $permission = isset($response->permission) ? $response->permission : [];
                $permission = json_decode(json_encode($permission));
                \Log::info('permission login: ' . json_encode($permission), []);
                $listCapHoc = [];
                if ($list_cap_hoc == null || $list_cap_hoc == []) {
                    $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
                }
                $bieuDo = [];
                $bieuDo = (object)$bieuDo;
                $bieuDo->cap_mot = false;
                $bieuDo->cap_hai = false;
                $bieuDo->cap_ba = false;
                $bieuDo->cap_mam_non = false;
                $bieuDo->cap_gdtx = false;
                if ($list_cap_hoc == null || $list_cap_hoc == []) {
                    $list_cap_hoc = [1, 2, 3, 4, 5, 45, 6];
                }
                foreach ($list_cap_hoc as $ch) {
                    if ($ch == 1) {
                        array_push($listCapHoc, ['name' => "Cấp 1", 'id' => 1]);
                        $bieuDo->cap_mot = true;
                    }
                    if ($ch == 2) {
                        array_push($listCapHoc, ['name' => "Cấp 2", 'id' => 2]);
                        $bieuDo->cap_hai = true;
                    }
                    if ($ch == 3) {
                        array_push($listCapHoc, ['name' => "Cấp 3", 'id' => 3]);
                        $bieuDo->cap_ba = true;
                    }
                    if ($ch == 4) {
                        array_push($listCapHoc, ['name' => "Nhà trẻ", 'id' => 4]);
                        $bieuDo->cap_mam_non = true;
                    }
                    if ($ch == 5) {
                        array_push($listCapHoc, ['name' => "Mẫu giáo", 'id' => 5]);
                        $bieuDo->cap_mam_non = true;
                    }
                    if ($ch == 45) {
                        array_push($listCapHoc, ['name' => "Mầm non", 'id' => 45]);
                        $bieuDo->cap_mam_non = true;
                    }
                    if ($ch == 6) {
                        array_push($listCapHoc, ['name' => "GDTX", 'id' => 6]);
                        $bieuDo->cap_gdtx = true;
                    }
                }
                session(['cate_menu' => $permission]);
                $user_data = array(
                    "username" => $username,
                    "fullName" => $display_name,
                    "server_role" => $role,
                    "maSo" => $ma_so,
                    "maTruongHoc" => $ma_truong_hoc,
                    "sso" => $sso,
                    "maDonVi" => $ma_don_vi,
                    "token" => $token,
                    "listCapHoc" => $response->capHocList,
                    "capMamNon" => $cap_mam_non,
                    "bieuDo" => $bieuDo,
                    "role" => $response->parentRole,
                    "role2" => $response->role,
                    "imgavatar" => (empty($response->user->avatar) ? asset('images/user_empty.png') : $response->user->avatar),
                );
                $tm = $_SERVER['HTTP_HOST'];
                $tenmien = "https://" . $tm;

                $thang = Carbon::now()->month;
                $namHocHienTai = Carbon::now()->year;
                if ($thang < 8) {
                    $namHocHienTai = $namHocHienTai - 1;
                }
                $common_info = array(
                    "role" => $response->parentRole,
                    "role2" => $response->role,
                    "province" => $response->province,
                    "district" => $response->district,
                    "ma_so" => $response->ma_so,
                    "ma_phong" => $response->ma_phong,
                    "sso" => $response->sso,
                    "ma_don_vi" => $response->ma_don_vi,
                    "capMamNon" => $cap_mam_non,
                    "listCapHoc" => $response->capHocList,
                    // "display_name" => $tenDacBiet,
                    "ma_truong_hoc" => $response->ma_truong_hoc,
                    "username" => $response->username,
                    "bieuDo" => $bieuDo,
                    "tenMien" => $tenmien,
                    "namHocHienTai" => $namHocHienTai,
                );
                $user_data["common_info"] = $common_info;
                session(['user' => $user_data]);
                Session::put('listCapHoc', $listCapHoc);
                session(['isLoggedIn' => true]);
                return redirect(get_first_route());
            }
        } catch (\Exception $ex) {
            \Log::error("Login error: " . $ex->getMessage());
            $message = "Tên tài khoản hoặc mật khẩu không chính xác.";
            return redirect('/')->withErrors(['password' => $message]);
        }

    }


    // Check đăng nhập
    public function CheckLogin(Request $request)
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        $dn = session('isLoggedIn');
        if ($dn) {
            
            return redirect()->route('dashboard');
        } else {
            $tm = $_SERVER['HTTP_HOST'];
            if($tm == 'csdl.bentre.edu.vn'){
                // $url = 'https://sso.bentre.edu.vn/';
                // return redirect($url);
                return redirect()->route('redirecttosso');
            }else{
                $redirect_uri = route('sso-login');
                $postLogoutRedirectUri = route('sso-logout');
                return view('login.demologin', compact('redirect_uri', 'postLogoutRedirectUri'));
            }
        }
    }

    public function redirecttosso()
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        $redirect_uri = route('sso-login');
        $postLogoutRedirectUri = route('sso-logout');
        return view('login.redirecttosso', compact('redirect_uri', 'postLogoutRedirectUri'));
    }

    public function htmlspecialchars_custom($string)
    {
        $string = str_replace("\x05\x06", "", $string);
        $string = preg_replace("/&([a-z\d]{2,7}|#\d{2,5});/i", "\x05\x06$1", $string);
        $string = htmlspecialchars($string, ENT_QUOTES);
        $string = str_replace("\x05\x06", "&", $string);

        return $string;
    }

    // Lấy captcha
    public function getCaptCha()
    {
        $url = config('url.api_lay_captcha');
        Log::alert($url);
        $response = $this->conn->requestApi($url, 'POST', array());
        if ($response == null) {
            return false;
        } else {
            return $response;
        }
    }


}
