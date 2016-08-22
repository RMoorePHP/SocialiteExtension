<?php

namespace RMoore\SocialiteExtension\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RMoore\ChangeRecorder\RecordsChanges;

class SocialSite extends Model
{
    use RecordsChanges, SoftDeletes;

    protected $fillable = ['name', 'class', 'button'];

    public function getRouteKeyName()
    {
        return 'class';
    }

    public static function make($name, $class, $button = null)
    {
        return static::create(
            [
                'name'   => $name,
                'class'  => $class,
                'button' => $button ?: $class,
            ]
        );
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->whereNotNull('app_id')->whereNotNull('app_secret');
    }
}
