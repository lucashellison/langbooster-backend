<?php

namespace App\Exceptions;

use Exception;

class AuthenticationException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'error' => 'Unauthenticated.'
        ], 401);
    }
}
