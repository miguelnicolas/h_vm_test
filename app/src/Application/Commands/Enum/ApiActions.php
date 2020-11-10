<?php

namespace App\Application\Commands\Enum;

use App\Application\Enum\BaseEnum;

abstract class ApiActions extends BaseEnum
{
	const EXIT = 'EXIT';
	const RETURN_COIN = 'RETURN-COIN';
	const INSERT_MONEY = 'INSERT-MONEY';
	const GET = 'GET';
	const SERVICE = 'SERVICE';
	const STATUS = 'STATUS';
}