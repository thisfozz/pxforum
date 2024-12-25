<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'topic_id');
    }

    // Дополнительный метод для удобного использования статусов
    public function getStatusAttribute($value)
    {
        return ucfirst($value); // Форматируем статус (например, 'open' в 'Open')
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
}