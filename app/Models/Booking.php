<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'pass_id', 'booking_date', 'paid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pass()
    {
        return $this->belongsTo(Pass::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
