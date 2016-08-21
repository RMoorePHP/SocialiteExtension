<?php

namespace RMoore\SocialiteExtension\Controllers;

use Illuminate\Http\Request;

use Socialite;
use Auth;

use Config;

use RMoore\SocialiteExtension\Models\SocialLogin;
use RMoore\SocialiteExtension\Models\SocialSite;

use Session;

use RMoore\SocialiteExtension\Traits\HandlesSocialConnections;

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
        $model = Config::get('auth.providers.users.model');
        return User::register($credentials);
    }
}
