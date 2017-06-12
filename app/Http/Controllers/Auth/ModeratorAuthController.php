<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Moderator;

class ModeratorAuthController extends Controller
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
     * Where to redirect users after login / registration / logout.
     *
     * @var string
     */
    protected $redirectTo = 'moderator';

    protected $redirectAfterLogout = '/moderator/login';

    /**
     * The guard to be used for validation.
     *
     * @var string
     */

    protected $guard = 'moderator';

    /**
     * The Login form view that should be used.
     *
     * @var string
     */

    protected $loginView = 'moderator.auth.login';

    /**
     * The Register form view that should be used.
     *
     * @var string
     */

    protected $registerView = 'moderator.auth.register';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guestmoderator', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:providers',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $moderator = Moderator::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'timezone'=>$data['timezone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_available' => 1,
            'is_activated' => 1
        ]);

        return $moderator;
    }

    protected function authenticated(Request $request, Moderator $moderator){

        if(\Auth::guard('moderator')->check()) {
            if($moderator = Moderator::find(\Auth::guard('moderator')->user()->id)) {
                // $moderator->is_activated == 0);
                if ($moderator->is_activated == 0) {
                    \Auth::guard('moderator')->logout();
                    return back()->with('flash_errors', tr('moderator_disable'));
                }
                $moderator->timezone = $request->has('timezone') ? $request->timezone : '';
                $moderator->save();
            }   
        };
       return redirect()->intended($this->redirectPath());
    }
}
