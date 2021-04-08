<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    /* Start Modifying Redirection Back After Success Auth "User Goes to Login Page By It Self Then Redirect Him Back" */

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    /* Set Previous Page Before Go To Login Page Manully In The Session */
    public function showRegistrationForm()
    {
        session()->put('previous_page', url()->previous());

        return view('auth.register');
    }


    /* Set Redirect Users Function */
    public function redirectTo()
    {
        $previos_page = session()->has('url.intended') ? session()->get('url.intended') : session()->get('previous_page', '/');

        return str_replace( url('/'), '', $previos_page );
    }

    /* Start Modifying Redirection Back After Success Auth "User Goes to Login Page By It Self Then Redirect Him Back" */
}
