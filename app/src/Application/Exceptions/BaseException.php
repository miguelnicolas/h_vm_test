<?php

namespace App\Application\Exceptions;

use \Exception;

abstract class BaseException extends Exception
{
    /**
     * @var array
     */
    private $colorModifiers = [
        'DEFAULT' => "\033[39m",
        'ERROR' => "\033[31m",
        'WARNING' => "\033[33m"
    ];
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

    protected function getColorModifier($code = 'DEFAULT'): string
    {
        $code = strtoupper($code);
        if(!array_key_exists($code, $this->colorModifiers)) {
            return '';
        }
        return $this->colorModifiers[$code];
    } 

    protected function getErrorHeader($code): string
    {
        return '';
    }
}