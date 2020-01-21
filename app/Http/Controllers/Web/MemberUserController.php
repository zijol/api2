<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Admin\MemberUserModel;
use App\Http\Requests\Modify\PostMemberUserRequest;
use App\Http\Requests\Modify\PutMemberUserRequest;
use App\Http\Requests\Modify\DeleteMemberUserRequest;
use App\Http\Requests\QueryList\ListMemberUserRequest;
use App\Http\Requests\Query\QueryMemberUserRequest;
use App\Objects\ModelObjects\MemberUserListObject;
use App\Objects\ModelObjects\MemberUserObject;
use App\Objects\PaginationObjects\PaginateDataObject;
use App\Exceptions\NotFoundException;

/**
 * Class MemberUserController
 * @package App\Http\Controllers\Web
 */
class MemberUserController extends Controller
{
    /**
     * @param QueryMemberUserRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException
     */
    public function get(QueryMemberUserRequest $request, $id)
    {
        $data = $request->validated();
        $findMode = MemberUserModel::query()->find($id);
        if (empty($findMode)) {
            throw new NotFoundException('未找到对象 ' . $id);
        }
        return $this->JsonResponse(new MemberUserObject($findMode));
    }

    /**
     * @param PostMemberUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(PostMemberUserRequest $request)
    {
        $data = $request->validated();
        $newModel = (new MemberUserModel($data));
        $newModel->save();
        return $this->JsonResponse(new MemberUserObject($newModel));
    }

    /**
     * @param PutMemberUserRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException
     */
    public function put(PutMemberUserRequest $request, $id)
    {
        $data = $request->validated();
        $findMode = MemberUserModel::query()->find($id);
        if (empty($findMode)) {
            throw new NotFoundException('未找到对象 ' . $id);
        }
        $findMode->setMa($data)->save();
        return $this->JsonResponse(new MemberUserObject($findMode));
    }

    /**
     * @param DeleteMemberUserRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException
     */
    public function delete(DeleteMemberUserRequest $request, $id)
    {
        $data = $request->validated();
        $findMode = MemberUserModel::query()->find($id);
        if (empty($findMode)) {
            throw new NotFoundException('未找到对象 ' . $id);
        }
        $findMode->delete();
        return $this->JsonResponse(true);
    }

    /**
     * @param ListMemberUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(ListMemberUserRequest $request)
    {
        $data = $request->validated();
        $paginate = $this->getPaginate($request);
        $query = MemberUserModel::query();
        $paginate->total = $query->count();
        $list = $query->forPage($paginate->page, $paginate->per_page)->get();
        $paginateDataObject = PaginateDataObject::initWithPaginate($paginate, new MemberUserListObject($list));
        return $this->JsonResponse($paginateDataObject);
    }
}

