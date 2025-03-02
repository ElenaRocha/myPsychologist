<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['pass_id', 'booking_id'];

    public function pass()
    {
        return $this->belongsTo(Pass::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
