<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CheckToken
{
    /**
     * 检测Token中间件.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 解中间件
        $array = explode(' ', $request->header('Authorization'));
        try{
            $request->data = json_decode(Crypt::decryptString($array[1]));
        }catch(DecryptException $e){
            return response()->json(['status' => 'fail', 'data' => 'unknown Authorization']);
        }
        return $next($request);
    }
}
