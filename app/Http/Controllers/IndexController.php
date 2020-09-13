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

    public function about()
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
}
