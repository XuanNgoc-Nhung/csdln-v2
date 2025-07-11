<?php

namespace App\Http\Controllers;

use App\Connection\ConnectionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    protected $helper;

    protected $errCodeOk = 200;
    protected $resource;

    private $shortName = "";

    public function __construct(ConnectionHelper $helper, Request $request)
    {
        $this->middleware('checkLogin:' . $this->resource);
        try {
            $this->shortName = (new \ReflectionClass($this))->getShortName();
        } catch (\ReflectionException $e) {
        }
        $this->helper = $helper;
//        dd($this->shortName);

    }

    protected function log($o)
    {
        Log::info($this->shortName . " : " . $o);
    }

    protected function log_json($msg, $json)
    {
        // Log::info($this->shortName . " : " . $msg . json_encode($json, JSON_PRETTY_PRINT));
    }

    protected function init()
    {
    }

    private function checkPermission()
    {
        if (!checkRoleUser($this->resource)) {
            Log::info("init check false ....");
            return redirect()->action('/');
        }
    }

    protected function reloadToken()
    {
        Log::info("reloadToken current token = " . get_user_info("token"));
        $url = config('url.api_admin_refresh_token');
        $params = array("username" => get_user_info("username"));
        $resp = $this->helper->doPostJsonObject($url, $params);
    }

    protected function uploadBase64($img)
    {

        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        $fileData = base64_decode($img);
        $fileName = 'photo' . time() . '.png';

        $tmpfname = tempnam(sys_get_temp_dir(), $fileName);
        $handle = fopen($tmpfname, "w");
        fwrite($handle, $fileData);
        fclose($handle);

        $gymId = get_user_info("gym_id");
        $gymBranchId = get_user_info("gym_branch_id");
        $desc = "Image avatar of admin user upload";

        $prepareFiles = [];
        $file_name = $fileName;
        $file_path = $tmpfname;
        $upload = array(
            'name' => $file_name,
            'path' => $file_path,
        );
        $prepareFiles[] = $upload;
        $this->log("prepareFiles: " . count($prepareFiles));
        $json = $this->helper->uploadImage($prepareFiles, $desc, $gymId, $gymBranchId);

        $this->log_json("upload result: ", $json);

        if (isset($json) && isset($json['code']) && $json['code'] == config("constants.ERR_CODE_OK") && !empty($json['webLinks'])) {
            $data['link'] = $json['webLinks'][0];
            $data['status'] = 1;
            return json_encode($data);
        }

        $data['status'] = -1;
        $data['msg'] = $json['message'];
        return json_encode($data);

    }
    public function getApiLink(){
        $base_api = config('app.base_url_download');
        return $base_api;
    }

}
