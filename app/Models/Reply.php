<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'replies';
    protected $primaryKey = 'reply_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'content',
        'post_id',
        'created_by'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
    public function lastReply()
    {
        return $this->hasOne(Reply::class, 'post_id', 'post_id')->latest();
    }
} 