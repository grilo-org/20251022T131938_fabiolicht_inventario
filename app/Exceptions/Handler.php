<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Swift_TransportException;
use Throwable;

class Handler extends ExceptionHandler
{
    // ...

    public function report(Throwable $exception)
    {
        Log::error($exception);
        parent::report($exception);

        if ($exception instanceof Swift_TransportException) {
            // Registrar o erro do SwiftMailer no log do Laravel
            Log::error($exception->getMessage());
        }

        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof Swift_TransportException) {
            // Não retorne nada aqui para evitar interromper a resposta ao cliente
        }

        return parent::render($request, $exception);
    }

    // ...
}
