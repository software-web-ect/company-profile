<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        return view('user.homepage', ['user' => User::findOrFail($id)]);
    }

    public function __construct(UserRepository $user)
    {
        $this->middleware('auth');

        $this->middleware('log')->only('homepage');

        $this->middleware('subscribed')->except('store');

        $this->user= $user;
    }

    public function store(Request $request)
    {
        $name = $request->input('name');

        return redirect()->action(
            'UserController@homepage', ['id' => 1]
        );
     }

    public function storeSecret(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->fill([
            'secret' => encrypt($request->secret),
        ])->save();
    }
}
