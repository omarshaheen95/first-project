<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Socialite;
use App\User;
use Toolkito\Larasap\SendTo;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function socialLogin($social)
 
   {
 
       return Socialite::driver($social)->redirect();
 
   }
 
   /**
 
    * Obtain the user information from Social Logged in.
 
    * @param $social
 
    * @return Response
 
    */
    public function send()
    {
        SendTo::Twitter('Hello, I\'m testing Laravel social auto posting',[],[],'347966510-jKUoM2kux9QVRnbODqUJssEXZAE3D3xcv2nMdCxf','2V3U1kgy1ZkG6Tw5IBtduejedAdyN7L9yqHKPk2bMFlTc');
    }
 
   public function handleProviderCallback($social)
 
   {
       
 
       $userSocial = Socialite::with($social)->user();
       dd($userSocial);
 
       $user = User::where(['email' => $userSocial->getEmail()])->first();
 
       if($user){
 
           Auth::login($user);
 
           return redirect()->action('HomeController@index');
 
       }else{
 
           return view('auth.register',['name' => $userSocial->getName(), 'email' => $userSocial->getEmail()]);
 
       }
 
   }
}
