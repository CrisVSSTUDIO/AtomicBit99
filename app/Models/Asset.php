<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory, SoftDeletes;
    protected $attributes = [
        'use_prediction' => 1,
    ];
    protected $fillable = [
        'name',
        'description',
        'upload',
        'filetype',
        'filesize',
        'filetype_prediction',
        'user_id',
        'slug',
        'use_prediction'
    ];



    public function users()

    {
        return $this->belongsToMany(User::class);
    }
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
//     protected static function boot()
//     {
//         parent::boot();

//         static::created(function () {
//             Cache::forget('assets');
//         });

//         static::updated(function () {
//             Cache::forget('assets');
//         });
//     }
}
