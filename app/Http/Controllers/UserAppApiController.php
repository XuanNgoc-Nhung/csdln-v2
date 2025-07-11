<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/26/2019
 * Time: 11:08 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserAppApiController extends BaseController
{
    public function getListUserApp(Request $request)
    {
        $params = array(
            'start' => $request->get("start"),
            'key' => $request->get("key"),
            'limit' => $request->get("limit"),
        );
        $uri = config('url.get_list_user_app');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }

//Chi tiết 1 user
    public function findOneUser(Request $request)
    {
        $params = array(
            'username' => $request->get("username"),
        );
        $uri = config('url.find_detail_user');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }

//Thành tích của 1 user
    public function getAchievementUserApp(Request $request)
    {
        $params = array(
            'username' => $request->get("username"),
        );
        $uri = config('url.api_get_achievement_user');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }


    //Lịch sử trừ cước
    public function getChargeHistory(Request $request)
    {
        $params = array(
            'phone' => $request->get("phone"),
            'status' => $request->get("status"),
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
        );
        $uri = config('url.api_view_charge_history');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    } //Danh sách nợ cước

    public function getDebt(Request $request)
    {
        $params = array(
            'phone' => $request->get("phone"),
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
        );
        $uri = config('url.api_get_debt');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }

    //Lịch sử chơi game
    public function getPlayHistory(Request $request)
    {
        $params = array(
            'username' => $request->get("username"),
            'start' => $request->get("start"),
            'limit' => $request->get("limit"),
        );
        $uri = config('url.api_view_play_history');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }

    //Cập nhật tài khoản
    public function updateUserApp(Request $request)
    {
        $params = array(
            'username' => $request->get("username"),
            'display_name' => $request->get("display_name"),
            'url_avatar' => $request->get("url_avatar"),
            'address' => $request->get("address"),
            'gender' => $request->get("gender"),
        );
        $uri = config('url.api_update_user_app');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    //Khóa tài khoản
    public function lockUserApp(Request $request)
    {
        $params = array(
            'username' => $request->get("username"),
        );
        $uri = config('url.api_lock_user_app');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    //Mở khóa tài khoản
    public function unlockUserApp(Request $request)
    {
        $params = array(
            'username' => $request->get("username"),
        );
        $uri = config('url.api_unlock_user_app');
        $resp = $this->helper->doPost($uri, $params);
        return json_encode($resp);
    }

    //Tra cứu thông tin thuê bao
    public function findPhoneInformation(Request $request)
    {
        $params = array(
            'phone' => $request->get("phone"),
            'status' => $request->get("status"),
            'start' => $request->get("start"),
            'limit' => $request->get("limit "),
        );
        $uri = config('url.find_phone_information');
        $resp = $this->helper->doGet($uri, $params);
        return json_encode($resp);
    }
}
