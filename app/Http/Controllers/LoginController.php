<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Web;
use Illuminate\Support\Facades\DB;
use Cookie;

class LoginController extends Controller
{
    public function verify()
    {     
        $captcha = new Captcha();
        $captcha->captcha();
    }
    

    public function checkCode()
    {
        if(empty($_POST['code'])){
            return false;
        }
        $code = strtolower($_POST['code']);
        if(session()->get('verify_code')==null){
            return false;
        }
        if($code==session()->get('verify_code')){
            return true;
        }else{
            return false;
        }
    }

    public function register(Request $request)
    {   
        if(!$request->has('code')){
            return response()->json(["error"=>['code'=>001,'message'=>'code is empty!']]);
        }
        if(!$request->has('phone_email')){
            return response()->json(["error"=>['code'=>002,'message'=>'email is empty!']]);
        }

        $code = strtolower($request->input('code'));
        $phoneEmail = $request->input('phone_email');

        if(!session()->has('verify_code')){
            return response()->json(["error"=>['code'=>003,'message'=>'verify code is empty!']]);
        }
        if($code!=session()->get('verify_code')){
            return response()->json(["error"=>['code'=>004,'message'=>'The code is incorrect!']]);
        }
        if($this->cehckUserIs($phoneEmail)){
            return response()->json(["error"=>['code'=>005,'message'=>'user already exists!']]);
        }
        if(preg_match('/^1[3-9]\d{9}$/', $phoneEmail)){
            session()->set('phone', $phoneEmail);
            session()->set('reg_state', '1');
            if($this->sendCodeSms()){
                return $phoneEmail;
            }else{
                return response()->json(["error"=>['code'=>006,'message'=>'server is error!']]);
            };
        }else if(preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/', $phoneEmail)){
            session()->set('email', $phoneEmail);
            session()->set('reg_state', '0');
            if($this->sendCodeEmail()){
                return $phoneEmail;
            }else{
                return response()->json(["error"=>['code'=>007,'message'=>'server is error!']]);
            };
        }else{
            return response()->json(["error"=>['code'=>003,'message'=>'phone or email is incorrect!']]);
        };
    }
    /**
     * 检查用户是否存在
     * @param string 用户登录名
     * @return true|false
     */
    public function cehckUserIs($login)
    {
        $res = Web::where('phone', $login)
                ->whereor('email', $login)
                ->whereor('username', $login)
                ->find();
        if($res){
            return 1;
        }else return 0;
    }


    public function sendCodeSmsEmail()
    {
        if(session()->get('reg_state')){
            $this->sendCodeSms();
        }else $this->sendCodeSmsEmail();
    }

    /**
     * 这里调用了PHPMailer发送邮件
     * @return true|false 返回是否成功
     */
    public function sendCodeEmail()
    {
        //此类涉及个人账户
        $sm = new SendEmail();
        $res = $sm->sendCodeEmail(session()->get('email'));
        if($res==0){
            return 1;
        }else return 0;
    }
    /**
     * 这里是调用阿里云的短信服务
     * @return true|false 返回是否成功
     */
    public function sendCodeSms()
    {
        //此类涉及个人账户
        $sm = new SendSms();
        $res = $sm->sendCodeSms(session()->get('phone'));
        if($res==0){
            return 1;
        }else return 0;
    }

    public function register2()
    {
        if(empty($_POST['code'])){
            return "error";
        }
        if(empty($_POST['password'])){
            return "error";
        }
        $code = $_POST['code'];
        $p = $_POST['password'];
        if(!((strlen($p)>7&&strlen($p)<21)&&((preg_match('/\d/', $p)&&preg_match('/[a-zA-Z]/', $p))||(preg_match('/[a-zA-Z]/', $p)&&preg_match('/\W/', $p))||(preg_match('/\d/', $p)&&preg_match('/\W/', $p))))){
            return "error2";
        }
        if(session()->get('reg_state')){
            if(session()->get('sms_code')==null||session()->get('phone')==null){
                return "error";
            }
            if($code!=session()->get('sms_code')){
                return "error1";
            }
            $phone = session()->get('phone');
            $state = $this->regCreatePhone($phone, $p);
            if($state!=0){
                    $res = Web::get($state);
                    $array = $res->toArray();
                    session()->set('logined', $array);
                    return "success";
            }else return "error";
        }else{
            if(session()->get('email_code')==null||session()->get('email')==null){
                return 'error';
            }
            if($code!=session()->get('email_code')){
                return "error1";
            }
            $email = session()->get('email');
            $state = $this->regCreateEmail($email, $p);
            if($state!=0){
                $res = Web::get($state);
                $array = $res->toArray();
                session()->set('logined', $array);
                return "success";
            }else return "error";
        }
    }
    
    /**
     * 在数据库中创建用户
     * @param string $phone 电话号码
     * @param string $passwd 账号密码
     * @return integer|false
     */

    public function regCreatePhone($phone, $passwd)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $username = "";
        for ($i = 0; $i < 6; $i++ ){
            $username .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        $username .= $phone;

        $user = new Web;
        $user->username = $username;
        $user->password = md5($passwd);
        $user->phone = $phone;
        try{
            if($user->save()){
                return $user->id;
            }else return 0;
        }catch(Exception $e){
            return 0;
        }
        
    }

    /**
     * 在数据库中创建用户
     * @param string $email 邮箱
     * @param string $passwd 账号密码
     * @return integer|false
     */
    public function regCreateEmail($email, $passwd)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $username = "";
        for ($i = 0; $i < 6; $i++ ){
            $username .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        $str = explode("@", $email);
        $username .= $str[0];

        $user = new Web;
        $user->username = $username;
        $user->password = md5($passwd);
        $user->email = $email;
        try{
            if($user->save()){
                return $user->id;
            }else return 0;
        }catch(Exception $e){
            return 0;
        }
        
    }

    public function login(Request $request)
    {
        if(!$request->has('login_i')){
            return response()->json(["error"=>['code'=>001,'message'=>'login_i is empty!']]);
        }
        if(!$request->has('password')){
            return response()->json(["error"=>['code'=>002,'message'=>'password is empty!']]);
        }
        $login = $request->input('login_i');
        $passwd = $request->input('password');

        try{
        $web = Web::where('phone', $login)
                ->orWhere('email', $login)
                ->orWhere('username', $login)
                ->first();
        if(empty($web)){
            return response()->json(["error"=>['code'=>003,'message'=>'User not found!']]);
        }
        $array = $web->toArray();
        }catch(Exception $e){
            return response()->json(["error"=>['code'=>004,'message'=>'Database exception!']]);
        }
        if($array['phone']==$login&&$array['password']==md5($passwd)||$array['email']==$login&&$array['password']==md5($passwd)||$array['username']==$login&&$array['password']==md5($passwd)){
            session()->put('logined', $array);
            if($request->input('login_state')==1){
                $code = $this->code();
                Cookie::queue('last_login_username', $login, 10080);
                Cookie::queue("login_token", $code, 10080);
                Cookie::queue("loginstate", 1, 10080);
                try{
                    $web = Web::find($array['id']);
                    $web->login_token = $code;
                    $web->save();
                }catch(Exception $e){
                    return response()->json(["error"=>['code'=>005,'Database exception!']]);
                }
            }
            return response()->json(["success"=>['code'=>101,'message'=>'Success login!']]);
        }else{
            return response()->json(["error"=>['code'=>006,'message'=>'user or password is error!']]);
        }
    }

    /**
     * 检测用户session是否存在
     */
    public function cookieLogin(Request $request)
    {
        if(session()->has('logined')){
            return response()->json(['error'=>['code'=>001, 'message'=>'']]);
        }
        if($request->cookie('last_login_username')!=null&&$request->get('login_token')!=null){
            $login=$request->cookie('last_login_username');
            $login_token=$request->cookie('login_token');
            try{
                $res = Web::where('phone', $login)
                        ->whereor('email', $login)
                        ->whereor('username', $login)
                        ->find();
            if(empty($res)){
                return "error1";
            }
            $array = $res->toArray();
            }catch(Exception $e){
                return "error";
            }
            if($array['login_token']==$login_token){
                if(Cookie::has('loginstate')){
                    if(Cookie::get('loginstate')==1){
                        $code = $this->code();
                        Cookie::set('last_login_username', $login, ['expire'=>604800]);
                        Cookie::set("login_token", $code, ['expire'=>604800]);
                        Cookie::set("loginstate", 1, ['expire'=>604800]);
                        try{
                            $user = Web::get($array['id']);
                            $user->login_token = $code;
                            $user->save();
                        }catch(Exception $e){
                            return 'error';
                        }
                    }
                }
                session()->set('logined', $array);
                return 'success';
            }
        }return 'error';
    }

    /**
     * @return string 随机码
     */
    public function code()
    {
        $data = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $code ='';
        for($i=0;$i<64;$i++){
            $fontContext = substr($data, rand(0, strlen($data)-1), 1);
            $code .= $fontContext;
        }
        return $code;
    }

    public function test()
    {
        $web = Web::where('phone', '')
                    ->orWhere('email', '707636381@qq.com')            
        ->first();
        dump(
            // Web::where('phone', '1889288054')
            
            $web->toArray()
        );
    }
}
