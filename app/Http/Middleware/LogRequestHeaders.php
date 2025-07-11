<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequestHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Lấy tất cả các header
        $headers = $request->headers->all();
        $time = time().'-'.$this->generateRandomString(10);
        // Log::info('Request Headers: - ['.$time .']');
        // Log::info(json_encode($headers));
        $response = $next($request);
        $responseHeaders = $response->headers->all();
        // Chuyển đổi thành JSON
        $jsonResponseHeaders = json_encode($responseHeaders);

        // Log các header response
        // Log::info('Response Headers: -[' .$time .']: ' . $jsonResponseHeaders);
        return $response;
        // return $next($request);
    }
    function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($characters, ceil($length / strlen($characters)))), 0, $length);
    }
}
