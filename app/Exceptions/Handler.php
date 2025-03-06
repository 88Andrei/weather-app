<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            if ($exception->getMessage() === 'location_limit_exceeded') {
                return redirect()->route('locations.index')->with('error', 'Location limit exceeded. Please subscribe to additional locations in the Tariff section or delete old locations.');
            }

            if ($exception->getMessage() === 'trigger_limit_exceeded') {
                return redirect()->route('triggers.index')->with('error', 'Trigger limit exceeded. Please subscribe to additional triggers in the Tariff section or delete old triggers.');
            }
            
        }

        return parent::render($request, $exception);
    }


    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
