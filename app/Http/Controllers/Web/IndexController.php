<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/20
 * Time: 14:41
 */

namespace App\Http\Controllers\Web;

use App\Exceptions\AuthorizeException;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExampleRequest;
use App\Models\Dy\RawUser;
use App\Models\Dy\User;
use App\Models\Dy\UserFollowers;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * @param ExampleRequest $request
     */
    public function index(ExampleRequest $request)
    {
        throw (new AuthorizeException('Welcome to zijol api.'))
            ->withHeaders(['author' => 'zijol']);
    }

    /**
     * 关注列表
     *
     * @param Request $request
     * @param $userUniqueId
     * @return \Illuminate\Http\JsonResponse
     */
    public function guanZhuList(Request $request, $userUniqueId)
    {
        $user = User::query()
            ->where([
                'unique_id' => $userUniqueId
            ])->first();

        if (empty($user)) {
            return $this->JsonResponse(null);
        }


        $userFollowers = UserFollowers::query()
            ->where([
                'uid' => $user->id
            ])->forPage($request->input('page', 1))
            ->get()->toArray();

        $followersIdList = array_column($userFollowers, 'follow_uid');

        $list = RawUser::query()
            ->whereIn('id', $followersIdList)
            ->get();

        return $this->JsonResponse($list);
    }
}
