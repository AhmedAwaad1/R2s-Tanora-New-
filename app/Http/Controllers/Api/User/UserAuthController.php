<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Api\User\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponsesHelper;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    use ResponsesHelper;


    public function __construct()
    {
        $this->middleware(['auth:api'])
        ->except('register', 'login', 'verifyUser');
    }

    public function register(RegisterRequest $request)
    {
        $request->merge([
            'type' => 'user',
            'code' => rand(1000,9999),
            'password' => bcrypt($request->password)
        ]);
        User::create($request->only([
            'name','phone','email','password', 'type', 'code'
        ]));

        return $this->success(['is_success'=> 1], 'Please Check Your Phone Message');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('phone', $request->phone)
        ->first();

        if (!$user)
        {
            return $this->fail(400 , 'User is not found');
        }
        if (!$user->validateForPassportPasswordGrant($request->password))
        {
            return $this->fail(400, 'Password is incorrect');
        }
        if (!$user->active)
        {
            return $this->fail(400, 'User is Deactive');
        }
        if (!$user->email_verified_at)
        {
            return $this->fail(400, 'Account is not verified');
        }
        $user['token'] = $user->createToken('Token Name')->accessToken;
        return $this->success($user, 'User is logged in');
    }

    public function verifyUser(Request $request)
    {
        $user = User::where('phone', $request->phone)
        ->first();

        if (!$user)
        {
            return $this->fail(400 , 'User is not Found');
        }
        if ($request->code == $user->code)
        {
            $user->update(['email_verified_at' => now()]);

            $user['Token'] = $user->createToken('Token name')->accessToken;
            return $this->success(['is_success'=>1],'User has been verified');
        }
        return $this->fail(400, 'User is Not Verified');
    }

    public function logout()
    {
        Auth::user()->token()->revoke();
        return $this->success(['is_success'=>1], 'User is Logged Out');
    }

    public function deactivate()
    {
        Auth::user()->update(['active'=> 0]);
        Auth::user()->token()->revoke();
        return $this->success(['is_success' => 1], 'User Has Been Deactivated');
    }

}
