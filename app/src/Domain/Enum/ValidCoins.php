<?php

namespace App\Domain\Enum;

use App\Application\Enum\BaseEnum;

abstract class ValidCoins extends BaseEnum
{
	const ONE = 1.0;
	const CERO_TWENTYFIVE = 0.25;
	const CERO_TEN = 0.10;
	const CERO_FIVE = 0.05;
}