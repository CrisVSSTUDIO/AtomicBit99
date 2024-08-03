<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageCreation extends Model
{
    use HasFactory;
    protected $fillable = [
        'page',
        'user_id',
        'title',
        'content'
    ];
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
// $table->string('page');
// $table->string('title');
// $table->text('content');
// $table->unsignedBigInteger('user_id');
// $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");