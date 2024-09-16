<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Decorators\DecoratorFactory;

class Menu extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'menu_code',
        'name',
        'desc',
        'price',
        'status'
    ];

    /**
     * Get the remarks associated with the menu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function remarks()
    {
        return $this->belongsToMany(Remark::class);
    }

    /**
     * Get the decorated description of the menu, considering its remarks.
     *
     * @return string
     */
    public function getDecoratedDescription()
    {
        $decoratedDescription = $this->desc;
        foreach ($this->remarks as $remark) {
            $decorator = DecoratorFactory::createDecorator($this, $remark);
            $decoratedDescription .= ' (' . $decorator->getDescription() . ')';
        }
        return $decoratedDescription;
    }

    /**
     * Get the decorated price of the menu, considering its remarks and price adjustments.
     *
     * @return float
     */
    public function getDecoratedPrice()
    {
        $decoratedPrice = $this->price;
        foreach ($this->remarks as $remark) {
            $decorator = DecoratorFactory::createDecorator($this, $remark);
            $decoratedPrice += $decorator->getPriceAdjustment(); // Add price adjustment if applicable
        }
        return $decoratedPrice;
    }
}
