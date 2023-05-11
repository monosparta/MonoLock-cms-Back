<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineSyncLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'mode',
        'error',
        'userId',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
