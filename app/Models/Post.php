<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Reply;

class Post extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'content',
        'status',
        'created_by',
        'topic_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (!$post->post_id) {
                $post->post_id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'topic_id');
    }

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    public function isOpen()
    {
        return $this->status === 'open';
    }

    public function postsCount()
    {
        return $this->posts()->count();
    }
    public function lastPost()
    {
        return $this->posts()->latest()->first();
    }
    public function lastReply()
    {
        return $this->hasOne(Reply::class, 'post_id', 'post_id')->latest();
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'post_id', 'post_id');
    }

    public function repliesCount()
    {
        return $this->replies()->count();
    }
}