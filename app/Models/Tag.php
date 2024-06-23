<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'tag_name',
        'user_id
        '
    ];
    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
