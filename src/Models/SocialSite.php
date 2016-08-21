<?php

namespace RMoore\SocialiteExtension\Models;

use RMoore\ChangeRecorder\RecordsChanges;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

use Laravel\Socialite\Contracts\Factory as Socialite;

class SocialSite extends Model
{
    use RecordsChanges, SoftDeletes;
    
    protected $fillable = ['name', 'class', 'button'];

    public function getRouteKeyName(){
        return 'class';
    }

    public static function make($name, $class, $button = null){
    	return static::create(
    		[
    			'name' => $name,
    			'class' => $class,
    			'button' => $button ?: $class,
    		]
    	);
    }

    public function scopeActive($query){
    	return $query->where('active', true)->whereNotNull('app_id')->whereNotNull('app_secret');
    }


    public function redirect(){
        app(Socialite::class)->driver($this->class)->redirect();
    }

    public function user(Socialite $socialite){
        app(Socialite::class)->driver($this->class)->user();
    }

    
}
