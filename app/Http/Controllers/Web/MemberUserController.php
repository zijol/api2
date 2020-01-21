<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Modify\PostMemberUserRequest;
use App\Http\Requests\Modify\PutMemberUserRequest;
use App\Http\Requests\Modify\DeleteMemberUserRequest;
use App\Http\Requests\QueryList\ListMemberUserRequest;
use App\Http\Requests\Query\QueryMemberUserRequest;
use App\Models\Admin\MemberUserModel;
use App\Objects\ModelObjects\MemberUserListObject;
use App\Objects\ModelObjects\MemberUserObject;
use App\Objects\PaginationObjects\PaginateDataObject;

/**
 * Class MemberUserController
 * @package App\Http\Controllers\Web
 */
class MemberUserController extends Controller
{
    /**
     * @param QueryMemberUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws NotFoundException
     */
    public function get(QueryMemberUserRequest $request)
    {
        $data = $request->validated();
        $memberUser = MemberUserModel::query()
            ->find($data['id']);
        if (empty($memberUser)) {
            throw new NotFoundException('未找到用户 ' . $data['id']);
        }
        return $this->JsonResponse(new MemberUserObject($memberUser));
    }

    /**
     * @param PostMemberUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(PostMemberUserRequest $request)
    {
        $data = $request->validated();
        //
        return $this->JsonResponse($data);
    }

    /**
     * @param PutMemberUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function put(PutMemberUserRequest $request)
    {
        $data = $request->validated();
        //
        return $this->JsonResponse($data);
    }

    /**
     * @param DeleteMemberUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(DeleteMemberUserRequest $request)
    {
        $data = $request->validated();
        //
        return $this->JsonResponse($data);
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
        $list = $query->forPage($paginate->page, $paginate->per_page)->get();
        $paginate->total = $query->count();
        $paginateDataObject = PaginateDataObject::initWithPaginate($paginate, new MemberUserListObject($list));
        return $this->JsonResponse($paginateDataObject);
    }
}

