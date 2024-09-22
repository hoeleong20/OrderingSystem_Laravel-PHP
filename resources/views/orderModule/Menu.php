<?php


class Menu
{
    private $name;
    private $price;

    public function __construct($name = "", $price = 0.0)
    {
        $this->name = $name;
        $this->price = $price;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function get()
    {
        return $this->price;
    }

    function setPrice($price)
    {
        $this->price = $price;
    }
    public function __toString() {
        return "Food Name:".$this->name."<br/>".
               "Food Price:RM".number_format($this->price,2)."<br/>";
    }
}
