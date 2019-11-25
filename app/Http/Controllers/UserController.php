<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;
use App\Repositries\UserRepository;
use App\User;

class UserController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    public function __construct(UserRepository $userRepository)
    {
//        $this->middleware(['jwt.verify']);
//        $this->middleware(['role:Super Admin'], ['only' => ['index']]);
        $this->userRepo = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $users = $this->userRepo->all();
        return UserResource::collection($users)
            ->additional(ResponseHelper::additionalInfo());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */
    public function store()
    {
        $data = $this->validate(request(), User::$rules);
        $result = array_merge($data, ['password' => bcrypt(request('password'))]);
        $user = $this->userRepo->store($result);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return UserResource
     */
    public function update(User $user)
    {
        $data = $this->validate(request(), $user->updateRules());
        unset($data['password']);
        return new UserResource($this->userRepo->update($user, $data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return UserResource
     */
    public function destroy(User $user)
    {
        return new UserResource($this->userRepo->delete($user));
    }

    /**
     * Upload resource image.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function image()
    {
        $this->userRepo->upload(request('image'));
        return $this->sendSuccess('Requested Action Successfully');
    }
}
