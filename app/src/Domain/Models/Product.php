<?php

namespace App\Domain\Models;

class Product
{

    private $name;
    private $price;

    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = floatval($price);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
}