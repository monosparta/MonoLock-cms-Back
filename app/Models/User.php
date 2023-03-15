<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cardId',
        'phone',
        'name',
        'mail',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public $incrementing = false;
    
    public $keyType = 'string';

    public static function boot(){
        parent::boot();
    
        static::creating(function ($issue) {
            $issue->id = Str::uuid(36);
        });
    }

    public function Locker()
    {
        return $this->hasOne(Locker::class, 'userId', 'id');
    }

    public function Record()
    {
        return $this->hasMany(Record::class, 'userId', 'id');
    }
}
