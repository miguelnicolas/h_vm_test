<?php

namespace App\Domain\Services;

class ChangeDispenser
{
    private $coins = [];
    
    public function __construct(array $validCoins) {
        rsort($validCoins);
        $this->setCoins($validCoins);
    }

    public function setCoins($coins) {
        foreach ($coins as $coin) {
            array_push($this->coins, intval($coin*100));
         }
    }
    
    public function getChange(float $price, float $cash, array $coinsStock) {
        $amount = floatval(($cash - $price) *100);
        if($amount == 0) {
            return [];
        }
        $limits = [];
        foreach($coinsStock as $i => $coinStock) {
            $limits[intval(floatval($i)*100)] = $coinStock;
        }
        foreach($this->coins as $coin) {
            if(!isset($limits[$coin])) {
                $limits[$coin] = 0;
            }
        }
        krsort($limits);

        $changeCoins = [];
        $sum = 0;
        $i = 0;
        $ele = $this->coins[0];
        while(strval($sum) != strval($amount)) {
            if($limits[$ele] == 0) {
                $i++;

                if(!array_key_exists($i, $this->coins)) {
                    return -1;
                }
                $ele = $this->coins[$i];
            }

            if (($sum + $ele) > $amount) {
                $i++;
                $ele = $this->coins[$i];
                continue;
            }
            $sum = floatval($sum + $ele);
            $limits[$ele]--;
            array_push($changeCoins, $ele/100);
        }

        return $changeCoins;
    }
}
