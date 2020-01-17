<?php

namespace App\Http\Controllers;

use App\Objects\PaginationObject;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 返回Json格式的响应
     *
     * @param $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public function JsonResponse($data, $status = 200, $headers = [])
    {
        $data = [
            'code' => 0,
            'message' => 'succeed',
            'data' => $data,
        ];
        return new JsonResponse($data, $status, $headers, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }


    /**
     * 构造 Pagination 对象
     *
     * @param Request $request
     * @param int $total
     * @return PaginationObject
     */
    protected function getPagination(Request $request, int $total = 0)
    {
        return new PaginationObject([
            'page' => $request->input('page', 1),
            'per_page' => $request->input('per_page', 10),
            'total' => $total
        ]);
    }
}
