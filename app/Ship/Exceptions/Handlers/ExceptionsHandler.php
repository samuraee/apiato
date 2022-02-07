<?php

namespace App\Ship\Exceptions\Handlers;

use Apiato\Core\Abstracts\Exceptions\Exception as CoreException;
use Apiato\Core\Exceptions\Handlers\ExceptionsHandler as CoreExceptionsHandler;
use Throwable;

/**
 * Class ExceptionsHandler
 *
 * A.K.A. (app/Exceptions/Handler.php)
 */
class ExceptionsHandler extends CoreExceptionsHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(static function (Throwable $e) {
        });

        $this->renderable(function (CoreException $e) {
            if (config('app.debug')) {
                $response = [
                    'message' => $e->getMessage(),
                    'errors' => $e->getErrors(),
                    'exception' => static::class,
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTrace(),
                ];
            } else {
                $response = [
                    'message' => $e->getMessage(),
                    'errors' => $e->getErrors(),
                ];
            }

            return response()->json($response, $e->getCode());
        });
    }
}
