<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Rest\HttpProcessorManager;
use Illuminate\Http\Request;
use LZCompressor\LZString;

class ApiGatewayController extends BaseController
{
    public function request(Request $request)
    {
        $data = $request->get("data");
        $data = LZString::decompressFromBase64($data);
        $path = $request->get("path");
        $method = $request->get("method");

        $this->log_json("data = ", $data);

        $processor = HttpProcessorManager::getInstance()->getProcessor($this->helper, $method, $path, $data);
        if ($processor != null) {
            return $processor->request();
        }
        return null;
    }
    
    public function request2(Request $request)
    {
        $path = $request->get("path");
        $method = $request->get("method");
        $data = $request->get("data");
        
        // Decompress data if it's compressed
        if (!empty($data)) {
            $data = LZString::decompressFromBase64($data);
        }

        $this->log_json("data = ", $data);

        $processor = HttpProcessorManager::getInstance()->getProcessor2($this->helper, $method, $path, $data);
        if ($processor != null) {
            return $processor->request();
        }
        return null;
    }
}
