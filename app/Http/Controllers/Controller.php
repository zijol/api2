<?php

namespace App\Http\Controllers;

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
}
