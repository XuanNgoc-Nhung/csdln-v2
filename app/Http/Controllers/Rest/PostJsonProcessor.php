<?php

namespace App\Http\Controllers\Rest;

class PostJsonProcessor extends BaseRest
{

    function request()
    {

//        if (!defined("BASE_URL_API")) {
//            define("BASE_URL_API", env("BASE_URL_API"));
//        }

        $redirect = config('app.base_url_api');
        // \Log::info('PostJsonProcessor:');
        $this->path = $redirect . $this->path;
        $params = $this->data;
        $resp = $this->connection->doPost($this->path, $params);
        return json_encode($resp);
    }
}
