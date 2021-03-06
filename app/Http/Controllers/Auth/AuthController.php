<?php

namespace App\Http\Controllers\Auth;

use App\ActivityPoint;
use App\Alerts;
use App\Objective;
use App\sweetcaptcha;
use App\Task;
use App\Unit;
use App\User;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\SiteActivity;
use Hashids\Hashids;

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
    protected $redirectTo = '/';

    /**
     * Where user redirect after successfully logout
     */
    protected $redirectAfterLogout = '/login';
    
    public $sweetcaptcha;

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        view()->share('user_login',\Auth::check());
        $this->sweetcaptcha =new  sweetcaptcha(
            env('SWEETCAPTCHA_APP_ID'),
            env('SWEETCAPTCHA_KEY'),
            env('SWEETCAPTCHA_SECRET'),
            public_path('sweetcaptcha.php')
        );
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
//            'first_name' => 'required|max:255',
//            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'user_name' => 'required|min:6',
            'g-recaptcha-response' => 'required|recaptcha',
            /*'country'=>'required',
            'state'=>'required',
            'city'=>'required',*/
        ]);

        $validator->after(function($validator) use ($data) {
            $name=$data['user_name'];
            $fetch=User::where('username',$name)->count();
            if($fetch > 0)
                $validator->errors()->add('username_duplicate', 'The username already exist in system.');
        });
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $userData=User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'username' => $data['user_name'],
            'country_id' => 231,
            'state_id' => 3924,
            'city_id' => 43070,
            'password' => bcrypt($data['password']),
            'role'=>'user'
        ]);

        $toEmail = $data['email'];
        $toName= $data['first_name'].' '.$data['last_name'];
        $subject="Welcome to Javul.org";

        \Mail::send('emails.registration', ['userObj'=> $userData, 'report_concern' => false], function($message) use ($toEmail,$toName,$subject)
        {
            $message->to($toEmail,$toName)->subject($subject);
            $message->from(\Config::get("app.notification_email"), \Config::get("app.site_name"));
        });

        $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
        $user_id = $userIDHashID->encode($userData->id);
        SiteActivity::create([
            'user_id'=>$userData->id,
            'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower($userData->first_name.'_'.$userData->last_name)).'">'
            .$userData->username.'</a> created an account'
        ]);

        Alerts::create([
            'user_id' => $userData->id,
            'all' => 0,
            'account_creation' => 0,
            'confirmation_email' => 0,
            'forum_replies' => 1,
            'watched_items' => 1,
            'inbox' => 1,
            'fund_received' => 1,
            'task_management' => 1,
        ]);

        return $userData;

    }

    public function showRegistrationForm()
    {
        view()->share('sweetcaptcha',$this->sweetcaptcha);
        return view('auth.register');
    }

    /**
     * Method will called after login successfully into system
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated( \Illuminate\Http\Request $request, \App\User $user ) {
        return redirect()->intended($this->redirectPath());
    }

    //Login via Username and Email Address.
    public function login(Request $request)
    {
        $validator = Validator::make(\Request::all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        $field = filter_var(\Request::input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        \Request::merge([$field => \Request::input('email')]);

        if (\Auth::attempt(\Request::only($field, 'password'))){
            // dd($field);
            return redirect('/');
        }


        return redirect('/login')->withErrors([
            'error' => 'These credentials do not match our records.',
        ]);
    }

}
