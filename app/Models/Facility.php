<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'capacity', 'location', 'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}