<?php

namespace App\Http\Controllers\Rest;

class PostJsonProcessor2 extends BaseRest
{

    function request()
    {

        // \Log::info('PostJsonProcessor:');
        $params = $this->data;
        $resp = $this->connection->doPost($this->path, $params);
        return json_encode($resp);
    }
}
