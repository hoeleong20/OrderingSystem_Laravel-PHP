<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['table_number', 'capacity'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class); // A table can have many reservations
    }
}