<?php


namespace App\Http\Controllers\Rest;


class DeleteJsonProcessor extends BaseRest
{


    function request()
    {

//        if (!defined("BASE_URL_API")) {
//            define("BASE_URL_API", env("BASE_URL_API"));
//        }

        $redirect = config('app.base_url_api');
        $this->path = $redirect . $this->path;
        $params = $this->data;
        $resp = $this->connection->doDelete($this->path, $params);
        return json_encode($resp);
    }
}
