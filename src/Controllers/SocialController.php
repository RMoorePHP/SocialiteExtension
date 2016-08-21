<?php

namespace RMoore\SocialiteExtension\Controllers;


use RMoore\SocialiteExtension\Traits\HandlesSocialConnections;

use Illuminate\Routing\Controller;

class SocialController extends Controller
{
	use HandlesSocialConnections;

    protected function userValidation(){
        return [
            'username' => 'required|unique:users|max:25',
            'email' => 'required|unique:users|unique:email_addresses|email',
            'password' => 'confirmed'
        ];
    }

    protected function registerUser(){        
        $model = config('auth.providers.users.model');
        return User::register($credentials);
    }

    protected function loginUser($user){
        if($user->google2fa_confirmed){
            session('user_id', $user->id);
            return redirect('/auth/2fa');
        }
        auth()->login($user);
        return redirect('/');
    }
}
