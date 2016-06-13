<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\Request;
use App\Models\AdmUser;
use Illuminate\Support\Facades\Auth;
use Validator;
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
    protected $redirectTo = '/adm';

    protected $guard = 'admins';

    protected $loginView           = 'admin.auth.login';
    protected $registerView        = 'admin.auth.register';
    protected $redirectAfterLogout = "adm/login";
    protected $maxLoginAttempts    = '5';
    protected $lockoutTime         = '60';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware($this->guard, ['except' => 'logout']);
//    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:50',
            'email'    => 'required|email|max:255|unique:adm_users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return AdmUser::create([
                                   'username'    => $data['username'],
                                   'email'       => $data['email'],
                                   'password'    => bcrypt($data['password']),
                                   'remember'    => 'N',
                                   'register_ip' => \Request::getClientIp(),
                                   'status'      => 'N',
                                   'created_at'  => time(),
                               ]);
    }

//    public function authenticate()
//    {
//    }

    /**
     * 登陆
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {

        if (Auth::check())
        {
            return redirect($this->redirectTo);
        }
        else
        {
            return view($this->loginView);
        }
    }

    /**
     * 注册
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        if (Auth::check())
        {
            return redirect($this->redirectTo);
        }
        else
        {
            return view($this->registerView);
        }
    }

}
