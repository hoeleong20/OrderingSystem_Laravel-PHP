<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'name', 'phone', 'email', 'number_of_pax', 'datetime', 'reservation_type'
    ];

    public function reservable(){
        return $this->morphTo();
    }
}
