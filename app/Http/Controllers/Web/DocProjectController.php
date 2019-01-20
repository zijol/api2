<?php
/**
 * Created by PhpStorm.
 * User: ping123
 * Date: 19/1/20
 * Time: 14:41
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\ApiDoc\DocProjectModel;
use App\Services\Helper\ErrorCode\ErrorCode;
use App\Services\Helper\Make;
use Illuminate\Http\Request;
use App\Http\Validators\Web\ProjectCreateValidator;

class DocProjectController extends Controller
{
    /**
     * 创建项目
     *
     * 新建一个项目
     *
     * @param Request $request
     * @return array|bool
     *
     * @bodyParam project_name string required 项目名称
     * @bodyParam project_description string required 项目描述
     * @group Doc
     */
    public function post(Request $request)
    {
        $data = $request->all();
        $validateResult = ProjectCreateValidator::validate($data);
        if ($validateResult !== true) {
            return $validateResult;
        }
        $data = ProjectCreateValidator::getValidatedData();

        // 如果项目已经存在
        $find = DocProjectModel::query()->where('project_name', '=', $data['name'])->first();
        if ($find) {
            return Make::ApiFail(ErrorCode::PROJECT_ALREADY_EXIST);
        }

        $project = new DocProjectModel();
        $project->setRawAttributes([
            'project_name' => $data['name'],
            'project_description' => $data['description'],
        ]);

        if ($project->save()) {
            return Make::ApiSuccess($project->toArray());
        } else {
            return Make::ApiFail(ErrorCode::CREATE_PROJECT_FAIL);
        }
    }

    /**
     * 项目详情
     *
     * 获取到项目详情，参数id和name，必须传一个，优先使用id进行查询
     * @param Request $request
     * @return array
     *
     * @queryParam id optional 项目ID
     * @queryParam name optional 项目名称
     * @group Doc
     */
    public function detail(Request $request)
    {
        $data = $request->all();

        $project = null;
        if (isset($data['id'])) {
            $project = DocProjectModel::query()
                ->where('project_id', '=', $data['id'])
                ->first();
        } else if (isset($data['name'])) {
            $project = DocProjectModel::query()
                ->where('project_name', '=', $data['name'])
                ->first();
        }

        return Make::ApiSuccess($project ? $project->toArray() : []);
    }

    public function get()
    {

    }

    public function delete()
    {

    }

    public function put()
    {

    }
}
