<?php

namespace RMoore\SocialiteExtension\Models;

use Illuminate\Database\Eloquent\Model;

use Config;

class SocialLogin extends Model
{
	protected $fillable = ['provider_id', 'social_site_id', 'user_id'];

    public function user(){    	     
        $model = Config::get('auth.providers.users.model');
    	return $this->belongsTo($model);
    }
}
