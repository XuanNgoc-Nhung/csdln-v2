<?php

function get_query_var($var_name)
{
    $result = "";
    if (isset($_GET[$var_name]) && count($_GET) > 0) {
        $result = $_GET[$var_name];
    }
    return $result;
}

function check_result($resp)
{
    return redirect("/logout");
}
function get_full_url(){
    return url()->full();
}
function get_user_info($info = null)
{
    if ($info == null) {
        return null;
    }
    $user = session('user', null);

    if ($user == null) {
        return null;
    }
    if (!isset($user[$info])) {
        return null;
    }
    return $user[$info];

}

function is_login()
{
//    dd(session('isLoggedIn'));
    $logged_in = session('isLoggedIn', false);
//    dd($logged_in);
    return $logged_in;
}

function check_permission($p, $action)
{
    $path = '';
    if(isset($p)){
        $path=$p;
    }
    $cate_menu = session('cate_menu', []);
    if ($cate_menu == null) {
        return false;
    }
    $path = "/" . $path;
    foreach ($cate_menu as $value) {
        if (isset($value->children)) {
            $subMenus = $value->children;
            if (sizeof($subMenus) > 0) {
                if (is_string($subMenus[0]) && $value->path == $path) {
                    foreach ($subMenus as $subMenu) {
                        if ($subMenu == $action) {
                            return true;
                        }
                    }
                } else {
                    foreach ($subMenus as $subMenu) {
                        if (isset($subMenu->children)) {
                            $actions = $subMenu->children;
                            if ($subMenu->path == $path && sizeof($actions) > 0 && is_string($actions[0])) {
                                foreach ($actions as $a) {
                                    if ($a == $action) {
                                        return true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return false;
}

function check_permission_action($path, $action)
{
    $cate_menu = session('cate_menu', []);
    if ($cate_menu == null) {
        return 0;
    }
//    dd($cate_menu);
//    $path = "/" . $path;
    foreach ($cate_menu as $value) {
//       dd($cate_menu);
        if (isset($value->path)&&$value->path!=$path){
            if (!isset($value->children)){
                continue;
            }
        }
        if (isset($value->children)) {
//            dd($value->children);
            $subMenus = $value->children;
            foreach ($subMenus as $subMenu) {
                if (isset($subMenu->path)) {
                    if ($subMenu->path != $path){
                        continue;
                    }
                    if (isset($subMenu->permission)) {
                        foreach ($subMenu->permission as $this_action)
                            if (isset($this_action->action)){
                                if ($this_action->action == $action) {
                                    return 1;
                                }
                            }
                    }
                    return 0;
                }
                return 0;
            }
        } else {
//            dd($value);
            if (isset($value->permission) && $value->path == $path) {
                if (isset($value->permission)) {
                    foreach ($value->permission as $this_action){
                        if (isset($this_action->action)){
                            if ($this_action->action == $action) {
                                return 1;
                            }
                        }
                    }
                }
            }
        }
    }
    return 0;
}

function check_access_path($p)
{

    $path = '';
    if(isset($p)){
        $path=$p;
    }
    $cate_menu = session('cate_menu', []);
//    dd($path);
//    dd($cate_menu);
    if ($cate_menu == null) {
        return false;
    }
    $path = "/" . $path;
    foreach ($cate_menu as $value) {
        $value =(object) $value;
        if (isset($value->children)) {
            $subMenus = $value->children;
            if (sizeof($subMenus) == 0 || is_string($subMenus[0])) {
                if ($value->path == $path) {
                    return true;
                }
            } else {
                foreach ($subMenus as $subMenu) {
                $subMenu =(object) $subMenu;
                    if (isset($subMenu->path)&&$subMenu->path == $path) {
                        return true;
                    }
                }
            }
        } else {
//            dd($path . " : " . $value->path);
            if ($value->path == $path) {
                return true;
            }
        }
    }
    return false;
}

function checkRoleUser($source, $action = null)
{
    error_log("checkRoleUser:");

    if (!is_login()) {
        return false;
    }

    if (get_user_info("server_role") == config('constants.ROLE_SUPER')) {
        return true;
    }

    return true;
}

function getRemainTime($start, $end)
{
    $time = $end - $start;
    $res = 0;
    if (ceil($time / 86400) / 86400 > 0) {
        $res = ceil($time / 86400);
        $time = $time % 86400;
    }
    return $res;
}

function xem($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function getDayOfWeek($dayOfWeek)
{
    if ($dayOfWeek == 'MON,TUE,WED,THU,FRI,SAT,SUN') {
        return "Cả tuần";
    }
    $days = explode(",", $dayOfWeek);
    $ret = "";
    foreach ($days as $value) {
        if ($value == 'MON') {
            $ret .= 'Thứ Hai';
        } elseif ($value == 'TUE') {
            $ret .= 'Thứ Ba';
        } elseif ($value == 'WED') {
            $ret .= 'Thứ Tư';
        } elseif ($value == 'THU') {
            $ret .= 'Thứ Năm';
        } elseif ($value == 'FRI') {
            $ret .= 'Thứ Sáu';
        } elseif ($value == 'SAT') {
            $ret .= 'Thứ Bảy';
        } elseif ($value == 'SUN') {
            $ret .= 'Chủ nhật';
        }
    }
    return $ret;
}

function get_first_route()
{
   $user = session('user', []);
   if($user['username']=='ioc_ad_thainguyen' || $user['username']=='ioc_ad_bentre' ){
    return "/ioc_dashboard_map";
   }
   else{

    return "/dashboard";
   }

//    if ($cate_menu == null) {
//        return "/";
//    }
//    foreach ($cate_menu as $menu) {
//        if (isset($menu->children) && sizeof($menu->children) > 0) {
//            return $menu->children[0]->path;
//        }
//        return $menu->path;
//    }
//    return "/";
}

function convertHttps($url){
    $redirect = config('app.redirect_https');
    if($redirect)
    {
        $url = preg_replace("/^http:/i", "https:", $url);
        return  $url;
    }
    return  $url;
}

/**
 * LZString Helper Functions
 */

/**
 * Compress string to base64 using LZString
 */
function lz_compress($string) {
    try {
        return \LZCompressor\LZString::compressToBase64($string);
    } catch (Exception $e) {
        return $string;
    }
}

/**
 * Decompress string from base64 using LZString
 */
function lz_decompress($string) {
    try {
        return \LZCompressor\LZString::decompressFromBase64($string);
    } catch (Exception $e) {
        return $string;
    }
}

/**
 * Compress string to UTF16 using LZString
 */
function lz_compress_utf16($string) {
    try {
        return \LZCompressor\LZString::compressToUTF16($string);
    } catch (Exception $e) {
        return $string;
    }
}

/**
 * Decompress string from UTF16 using LZString
 */
function lz_decompress_utf16($string) {
    try {
        return \LZCompressor\LZString::decompressFromUTF16($string);
    } catch (Exception $e) {
        return $string;
    }
}

/**
 * Compress string to encoded URI component using LZString
 */
function lz_compress_uri($string) {
    try {
        return \LZCompressor\LZString::compressToEncodedURIComponent($string);
    } catch (Exception $e) {
        return $string;
    }
}

/**
 * Decompress string from encoded URI component using LZString
 */
function lz_decompress_uri($string) {
    try {
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    } catch (Exception $e) {
        return $string;
    }
}
?>
