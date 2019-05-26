<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/30
 * Time: 10:50
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Services\Helper\Make;

class DocController extends Controller
{
    public function index()
    {
        $config = json_decode(File::get(config('doc.config')), true);
        $str = file_get_contents(config('doc.template'));
        $str = (new \Parsedown())->parse($str);
        return view('doc', ['content' => $str, 'config' => $config]);
    }

    public function get(Request $request, $type, $tag)
    {
        $pares = new \Parsedown();
        $str = file_get_contents(config('doc.path') . '/' . $type . '/' . $tag . '.md');
        $str = $pares->parse($str);
        return Make::ApiSuccess($str);
    }
}
