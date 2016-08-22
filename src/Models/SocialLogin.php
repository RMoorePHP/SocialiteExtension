<?php

namespace RMoore\SocialiteExtension\Models;

use Config;
use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    protected $fillable = ['provider_id', 'social_site_id', 'user_id'];

    public function user()
    {
        $model = config('auth.providers.users.model');

        return $this->belongsTo($model);
    }
}
