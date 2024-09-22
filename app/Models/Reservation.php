<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'pax',
        'datetime',
        'reservation_type',
        'extrax_info'
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];
}
