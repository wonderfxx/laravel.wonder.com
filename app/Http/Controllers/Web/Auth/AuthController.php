<?php

namespace App\Http\Controllers\Web\Auth;

use libraries\CommonFunc;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\JsonResponse;
use Validator;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo          = '/';
    protected $guard               = 'web';
    protected $loginView           = 'web.auth.login';
    protected $registerView        = 'web.auth.register';
    protected $redirectAfterLogout = "login";
    protected $maxLoginAttempts    = '5';
    protected $lockoutTime         = '60';

    /**
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function registerAction()
    {

        $rules = [
            'username' => 'required|max:50',
            'email'    => 'required|email|max:255|unique:adm_users',
            'password' => 'required|min:6',
        ];

        $credentials = [
            'username' => Input::get('username'),
            'email'    => Input::get('email'),
            'password' => Input::get('password'),
        ];

        //is logined
        if (Auth::guard($this->guard)->check())
        {
            return JsonResponse::create(['success' => Lang::get('auth.success')], 200);
        }

        // format
        $validator = Validator::make($credentials, $rules);
        if (!$validator->passes())
        {
            return JsonResponse::create($validator->messages(), 422);
        }

        // account
        $data = User::create([
                                    'username'    => $credentials['username'],
                                    'email'       => $credentials['email'],
                                    'password'    => CommonFunc::makeMd5Auth($credentials['password']),
                                    'remember'    => 'N',
                                    'register_ip' => \Request::getClientIp(),
                                    'status'      => 'N',
                                    'created_at'  => time(),
                                ]);
        if (!empty($data))
        {
            \Session::set('verify_email', $credentials['email']);

            return JsonResponse::create(['success' => Lang::get('auth.success')], 200);
        }
        else
        {
            return JsonResponse::create(['email' => Lang::get('auth.registerError')], 422);
        }
    }

    /**
     * Check User Login
     *
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function loginAction()
    {

        $rules       = [
            'email'    => 'required|email',
            'password' => 'required'
        ];
        $credentials = [
            'email'    => Input::get('email'),
            'password' => Input::get('password')
        ];

        //is logined
        if (Auth::guard($this->guard)->check())
        {
            return JsonResponse::create(['success' => Lang::get('auth.success')], 200);
        }

        // format
        $validator = Validator::make($credentials, $rules);
        if (!$validator->passes())
        {
            return JsonResponse::create(['email' => Lang::get('auth.invalidFormatError')], 422);
        }

        // account
        $isValidEmail = AdmUser::whereEmail($credentials['email'])->first();
        if (empty($isValidEmail))
        {
            return JsonResponse::create(['email' => Lang::get('auth.invalidEmailError')], 422);
        }

        // password
        $user = AdmUser::whereEmail($credentials['email'])
                       ->wherePassword(CommonFunc::makeMd5Auth($credentials['password']))
                       ->first();

        if (empty($user))
        {
            return JsonResponse::create(['password' => Lang::get('auth.invalidPasswordError')], 422);
        }

        // verifing
        if ($user->status == 'N')
        {
            \Session::set('verify_email', $credentials['email']);

            return JsonResponse::create(['error' => Lang::get('auth.verifingError')], 302);
        }

        // login
        Auth::guard($this->guard)->login($user);
        if (!Auth::guard($this->guard)->check())
        {
            return JsonResponse::create(['error' => Lang::get('auth.loginError')], 422);
        }
        else
        {
            //update login
            $user->update(['login_ip' => \Request::getClientIp(), 'updated_at' => time()]);

            return JsonResponse::create(['success' => Lang::get('auth.success')], 200);
        }
    }

    /**
     * 登陆验证
     * @return mixed
     */
    public function verifyAction()
    {
        if (Auth::guard($this->guard)->check())
        {
            return redirect($this->redirectTo);
        }

        return view('web.auth.verify');
    }

    /**
     * 登陆
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {

        if (!Auth::guard($this->guard)->check())
        {
            return view($this->loginView);
        }
        else
        {
            return redirect($this->redirectTo);
        }
    }

    /**
     * 注册
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        if (!Auth::guard($this->guard)->check())
        {
            return view($this->registerView);
        }
        else
        {
            return redirect($this->redirectTo);
        }
    }

}
