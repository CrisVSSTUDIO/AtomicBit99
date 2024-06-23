<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metadata extends Model
{
    use HasFactory;

    protected $fillable = [

        'asset_id',
        'last_accessed_at'
    ];



    public function assets()
    {
        return $this->belongsTo(Asset::class);
    }
}
