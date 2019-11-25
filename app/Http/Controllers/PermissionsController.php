<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseCodes;
use App\Helpers\ResponseHelper;
use App\Helpers\ResponseMessages;
use App\Http\Resources\PermissionsResource;
use App\Http\Resources\RolesResource;
use Spatie\Permission\Models\Permission;

class PermissionsController extends BaseController
{
    /**
     * Create a new RolesController instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware(['jwt.verify']);
//        $this->middleware(['role:Super Admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $limit = request('limit', 10);
        $permission = Permission::paginate((int)$limit);
        return PermissionsResource::collection($permission)
            ->additional(ResponseHelper::additionalInfo(ResponseMessages::ACTION_SUCCESSFUL, ResponseCodes::ACTION_SUCCESSFUL));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return PermissionsResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $data = $this->validate(request(), [
            'name' => 'required|unique:roles',
            'guard_name' => 'required',
        ]);
        $permission = Permission::create($data);
        return new PermissionsResource($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     * @return PermissionsResource
     */
    public function show(Permission $permission)
    {
        return new PermissionsResource($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Permission $permission
     * @return RolesResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Permission $permission)
    {
        $data = $this->validate(request(), [
            'name' => 'sometimes|required|unique:permissions,name,'.$permission->id,
            'guard_name' => 'sometimes|required',
        ]);
        $permission->update($data);
        return new RolesResource($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return $this->sendSuccess('Resource deleted Successfully');
    }
}
