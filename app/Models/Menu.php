<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Decorators\MenuInterface; // For the Decorator pattern
use App\Decorators\DecoratorFactory; // Factory for handling decorators

// Author : Lim Jia Qing

class Menu extends Model implements MenuInterface
{
    use HasFactory;

    // Table definition
    protected $table = 'menu';
    protected $primaryKey = 'menu_code'; // Specify the primary key column
    public $incrementing = false; // Disable auto-incrementing since menu_code is not an integer
    protected $keyType = 'string'; // Specify the type of the primary key

    // Fillable fields for mass assignment
    protected $fillable = [
        'menu_code',
        'name',
        'desc',
        'price',
        'status',
        'remarkable'
    ];

    protected $casts = [
        'remarkable' => 'array', // Cast remarkable as an array (JSON)
    ];

    // The following methods are for the Decorator pattern

    // Concrete Component implementation for the Decorator pattern
    protected $name;
    protected $description;
    protected $price;

    // Constructor for the Decorator pattern's Concrete Component
    public function __construct($name = null, $description = null, $price = null)
    {
        parent::__construct();

        // Assign values only when using the decorator
        if ($name && $description && $price) {
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
        }
    }

    // Get the menu description (used in the Decorator pattern)
    public function getDescription()
    {
        return $this->description;
    }

    // Get the menu price (used in the Decorator pattern)
    public function getPrice()
    {
        return $this->price;
    }

    // Functionality where the decorator pattern comes into play for calculating price
    public function calculatePrice($selectedRemarks = [])
    {
        $totalPrice = $this->price;

        foreach ($selectedRemarks as $remark) {
            // Assuming that the remark has a method getAdditionalCost
            $totalPrice += $remark->getAdditionalCost();
        }

        return $totalPrice;
    }
}
