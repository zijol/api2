<?php

namespace App\Http\Requests\QueryList;

use App\Http\Requests\BaseRequest;

/**
 * Class ListArRequest
 * @package App\Http\Requests\QueryList
 */
class ListArRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return array_merge([
            //
        ], $this->paginateRules());
    }
}
