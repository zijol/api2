<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/15
 * Time: 17:03
 */

namespace App\Http\Validators\Web;

use App\Http\Validators\BaseValidator;

class ProjectCreateValidator extends BaseValidator
{
    protected static function rules()
    {
        return [
            'name' => 'required',
            'description' => 'string'
        ];
    }
}