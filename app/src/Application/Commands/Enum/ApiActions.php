<?php

namespace App\Application\Commands\Enum;

use App\Application\Enum\BaseEnum;

abstract class ApiActions extends BaseEnum
{
	const INSERT_MONEY = 'INSERT-MONEY';
	const RETURN_COIN = 'RETURN-COIN';
	const CREDIT = 'CREDIT';
	const GET = 'GET';
	const STATUS = 'STATUS';
	const SERVICE = 'SERVICE';
	const EXIT = 'EXIT';
}