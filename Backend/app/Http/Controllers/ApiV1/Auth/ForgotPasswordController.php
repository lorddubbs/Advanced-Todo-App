<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\PasswordResetTokenMail;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *       path="/reset-password-request",
     *      operationId="passwordReset",
     *      tags={"Authentication"},
     *      summary="Password reset email",
     *      description="This endpoint sends the user a password reset email",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email"},
     *              @OA\Property(property="email", type="string", format="email", example="peter_oduntan@yahoo.com")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Kindly check your inbox, we have sent a password reset link."
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Email does not exist.",
     *      ),
     *    )
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPasswordRequest(Request $request)
    {
        $email = $request->email;
        $emailValid = $this->userService->getUserQuery('email', $request->email)->first();

        if (!$emailValid) {
            return formatResponse(404, 'Email does not exist.', false, ['error'=>'invalid email']);
        }

        $token = $this->createToken($email);

        Mail::to($email)->send(new PasswordResetTokenMail($token));

        return formatResponse(201, 'Kindly check your inbox, we have sent a password reset link.', true);
    }

    protected function createToken($email)
    {
        $isToken = DB::table('password_resets')->where('email', $email)->first();

        if($isToken) {
            return $isToken->token;
        }

        $token = Str::random(80);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        return $token;
    }
}
