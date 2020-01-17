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
use App\Objects\PaginateDataObject;

class IndexController extends Controller
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
            $pagination = $this->getPagination($request);
            $find = MemberCouponTemplate::query()
                ->forPage($pagination->page, $pagination->per_page)
                ->get();
            $pagination->total = MemberCouponTemplate::query()->count();

            return PaginateDataObject::init($pagination, new CouponTemplateListObject($find));
        }
    }
}
