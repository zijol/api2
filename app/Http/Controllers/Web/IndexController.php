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
use App\Objects\ListObject;
use App\Objects\ModelObjects\CouponTemplateListObject;

class IndexController extends Controller
{
    /**
     * @param ExampleRequest $request
     * @return ListObject
     */
    public function index(ExampleRequest $request)
    {
        $find = MemberCouponTemplate::query()->get();
        return new CouponTemplateListObject($find);
    }
}
