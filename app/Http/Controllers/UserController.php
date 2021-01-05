<?php

namespace App\Http\Controllers;

use App\User;
use App\Rules\MatchPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show the register form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegisterForm() {
        return view('user.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $this->validate($request, [
            'username' => [ 'required', 'string', 'unique:users,username', 'min:5' ],
            'email' => [ 'required', 'string', 'email', 'unique:users,email' ],
            'password' => [ 'required', 'string', 'confirmed', 'min:8' ],
            'address' => [ 'required', 'string', 'min:10' ],
            'gender' => [ 'required' ],
            'dob' => [ 'required' ],
        ]);

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->is_admin = false;
        $user->save();

        return redirect()->route('user.login');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        return view('user.login');
    }

    /**
     * Authenticate user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        $result = Auth::attempt(
            $request->only('email', 'password'),
            $request->input('remember') === 'on',
        );

        if ($result === false) {
            return redirect()->route('login')->withErrors([
                'message' => 'Invalid Credentials',
            ]);
        }


        if ($request->remember === 'on') {
            Cookie::queue('rememberedEmail', $request->email, 7 * 24 * 60);
        }

        return redirect()->route('home');
    }

    /**
     * Unauthenticate user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        Auth::logout();
        return redirect()->route('user.login');
    }

    /**
     * Show current user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        return $this->show(Auth::id());
    }

    /**
     * Display requested user profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return view('user.profile');
    }
}