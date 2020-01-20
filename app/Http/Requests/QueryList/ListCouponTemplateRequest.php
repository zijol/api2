<?php

namespace App\Http\Requests\QueryList;

use App\Http\Requests\BaseRequest;

class ListCouponTemplateRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return $this->paginateRules();
    }
}
