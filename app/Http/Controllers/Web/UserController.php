<?php
/**
 * Created by PhpStorm.
 * User: zjiol
 * Date: 2019-06-14
 * Time: 21:49
 */

namespace App\Http\Controllers\Web;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Modes\Irt\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ForbiddenException
     * @throws \Throwable
     */
    public function login(LoginRequest $request)
    {
        $params = $request->validated();

        $user = User::query()
            ->where([
                'user_name' => $params['name']
            ])->first();

        // 用户存在
        if ($user) {
            if ($user->password != $params['password']) {
                if ($user->login_err_times >= 5) {
                    throw new ForbiddenException('登陆错误超过5次，禁止登陆');
                } else {
                    $user->login_err_times = $user->login_err_times + 1;
                    $user->save();
                    throw new ForbiddenException('密码错误 ' . ($user->login_err_times) . ' 次');
                }
            } else {
                $token = Uuid::uuid1();
                $user->login_at = date('Y-m-d H:i:s');
                $user->login_err_times = 0;
                $user->access_token = $token;
                $user->save();
            }

            // 无效用户
        } else {
            throw new ForbiddenException('用户不存在');
        }

        return self::JsonResponse($token);
    }

    /**
     * 获取用户信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $token = $request->header('irt_access_token');

        if (empty($token)) {
            $token = $request->all('irt_access_token');
        }

        $info = null;
        if (!empty($token)) {
            $user = User::query()
                ->select(User::$infoFields)
                ->where('user_access_token', $token)
                ->first();
            if ($user) {
                $info = $user;
            }
        }

        return self::JsonResponse($info);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->header('irt_access_token');

        if (empty($token)) {
            $token = $request->all('irt_access_token');
        }

        if (!empty($token)) {
            User::query()
                ->where('irt_access_token', $token)
                ->update(['irt_access_token' => '']);
        }

        return self::JsonResponse(true);
    }
}
