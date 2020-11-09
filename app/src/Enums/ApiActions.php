<?php

namespace App\Enums;

use App\Enums\BaseEnum;

abstract class ApiActions extends BaseEnum
{
	const QUIT = 'QUIT';
	const RETURN_COIN = 'RETURN-COIN';
	const INSERT_MONEY = 'INSERT-MONEY';
	const GET = 'GET';
	const SERVICE = 'SERVICE';
}