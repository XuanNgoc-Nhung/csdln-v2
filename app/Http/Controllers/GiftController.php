<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GiftController extends BaseController
{
    public function index(){
        return view('content.gift.index');
    }
    public function history(){
        return view('content.gift.history');
    }
    public function sendgift(){
        return view('content.gift.sendgift');
    }
}
