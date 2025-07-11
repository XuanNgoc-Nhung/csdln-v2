<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends BaseController
{
    public function index(Request $request)
    {
        return view('content.category_index');
    }
}
