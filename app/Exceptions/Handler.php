<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof UnauthorizedException) {
            return redirect()
                ->route('login');
        }

        if ($e instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
            return back()->with(['toast_notify' => [
                'type' => 'danger',
                'text' => 'Вы превысили кол-во попыток за заданный промежуток времени. Попробуйте позже.'
            ]]);
        }

        if ($e instanceof TokenMismatchException) {
            return back()->with(['toast_notify' => [
                'type' => 'danger',
                'text' => 'Срок действия текущей сессии истёк. Попробуйте выполнить действие ещё раз.'
            ]]);
        }

        return parent::render($request, $e);
    }
}
