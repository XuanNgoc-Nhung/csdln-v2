<?php


namespace App\Http\Controllers\Rest;


class HttpProcessorManager
{
    private static $singletonObj = null;

    public static function getInstance()
    {
        if (self::$singletonObj !== null) {
            return self::$singletonObj;
        }

        self::$singletonObj = new self();
        return self::$singletonObj;
    }

    public function getProcessor($conn, $method, $path, $data)
    {   
        \Log::info($method);
        switch ($method) {
            case "POST":
                return new PostJsonProcessor($conn, $path, $data);
            case "PUT":
                return new PutJsonProcessor($conn, $path, $data);
            case "DELETE":
                return new DeleteJsonProcessor($conn, $path, $data);
            case "GET":
                return new GetProcessor($conn, $path, $data);
            default:
                return null;
        }
    }
    public function getProcessor2($conn, $method, $path, $data)
    {

        switch ($method) {
            case "POST":
                return new PostJsonProcessor2($conn, $path, $data);
            case "GET":
                return new GetProcessor2($conn, $path, $data);
            default:
                return null;
        }
    }
}