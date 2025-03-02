<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pass extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'total_sessions', 
        'remaining_sessions', 
        'purchase_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
