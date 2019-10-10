<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/20
 * Time: 14:41
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Dy\RawUser;
use App\Models\Dy\User;
use App\Services\Helper\Pagination;
use Illuminate\Http\Request;

class DyController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pagination = new Pagination($request, User::query()->count());
        $users = User::query()->forPage($pagination->page, $pagination->per_page)->get();

        return view('dy.index', [
            'users' => $users,
            'pagination' => $pagination
        ]);
    }

    /**
     * 用户详情
     *
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request, $userId)
    {
        $user = RawUser::query()
            ->where('id', $userId)
            ->first();

        return view('dy.detail', ['user' => $user]);
    }
}
