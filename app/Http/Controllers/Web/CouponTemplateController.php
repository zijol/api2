<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\QueryList\ListCouponTemplateRequest;
use App\Http\Requests\Modify\PostCouponTemplateRequest;
use App\Models\Admin\CouponTemplateModel;
use App\Objects\ModelObjects\CouponTemplateListObject;
use App\Objects\PaginationObjects\PaginateDataObject;

/**
 * Class CouponTemplateController
 * @package App\Http\Controllers\Web
 */
class CouponTemplateController extends Controller
{
    /**
     * @param ListCouponTemplateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(ListCouponTemplateRequest $request)
    {

//        $data = ['a','b','c'];
//
//        foreach($data as $k=>$v){
//            $v = &$data[$k];
//        }
//        var_dump($data);

        $a = "aabbcczz"; $a++; echo $a;
//        $paginate = $this->getPaginate($request);
//        $paginate->total = CouponTemplateModel::query()->count();
//        $find = CouponTemplateModel::query()->forPage($paginate->page, $paginate->per_page)->get();
//        $paginateDataObject = PaginateDataObject::initWithPaginate($paginate, new CouponTemplateListObject($find));
//        return $this->JsonResponse($paginateDataObject);
    }

    /**
     * @param PostCouponTemplateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(PostCouponTemplateRequest $request)
    {
        $data = $request->validated();
        (new CouponTemplateModel($data))->save();
        return $this->JsonResponse(true);
    }
}
