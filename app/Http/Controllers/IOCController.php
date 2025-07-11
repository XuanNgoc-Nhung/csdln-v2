<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Connection\ConnectionHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
class IOCController extends BaseController
{
    public function banDo(Request $request)
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        return view("ioc.ban-do");
    }
}
