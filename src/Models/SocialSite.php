<?php

namespace RMoore\SocialiteExtension\Models;

use RMoore\ChangeRecorder\RecordsChanges;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

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
}
