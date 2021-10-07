<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPassword;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ResetPasswordController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

     /**
   * @OA\Post(
   *     path="/update-password",
   *     operationId="UpdatePassword",
   *     tags={"Authentication"},
   *     summary="Resets password",
   *     description="This endpoint resets a user's password",
   *     @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *               required={"token", "password", "password_confirmation"},
   *                @OA\RequestBody(
   *                    required=true,
   *                    content="application/json",
   *                 ),
   *                  @OA\Property(
   *                      property="token",
   *                      type="string",
   *                  ),
   *                  @OA\Property(
   *                      property="password",
   *                      type="string",
   *                  ),
   *                  @OA\Property(
   *                      property="password_confirmation",
   *                      type="string",
   *                  ),
   *              example={"token":"ClRIsugfJCVLuQSnr", "password":"password", "password_confirmation":"password"}
   *             )
   *         )
   *     ),
   *     @OA\Response(response="200", description="Password updated successfully"),
   *     @OA\Response(response="401", description="Unauthenticated. Token Needed.")
   * )
   * @return \Illuminate\Http\Response
   */
    public function updatePassword(UpdateUserPassword $request)
    {
        return $this->validateToken($request)->pluck('email')->count() > 0 ? $this->changePassword($request) : $this->noToken();
    }

    private function validateToken($request){
        return DB::table('password_resets')->where([
            'token' => $request->passwordToken
        ]);
    }

    private function noToken() {
        return formatResponse(400, 'Invalid email or token.', false, [
            'errors'=> ['Invalid email or token']
        ]);
    }

    private function changePassword($request) {
        $userVal = $this->validateToken($request);
        $user = $this->userService->getUserQuery('email', $userVal->pluck('email'))->first();

        if (!$user) {
            return formatResponse(404, 'Invalid user.', false, ['error'=>'invalid user']);
        }

        $this->userService->updateUserPassword($user->id, [
            'password' => bcrypt($request->password),
            'password_needs_reset' => false
        ]);

        $userVal->delete();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return formatResponse(200, 'Password has been reset successfully', true);
    }
}
