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
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    public function getDetails()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'pax' => $this->pax,
            'datetime' => $this->datetime->format('Y-m-d H:i:s'),
            'reservation_type' => $this->reservation_type,
        ];
    }
}
