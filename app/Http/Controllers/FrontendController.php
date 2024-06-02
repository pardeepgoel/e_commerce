<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function productPage(Request $request)
    {
       

       

        $token = $request->session()->get('token');
       

        return view('product-page',compact('token'));
    }
}
