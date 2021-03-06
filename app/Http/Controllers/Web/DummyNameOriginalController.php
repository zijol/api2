<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Modify\PostDummyNameOriginalRequest;
use App\Http\Requests\Modify\PutDummyNameOriginalRequest;
use App\Http\Requests\Modify\DeleteDummyNameOriginalRequest;
use App\Http\Requests\QueryList\ListDummyNameOriginalRequest;
use App\Http\Requests\Query\QueryDummyNameOriginalRequest;

/**
 * Class ExampleController
 * @package App\Http\Controllers\Web
 */
class DummyNameOriginalController extends Controller
{
    /**
     * @param QueryDummyNameOriginalRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(QueryDummyNameOriginalRequest $request)
    {
        $data = $request->validated();
        //
        return $this->JsonResponse($data);
    }

    /**
     * @param PostDummyNameOriginalRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(PostDummyNameOriginalRequest $request)
    {
        $data = $request->validated();
        //
        return $this->JsonResponse($data);
    }

    /**
     * @param PutDummyNameOriginalRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function put(PutDummyNameOriginalRequest $request)
    {
        $data = $request->validated();
        //
        return $this->JsonResponse($data);
    }

    /**
     * @param DeleteDummyNameOriginalRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteDummyNameOriginalRequest $request)
    {
        $data = $request->validated();
        //
        return $this->JsonResponse($data);
    }

    /**
     * @param ListDummyNameOriginalRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(ListDummyNameOriginalRequest $request)
    {
        $data = $request->validated();
        $paginate = $this->getPaginate($request);
        //
        return $this->JsonResponse([$data, $paginate]);
    }
}
