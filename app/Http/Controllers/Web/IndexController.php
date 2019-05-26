<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/20
 * Time: 14:41
 */

namespace App\Http\Controllers\Web;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function index(StoreBlogRequest $request)
    {
        Log::stack(['daily'])
            ->info('good', ['a' => 'asd']);
        return [];
        throw new ForbiddenException('不可访问', 4014);
//        $params = $request->validated();
//        return $params;
    }
}
