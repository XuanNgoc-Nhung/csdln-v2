<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
class DashBoardController extends BaseController
{
    public function dashboard(Request $request)
    {
        if(env('BAO_TRI')){
            return view("content.baotri");
        }
        $user = session("user", []);
//        dd($user);
        $role = $user['role2'];
        if($user['username']=='ad_hcm'){
            return view('dashboard.demo');
        }
        if($role==5&&$role>1){
            return view("content.dashboard_truong_hoc");
        }
        elseif ($role==1){
            return view("content.dashboard_super_admin");
        }
       else{
        return view("content.dashboard");

       }
    }
}
