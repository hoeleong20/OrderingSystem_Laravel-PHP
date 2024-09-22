<?php


class Order
{
    private $orderId;
    private $foodId;
    private $price;
    private $quantity;

    public function __construct($orderId = "", $foodId = "", $price = 0.0, $quantity = 0.0)
    {
        $this->orderId = $orderId;
        $this->foodId = $foodId;
        $this->price = $price;
        $this->quantity = $quantity;
    }


    /**
     * Get the value of orderId
     */ 
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set the value of orderId
     *
     * @return  self
     */ 
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get the value of foodId
     */ 
    public function getFoodId()
    {
        return $this->foodId;
    }

    /**
     * Set the value of foodId
     *
     * @return  self
     */ 
    public function setFoodId($foodId)
    {
        $this->foodId = $foodId;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    
    
    public function __toString() {
        return "Order ID:".$this->orderId."<br/>".
               "Food ID:".$this->foodId."<br/>".
               "Food Price: RM".number_format($this->price,2)."<br/>".
               "Food Quantity:".$this->quantity."<br/>";
    }
}
