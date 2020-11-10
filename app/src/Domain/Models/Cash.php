<?php

namespace App\Domain\Models

class Cash extends Coin
{

    public function __construct($value)
    {
    	parent::__construct($value);
    }

}