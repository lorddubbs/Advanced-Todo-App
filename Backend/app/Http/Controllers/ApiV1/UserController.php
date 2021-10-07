<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser;
use App\Http\Resources\UserResource;
use App\Services\User\UserService;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="userIndex",
     *      tags={"Users"},
     *      summary="Authority: Any | Get all Users",
     *      description="This endpoint retrieves all users",
     *      @OA\Response(
     *          response=200,
     *          description="Users retrieved",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       )
     *    )
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();

        return UserResource::collection($users);
    }

    /**
     * @OA\Put(
     *      path="/updateProfile",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Authority: User | Update authenticated User | Please use x-www-form-urlencoded for body",
     *      description="This endpoint updates the current user",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateUser")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User updated",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="Unauthorized. User not with access role",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found",
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="The given data was invalid.",
     *      ),
     *    )
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateUser  $request
     * @param  \App\Models\User  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request)
    { 
        try {
            $user = $this->userService->updateUser($request->validated());
            return formatResponse(200, 'User updated successfully.', true, new UserResource($user));
            
        } catch (\Exception $e) {
            //Log::error('Task fetch failed. Error: ', $e->getMessage());
            return formatResponse(500, 'Cannot Update User.', false, $e->getMessage());
        }
    }
}
