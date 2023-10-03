<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Models\Admin\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        $users = User::get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(CreateRequest $request)
    {
         User::create([
             'name' => $request['name'],
             'email' => $request['email'],
             'phone' => $request['phone'],
             'password' => Hash::make($request['password'])
         ]);
         $request->session()->flash('alert-success', 'User has been Created' );
         return redirect('admin/users');
    }


    public function edit($id)
    {
        return view('admin.user.edit', ['user' =>User::find($id)]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::where('id', $id)
        ->first();

        if (!$user){
            return redirect('admin/users')
                ->with('alert-fail', 'User is not Found');
        }

        $user->update($request->only([
            'name', 'phone', 'email'
        ]));
        return redirect('/admin/users')
            ->with('alert-success', 'User have been updated');
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user)
        {
            return redirect('admin/users')
                ->with('alert-fail', 'User is not deleted');
        }
        $user->delete();
        return redirect('admin/users')
            ->with('alert-success', 'User have been deleted');
    }
}
