<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    use HasFactory;

   

    protected $fillable = [
        'user_id',
        'game_id',
        'rating',
        'review',
    ];

    // Define relationships if necessary
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class, 'game_id');
    }
}
