<?php

namespace App\Http\Requests\QueryList;

use App\Http\Requests\BaseRequest;

class ListArRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return $this->paginateRules();
    }
}
