<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseCodes;
use App\Helpers\ResponseHelper;
use App\Helpers\ResponseMessages;
use App\Http\Resources\PermissionsResource;
use App\Http\Resources\RolesResource;
use Spatie\Permission\Models\Role;

class RolesController extends BaseController
{
    /**
     * Create a new RolesController instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware(['jwt.verify']);
//        $this->middleware(['role:Super Admin'], ['only' => ['managePermissions']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $limit = request('limit', 10);
        $roles = Role::paginate((int)$limit);
        return RolesResource::collection($roles)
            ->additional(ResponseHelper::additionalInfo(ResponseMessages::ACTION_SUCCESSFUL, ResponseCodes::ACTION_SUCCESSFUL));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RolesResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store()
    {
        $data = $this->validate(request(), [
            'name' => 'required|unique:roles',
            'guard_name' => 'required',
        ]);
        $role = Role::create($data);
        return new RolesResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return RolesResource
     */
    public function show(Role $role)
    {
        return new RolesResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Role $role
     * @return RolesResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Role $role)
    {
        $data = $this->validate(request(), [
            'name' => 'sometimes|required|unique:roles,name,'.$role->id,
            'guard_name' => 'sometimes|required',
        ]);
        $role->update($data);
        return new RolesResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return void
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->sendSuccess('Resource deleted Successfully');
    }

    /**
     * get permissions of a role.
     *
     * @param Role $role
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Exception
     */
    public function permissions(Role $role)
    {
        $permissions = $role->permissions()->get();
        return PermissionsResource::collection($permissions)
            ->additional(ResponseHelper::additionalInfo(ResponseMessages::ACTION_SUCCESSFUL, ResponseCodes::ACTION_SUCCESSFUL));
    }

    /**
     * set permissions of a role.
     *
     * @param Role $role
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Exception
     */
    public function managePermissions(Role $role)
    {
        $t = $role->permissions()->toggle(request('data'));
//        return $t;
        return $this->sendSuccess('Permissons Updated Successfully');
    }
}
