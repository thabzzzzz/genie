<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileCustomization extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avatar',
        'summary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
