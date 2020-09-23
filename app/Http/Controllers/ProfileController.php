<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Web;

class ProfileController extends Controller
{
    public function updateSession($array)
    {
        $web=Web::find($array['id']);
        return $web->toArray();
    }

    /**
     * 个人信息页面
     */
    public function profile(Request $request, $op='base')
    {
        $data = $this->updateSession(session()->get('logined'));
        if($data['birthday']==null){
            $data['birthday']=0;
        }
        $data['birthday']=date('Y-m-d', $data['birthday']);

        if($op=='base'){
            return view('profile.profile', [
                'title' =>  '个人资料',
                'data' => $data,
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
        $data=$this->updateSession(session()->get('logined'));
        return view('profile.avatar', [
            'title' => '修改头像',
            'data' => $data
        ]);
    }

    /**
     * 账号安全页面
     */
    public function account()
    {
        $data=$this->updateSession(session()->get('logined'));
        $this->assign('title', '账号安全');
        $this->assign('menus', $this->checkRole());
        $this->assign('data', $data);
        return view();
    }
    

    /**
     * 个人资料保存请求
     */
    public function profileSave(Request $request)
    {
        if(!$request->has('name')){
            $name = $request->input('name');
        }else $name = null;
        if(!$request->has('gender')){
            $gender = $request->input('gender');
        }else $gender = 0;
        if(!!$request->has('birthday')){
            $date = strtotime($request->input('birthday'));
        }else $date = 0;
        if(!!$request->has('signature')){
            $signature = $request->input('signature');
        }else{
            $signature = null;
        }
        $array = session()->get('logined');
        try{
            $user = Web::find($array['id']);
            $user->name = $name;
            $user->gender = $gender;
            $user->birthday = $date;
            $user->signature = $signature;
            $user->save();
            return response()->json(['success'=>['code'=>'101', 'message' => 'update profile is success!']]);
        }catch(Exception $e){
            return response()->json(['error'=>['code'=>'001', 'message' => 'update is error!']]);
        }
    }

    /**
     * 联系方式保存请求
     */
    public function profileContactSave(Request $request)
    {
        if($request->input('qq')==""){
            $qq=null;
        }else{
            $qq = $request->input('qq');
        }
        $array = session()->get('logined');
        $user = Web::find($array['id']);
        try{
            $user->save(['qq' => $qq]);
            return response()->json(['success'=>['code'=>'101', 'message' => 'update profile is success!']]);
        }catch(Exception $e){
            return response()->json(['error'=>['code'=>'001', 'message' => 'update is error!']]);
        }
    }

    /**
     * 头像上传请求
     */
    public function avatarUpload(Request $request)
    {
        $file = $request->file('image');
        $data = session()->get('logined');
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
