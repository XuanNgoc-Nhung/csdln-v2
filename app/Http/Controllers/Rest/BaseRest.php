<?php


namespace App\Http\Controllers\Rest;


use App\Connection\ConnectionHelper;

abstract class BaseRest
{
    protected $path;
    protected $data;
    protected $connection;

    public function __construct(ConnectionHelper $helper, $path, $data)
    {
        $this->connection = $helper;
        $this->path = $path;
        $this->data = $data;
    }

    abstract function request();

}