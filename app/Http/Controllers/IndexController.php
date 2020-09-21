<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Cookie;

class IndexController extends Controller
{
    public function index()
    {
        return view('index.index');
    }

    public function about(Request $request)
    {
        return view('index.about');
    }

    public function bbs()
    {
        return view('index.bbs');
    }

    public function contact()
    {
        return view('index.contact');
    }

    public function checkLogined()
    {
        if(session()->get('logined')!=null){
            return response()->json(['error'=>['code'=>1, 'message'=>'Logged in']]);
        }else{
            return response()->json(['error'=>['code'=>0, 'message'=>'unlogged']]);
        }
    }

    public function logout()
    {
        session()->flush();
        Cookie::queue('login_token', '');
        return redirect('/');
    }

    public function checkSession()
    {
        if(!session()->has('logined')){
            $data = session()->get('logined');
            $this->assign('data', $data);
        }else  $this->assign('data', ['avatar_url'=>null]);
    }

    
    
}
