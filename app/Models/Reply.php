<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reply) {
            if (!$reply->reply_id) {
                $reply->reply_id = (string) Str::uuid();
            }
        });
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
} 