<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Notifications\Notifiable;


class User extends Model implements AuthenticatableContract, CanResetPassword
{
    use HasFactory, CanResetPasswordTrait, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'login',
        'email',
        'password',
        'role_id',
        'display_name',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->user_id) {
                $user->user_id = (string) Str::uuid();
            }
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    public function getAuthIdentifier()
    {
        return $this->user_id;
    }

    public function getAuthPassword(){
        return $this->password_hash;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value){
        $this->remember_token = $value;
    }

    public function getRememberTokenName(){
        return 'remember_token';
    }
    /**
     * @inheritDoc
     */
    public function getAuthPasswordName() {
        return 'password_hash'; 
    }
}