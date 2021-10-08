<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUser;
use App\Http\Resources\UserResource;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *       path="/register",
     *      operationId="createUser",
     *      tags={"Authentication"},
     *      summary="Authority: Any | Create a new user",
     *      description="Creates a new user account",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateUser")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User account created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="The given data was invalid.",
     *      ),
     *    )
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateUser  $request
     * @return \Illuminate\Http\Response
     */
    public function register(CreateUser $request)
    {
        try {
            $registerData = $request->validated();

            $registerData['password'] = bcrypt($registerData['password']);
            $user = $this->userService->createUser($registerData);

            $response['token'] = $user->createToken($user)->plainTextToken;
            $response['user'] = new UserResource($user);

            return formatResponse(201, 'User registered successfully.', true, $response);

        } catch (\Exception $e) {
            //Log::debug("Unable to register user. Error: " . $e->getMessage());
            return formatResponse(400, 'Unable to register user', false);
        }
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     summary="Authority: Any | User Login",
     *     description="Authenticate an existing user and retrieve a token.",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"email", "password"},
     *                @OA\RequestBody(
     *                    required=true,
     *                    content="application/json",
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email":"Your email address", "password":"Your password"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *        description="Successful Authentication. Access Token Returned",
     *        @OA\JsonContent(
     *              example={"success":"true", "status_code":200, "token_type": "Bearer","expires_in": 1296000,"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJyJhdWQiOiIyIiwianRpIjoiNWJmNDY4OTFhYmJmYjk1YzQwN2E1MzNkZjMxNmEzNDMzZDBlZmI2ZDc4NmI0NmMwNjgwODFjODg0N2E3MDVjYTk4ZDNiMTVlODI1ZDcwYjQiLCJpYXQiaX0...."}
     *        )
     *     ),
     *     @OA\Response(response="400", description="Bad Request")
     * )
     */
    public function login(Request $request)
    {
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

                $user = Auth::user();
                $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                $success['user'] =  new UserResource($user);

                return formatResponse(200, 'User logged in successfully.', true, $success);
            }
            return formatResponse(400, 'Unauthorized.', false, ['errors' => ['error'=> ['Wrong Email or Password']]]);

        } catch (\Exception $e) {
            Log::debug("Unable to authenticate user. Error: " . $e->getMessage());
            return formatResponse(fetchErrorCode($e), get_class($e).': '.$e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/email/verification/resend",
     *     tags={"Authentication"},
     *     summary="Authority: Any | Resend Verification link",
     *     @OA\Response(response="200", description="Verification link is sent"),
     *     @OA\Response(response="401", description="Unauthenticated. Token Needed."),
     *     @OA\Response(response="403", description="Unauthorized. User not with access role")
     * )
     */
    public function resendVerificationEmail(Request $request)
    {
        try {
            $user = $request->user();
            if ($user->hasVerifiedEmail()) { 
                return formatResponse(422, 'User already verified.', false, [
                    'error' => 'User already verified.'
                ]);
            }
            $user->sendEmailVerificationNotification();
            return formatResponse(200, 'Verification link sent', true);
            
        } catch (\Exception $e) {
            //Log::error('Failed to resend verification email. Error:', $e->getMessage());
            return formatResponse(fetchErrorCode($e), get_class($e).': '.$e->getMessage());
        }
    } 


    public function verifyUser($userId, Request $request)
    {
        try {
            $user = $this->userService->verifyUser($userId, $request);
            if(!$user)
            return formatResponse(404, 'Account not found', false, [
                "error" => "Account not found"
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to find User. Error:', $e->getMessage());
            return formatResponse(fetchErrorCode($e), get_class($e).': '.$e->getMessage());
        }
        
    }
    

    /**
     * Logout user (Revoke the token).
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *     path="/logout",
     *     tags={"Authentication"},
     *     summary="Authority: Any | Logout the currently logged in user",
     *     description="Revokes token",
     *     @OA\Response(response="200", description="User Logged out successfully"),
     *     @OA\Response(response="401", description="Unauthenticated. Token needed")
     * )
     */
    public function logout(Request $request)
    {
        try {
            $token = $request->user()->tokens()->delete();
            return formatResponse(200, 'User logged out successfully.',true);

        } catch (\Exception $e) {
            return formatResponse(fetchErrorCode($e), get_class($e).': '.$e->getMessage());
        }
    }
}
