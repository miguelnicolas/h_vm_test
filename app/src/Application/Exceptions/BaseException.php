<?php

namespace App\Application\Exceptions;

use Exception;

class BaseException extends \Exception
{
    /**
     * @var int
     */
    protected $defaultCode = 500;
    /**
     * @var int
     */
    protected $defaultMessage = 'Something went wrong';
    /**
     * @var null|Array
     */
    protected $data = null;

    public function __construct($message = '', array $data = null, $code = 0, Exception $previous = null)
    {
    	!$code && $code = $this->defaultCode;
        !$message && $message = $this->defaultMessage;

        $message = $this->getErrorHeader($code).$message;
        parent::__construct($message, (int) $code, $previous);
        $this->data = $data;
    }

    /**
     * Returns exception info
     *
     * @return  array
     */
    public function getError() {
    	$error = [
    		'code' => $this->getCode(),
    		'message' => $this->getMessage()
    	];

    	!empty($this->data) && $error['errors'] = $this->data;
        return $error;
    }

    protected function getErrorHeader($code)
    {
        return "\033[31mERROR ".$code.PHP_EOL."\033[39m";
    }
}