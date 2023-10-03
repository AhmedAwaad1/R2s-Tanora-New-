<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function home()
    {
        return view('admin.dashboard');
    }

    public function loginAdmin(LoginRequest $request)
    {
        $user = User::where('phone', '=', $request->phone)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->put('loginId', $user->id);
                return redirect('/home');
            } else {
                return back()->with('fail', 'This Password is incorrect!');
            }
        } else {
            return back()->with('fail', 'This Phone is not Registed');
        }
    }

    public function Logout()
    {
        if (session::has('loginId')) {
            session::pull('loginId');
            return redirect('login');
        }
    }

}
