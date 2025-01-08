<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';
    protected $primaryKey = 'topic_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'created_by'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($topic) {
            if (!$topic->topic_id) {
                $topic->topic_id = (string) Str::uuid();
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'topic_id', 'topic_id');
    }

    public function lastPost()
    {
        return $this->hasOne(Post::class, 'topic_id', 'topic_id')->latest('updated_at');
    }
}