<?php


namespace App\Http\Controllers\Rest;


class GetProcessor extends BaseRest
{

    function request()
    {

//        if (!defined("BASE_URL_API")) {
//            define("BASE_URL_API", env("BASE_URL_API"));
//        }
        $redirect = config('app.base_url_api');
        $data = json_decode(json_encode($this->data), true);
        $resp = $this->connection->doGet($redirect. $this->path, $data);
        return json_encode($resp);
    }
}
