<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * 解token
     *
     * @param string $token
     * @return array
     */
    public function deToken(String $token)
    {
        
    }

    /**
     * 生成token
     *
     * @param array $date
     * @return string
     *
     */
    public function getToken(Array $data)
    {
        $token = Crypt::encryptString(json_encode($data));
        return $token;
    }


    /**
     * 成功
     *
     * @param mixed $result
     * @return void
     */
    public function success($result = '')
    {
        return response()->json(['status' => 'success', 'data' => $result ]);
    }

    /**
     * 失败返回
     *
     * @param string $msg
     * @return void
     */
    public function fail($msg = '')
    {
        return response()->json(['status' => 'fail', 'data' => $msg]);
    }
}
