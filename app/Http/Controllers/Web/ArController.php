<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/20
 * Time: 14:41
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Modify\PostArRequest;
use App\Models\Admin\ArObjectModel;

class ArController extends Controller
{
    /**
     * @param PostArRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(PostArRequest $request)
    {
        $data = $request->validated();

        $data['data'] = empty($data['data']) ? [] : $data['data'];
        $data['data'] = json_encode($data['data']);

        $data['headers'] = empty($data['headers']) ? [] : $data['headers'];
        $data['headers'] = json_encode($data['headers']);

        $time = time();
        foreach ($data['periods'] as $t) {
            $periods[] = date('Y-m-d H:i:s', $time + $t);
        }
        $data['periods'] = empty($periods) ? [date('Y-m-d H:i:s', $time)] : $periods;
        $data['time_periods'] = json_encode($data['periods']);
        $data['next_time'] = $data['periods'][0];
        (new ArObjectModel($data))->save();

        return $this->JsonResponse(true);
    }

    public function list()
    {

    }
}
