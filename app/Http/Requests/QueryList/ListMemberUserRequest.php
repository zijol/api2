<?php

namespace App\Http\Requests\QueryList;

use App\Http\Requests\BaseRequest;

/**
 * Class ListMemberUserRequest
 * @package App\Http\Requests\QueryList
 */
class ListMemberUserRequest extends BaseRequest
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
