<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends BaseController
{
    //
    public function listUser(Request $request)
    {
        return view('user.list-user');
    }

    public function historyCharge(Request $request)
    {
        return view('user.history_charge');
    }

    public function debtList(Request $request)
    {
        return view('user.debt_list');
    }

    public function historyPlay(Request $request)
    {
        return view('user.history_play');
    }
    public function listPhoneSearch(){
        return view('content.user.phone-search');
    }
    public function getPDF(){

    }
}
