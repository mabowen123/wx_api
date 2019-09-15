<?php


namespace App\Http\Controllers;

use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'iv' => 'required',
            'data' => 'required',
        ]);

        $data = $request->all(['code', 'iv', 'data']);
        $config = config('wechat');
        $app = Factory::miniProgram($config);

        $sessionKey = $app->auth->session($data['code']);
        // 如果有错误码 code 过期
        if (isset($sessionKey['errcode'])) {
            return failed('code失效', -10000);
        }

        $userInfo = $app->encryptor->decryptData($sessionKey['session_key'], $data['iv'], $data['data']);
        $userInfo['nick_name'] = $userInfo['nickName'];
        $userInfo['avatar_url'] = $userInfo['avatarUrl'];
        $userInfo['session_key'] = $sessionKey['session_key'];
        unset($userInfo['watermark'], $userInfo['nickName'], $userInfo['language']);

        $user = User::query()->updateOrCreate(['open_id' => $userInfo['openId']], $userInfo);
        $token = Auth::guard('api')->fromUser($user);

        return success(['token' => $token]);
    }
}
