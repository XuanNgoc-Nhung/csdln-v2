<?php


namespace App\Http\Controllers\Rest;


class GetProcessor2 extends BaseRest
{

    function request()
    {
        // \Log::info('GetProcessor:');
        $data = json_decode(json_encode($this->data), true);
        $resp = $this->connection->doGet($this->path, $data);
        return json_encode($resp);
    }
}
