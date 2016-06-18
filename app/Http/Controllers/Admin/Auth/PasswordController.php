<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdmUser;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use libraries\CommonFunc;
use Symfony\Component\HttpFoundation\JsonResponse;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $guard = 'admin';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guard);
    }

    /**
     * Reset the given user's password.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetLoginUser()
    {

        $credentials = [
            'old_password' => Input::get('old_password'),
            'new_password' => Input::get('new_password')
        ];

        //is logined
        if (!Auth::guard($this->guard)->check())
        {
            return JsonResponse::create(['error' => Lang::get('auth.loginError')], 422);
        }

        // format
        if (empty($credentials['old_password']))
        {
            return JsonResponse::create(['old_password' => Lang::get('auth.emptyPassword')], 422);
        }
        if (empty($credentials['new_password']))
        {
            return JsonResponse::create(['new_password' => Lang::get('auth.emptyPassword')], 422);
        }

        // account
        $email = Auth::guard($this->guard)->user()->email;
        $user  = AdmUser::whereEmail($email)
                        ->wherePassword(CommonFunc::makeMd5Auth($credentials['old_password']))
                        ->first();
        if (empty($user))
        {
            return JsonResponse::create(['old_password' => Lang::get('auth.invalidPasswordError')], 422);
        }

        // the same password
        if (CommonFunc::makeMd5Auth($credentials['old_password']) == CommonFunc::makeMd5Auth
            ($credentials['new_password'])
        )
        {
            return JsonResponse::create(['new_password' => Lang::get('auth.resetSamePasswordError')], 422);
        }

        //update login
        $isOk = $user->update(['password' => CommonFunc::makeMd5Auth($credentials['new_password'])]);
        if (!$isOk)
        {
            return JsonResponse::create(['error' => Lang::get('auth.resetPasswordError')], 422);
        }
        else
        {
            return JsonResponse::create(['success' => Lang::get('auth.success')], 200);
        }
    }

}
