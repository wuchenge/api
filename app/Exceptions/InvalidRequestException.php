<?php

/**
 * @Author: wuchenge
 * @Date: 2018-11-22 15:49:07
 */

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class InvalidRequestException extends Exception
{
    public function __construct(int $code = 400, string $message = "")
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request)
    {
        $api = new ApiController;
        return $api->setErrorCode($this->code)->response([], $this->message);
    }
}
