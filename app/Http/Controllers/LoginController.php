<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function verify()
    {     
        $captcha = new Captcha();
        $captcha->captcha();
    }
    
}
