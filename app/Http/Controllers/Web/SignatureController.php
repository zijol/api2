<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Helper\ModuleKeySecret;
use App\Services\Helper\Make;
use App\Http\Validators\Web\SignatureValidator;

class SignatureController extends Controller
{
    /**
     * 获取签名
     *
     * @param Request $request
     * @return array
     *
     * @queryParam key required 模块键 Example: api
     * @group Helper
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $validateResult = SignatureValidator::validate($data);
        if ($validateResult !== true) {
            return $validateResult;
        }

        $secret = ModuleKeySecret::getSecret($data['key']);
        unset($data['key']);
        return Make::ApiSuccess(ModuleKeySecret::sign($data, $secret));
    }
}
