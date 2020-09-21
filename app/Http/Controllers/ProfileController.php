<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Web;

class ProfileController extends Controller
{
    /**
     *  检测Session
     */
    public function checkSession()
    {
        if(!session()->has('logined')){
            // abort(403, '请您登录!');
            return redirect('/');
        }
    }

    public function uploadSession($array)
    {
        $web=Web::find($array['id']);
        return $web->toArray();
    }

    /**
     * 个人信息页面
     */
    public function profile($op='base')
    {
        $this->checkSession();
        $data = $this->uploadSession(session()->get('logined'));
        if($data['birthday']==null){
            $data['birthday']=0;
        }
        $data['birthday']=date('Y-m-d', $data['birthday']);

        if($op=='base'){
            return view('profile.profile', [
                'title' =>  '个人资料',
                'data' => $data
            ]);
        }else if($op=='contact'){
            return view('profile.profile_contact', [
                'title' =>  '个人资料',
                'data' => $data
            ]);
        }else{
            abort('参数错误');
        }
    }

    /**
     * 修改头像页面
     */
    public function avatar()
    {
        if(empty(Session::get('logined'))){
            $this->redirect('profile/userinfo');
        }
        $data=$this->uploadSession(Session::get('logined'));
        $this->assign('title', '修改头像');
        $this->assign('menus', $this->checkRole());
        $this->assign('data', $data);
        return view();
    }

    /**
     * 账号安全页面
     */
    public function account()
    {
        if(empty(Session::get('logined'))){
            $this->redirect('profile/userinfo');
        }
        $data=$this->uploadSession(Session::get('logined'));
        $this->assign('title', '账号安全');
        $this->assign('menus', $this->checkRole());
        $this->assign('data', $data);
        return view();
    }
    
    public function profileSave()
    {
        if(!empty($_POST['name'])){
            $name = $_POST['name'];
        }else $name = null;
        if(!empty($_POST['gender'])){
            $gender = $_POST['gender'];
        }else $gender = 0;
        if(!empty($_POST['birthday'])){
            $date = strtotime($_POST['birthday']);
        }else $date = 0;
        if(!empty($_POST['signature'])){
            $signature = $_POST['signature'];
        }else $signature = null;
        $array = Session::get('logined');
        $user = new Web;
        try{
            $user->save([
                'name' => $name,
                'gender' => $gender,
                'birthday' => $date,
                'signature' => $signature
            ], ['id' => $array['id']]);
            return "success";
        }catch(Exception $e){
            return "error";
        }
    }

    public function profileContactSave()
    {
        if($_POST['qq']==""){
            $qq=null;
        }else $qq = $_POST['qq'];
        $array = Session::get('logined');
        $user = new Web;
        try{
            $user->save([
                'qq' => $qq,
            ], ['id' => $array['id']]);
            return "success";
        }catch(Exception $e){
            return "error";
        }
    }

    public function avatarUpload()
    {
        $file = request()->file('image');        
        $data = Session::get('logined');
        if($file){
            $info = $file->validate(['ext'=>'jpg,jpeg,png', 'type'=>'image/png,image/jpeg'])->move(ROOT_PATH . 'public' . DS . 'files'. DS. 'uploads'. DS. $data['username']. DS. 'avatarsHistory'. DS, time());
            if($info){
                $image = Image::open($info);
                try{
                $info2 = $image->thumb(200, 200, 2)->save(ROOT_PATH . 'public' . DS . 'files'. DS. 'uploads'. DS. $data['username']. DS. 'avatar_200.jpg');
                $info3 = $image->thumb(38, 38, 2)->save(ROOT_PATH . 'public' . DS . 'files'. DS. 'uploads'. DS. $data['username']. DS. 'avatar_38.jpg');
                }catch(Exception $e){
                    return 'error5';
                }
                $path = 'files/uploads/'.$data['username'].'/';
                if($info2&&$info3){
                    $user = new Web;
                    try{
                        $user->save([
                            'avatar_url' => $path
                        ], ['id' => $data['id']]);
                        return "success";
                    }catch(Exception $e){
                        return "error4";
                    }
                }else return 'error3';
            }else{
                return 'error2';
            }
        }else{
            return 'error';
        }
    }
}
