<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/20
 * Time: 14:41
 */

namespace App\Http\Controllers\Web;

use App\Exceptions\AuthorizeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExampleRequest;
use App\Models\Admin\MemberCouponTemplate;
use App\Objects\ModelObjects\CouponTemplateListObject;
use App\Objects\ModelObjects\CouponTemplateObject;
use App\Objects\PaginationObjects\PaginateDataObject;

class ArController extends Controller
{
    /**
     * @param ExampleRequest $request
     * @return CouponTemplateListObject | CouponTemplateObject | PaginateDataObject
     */
    public function index(ExampleRequest $request)
    {
        $id = $request->get('id', null);

        if (!empty($id)) {
            $find = MemberCouponTemplate::query()
                ->where([
                    'id' => $id
                ])->first();
            return new CouponTemplateObject($find);
        } else {
            $paginate = $this->getPaginate($request);
            $find = MemberCouponTemplate::query()
                ->forPage($paginate->page, $paginate->per_page)
                ->get();
            $paginate->total = MemberCouponTemplate::query()->count();

            return PaginateDataObject::init($paginate, new CouponTemplateListObject($find));
        }
    }
}