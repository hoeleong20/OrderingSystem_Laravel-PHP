<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    
    protected $fillable = ['customerID', 'paymentTotal', 'paymentMethod', 'status'];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
