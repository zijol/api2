<?php

namespace App\Http\Requests\Modify;

use App\Rules\ID;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

/**
 * Class PutExampleRequest
 * @package App\Http\Requests\Modify
 */
class PutDummyNameOriginalRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [
                'required', 'integer', new ID('example')
            ],
            //
        ];
    }
}
