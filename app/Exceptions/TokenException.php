<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Exception;

class TokenException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */

    public function report()
    {
        \Log::debug($this->getMessage());
    }

    public function render($request)
    {
        $statusCode = $this->code !== 0 ? $this->code :  Response::HTTP_INTERNAL_SERVER_ERROR;
        return response()->json(["message" => $this->getMessage()], $statusCode);
    }
}