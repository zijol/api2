<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/10
 * Time: 15:48
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Helper\Encryption;
use App\Services\Helper\ErrorCode\ErrorCode;
use App\Services\Helper\Make;
use Illuminate\Http\Request;

class EncryptionController extends Controller
{
    /**
     * 密码加密
     *
     * @param Request $request
     *
     * @queryParam words required 需要加密的明文内容
     * @group Helper
     * @return array
     */
    public function encrypt(Request $request)
    {
        $requestData = $request->toArray();
        if (isset($requestData['words']) && !empty($requestData['words'])) {
            return Make::ApiSuccess(Encryption::encryptPassword($requestData['words'], env('API_ENCRYPTION_KEY')));
        } else {
            return Make::ApiFail(ErrorCode::MISS_PARAM, 'words');
        }
    }

    /**
     * @param Request $request
     *
     * @queryParam words required 加密的内容
     * @group Helper
     *
     * @return array
     */
    public function decrypt(Request $request)
    {
        $requestData = $request->toArray();
        if (isset($requestData['words']) && !empty($requestData['words'])) {
            return Make::ApiSuccess(Encryption::decryptPassword($requestData['words'], env('API_ENCRYPTION_KEY')));
        } else {
            return Make::ApiFail(ErrorCode::MISS_PARAM, 'words');
        }
    }
}
