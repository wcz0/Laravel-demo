<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

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
        if(Session::get('logined')!=null){
            return "logined";
        }else return "notlogin";
    }

    public function logout()
    {
        session()->flush();
        // Cookie::set('login_token', "");
        return redirect('/');
    }

    public function checkSession()
    {
        if(Session::get('logined')){
            $data = Session::get('logined');
            $this->assign('data', $data);
        }else  $this->assign('data', ['avatar_url'=>null]);
    }

    
    
}
