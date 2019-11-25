<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Events\NewCustomerEvent;
use App\Events\NewMessageEvent;
use App\Events\PasswordRecoveryEvent;
use App\Mail\WelcomeNewUserMail;
use App\Repositries\UserRepository;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Helpers\ResponseMessages;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseHelper;
use App\Helpers\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\Roles;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends BaseController
{
    /**
     * @var UserService
     */
    private $userRepository;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
//        $this->middleware(['jwt.verify'], ['except' => ['login', 'register', 'socialite']]);
        // $this->middleware(['role:User'], ['only' => ['me']]);
        $this->userService = $userRepository;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login()
    {
        $this->validate(request(), [
            'email'=>'required|email',
            'password' => 'required'
        ]);
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return $this->sendError(ResponseMessages::LOGIN_FAIL, ResponseCodes::LOGIN_FAIL, [], ResponseCodes::UNPROCESSABLE_ENTITY);
        }
        JWTAuth::setToken($token);
        return new UserResource(auth()->user());
    }

    /**
     * Get the authenticated User.
     *
     * @return UserResource
     */
    public function me()
    {
        return new UserResource(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->logout();

        return ResponseHelper::createSuccessResponse([], ResponseMessages::ACTION_SUCCESSFUL);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = auth()->refresh();
        JWTAuth::setToken($token);
        return $this->sendSuccess('Token Successfully refreshed');
    }


    public function register()
    {
       $data = $this->validate(request(), User::$rules);

        $result = array_merge($data, ['username' => request('username') ?? Str::random(8), 'password' => bcrypt(request('password'))]);
        $user = $this->userService->store($result);

        $this->userService->autoLogin($user);
        return new UserResource(auth()->user());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return UserResource|\Illuminate\Http\Response
     */
    public function socialite(Request $request)
    {
        $driver = $request->input('type');
            try {
                $socialUser = Socialite::driver($driver)->userFromToken($request->input('idToken'));
                $existUser = User::where('email', $socialUser->email)->first();

                if ($existUser) {
                    $user = User::find($existUser->id);
                    $token = auth()->login($user);
                } else {
                    $names = explode(' ', $socialUser->name);
                    $user = User::create([
                        'username' => Helper::random_username($socialUser->name),
                        'email' => $socialUser->email,
                        'fname' => $names[0],
                        'lname' => $names[1],
                        'password' => bcrypt(rand(1, 10000))
                    ]);
                    $token = auth()->login($user);
                }
                JWTAuth::setToken($token);
                return new UserResource(auth()->user());
            } catch (Exception $e) {
                return ResponseHelper::createErrorResponse([], ResponseMessages::LOGIN_FAIL);
            }
    }

    /**
     * Change Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(User $user)
    {
        if (!password_verify(request('old_password'), $user->password)) {
            return $this->sendError("Incorrect Password", 401);
        }

        $this->validate(request(), [
            'new_password' => 'required|confirmed|min:6'
        ]);

        $user->update(["password" => bcrypt(request('password'))]);

        return $this->sendSuccess('Password Updated Successfully');
    }

    /**
     * Change Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword()
    {

        $this->validate(request(), [
            'email' => 'required|email'
        ]);

        $user = User::where('email', \request('email'))->first();
        if (!$user){
            return $this->sendError("We cannot find this Email", 401);
        }
        event(new PasswordRecoveryEvent($user));
        return $this->sendSuccess('Password Recovery Email Sent');
    }

    /**
     * Change Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(User $user)
    {
        if (!password_verify(request('old_password'), $user->password)) {
            return $this->sendError("Incorrect Password", 401);
        }

        $this->validate(request(), [
            'new_password' => 'required|confirmed|min:6'
        ]);

        $user->update(["password" => bcrypt(request('password'))]);

        return $this->sendSuccess('Password Updated Successfully');
    }
}
