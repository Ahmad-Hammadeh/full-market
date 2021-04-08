<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    /* Start Modifying Redirection Back After Success Auth "User Goes to Login Page By It Self Then Redirect Him Back" */

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    /* Set Previous Page Before Go To Login Page Manully In The Session */
    public function showLoginForm()
    {
        session()->put('previous_page', url()->previous());

        return view('auth.login');
    }

    /* Set Redirect Users Function */
    public function redirectTo()
    {
        $previos_page = session()->has('url.intended') ? session()->get('url.intended') : session()->get('previous_page', '/');

        return str_replace( url('/'), '', $previos_page );
    }

    /* Start Modifying Redirection Back After Success Auth "User Goes to Login Page By It Self Then Redirect Him Back" */

}
