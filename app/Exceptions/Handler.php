<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Moonlight\Utils\ErrorMessage;

class Handler extends ExceptionHandler
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);

        if ($this->shouldReport($exception)) {
            try {
                ErrorMessage::send($exception);
            } catch (\Exception $e) {
                parent::report($e);
            }
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Страница не найдена.']);
            }
    
            return response()->view('errors.404', [], 404);
        } elseif ($this->shouldReport($exception)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => $exception->getMessage()]);
            }

            if (config('app.debug')) {
                return parent::render($request, $exception);
            }

            return response()->view('errors.500', ['exception' => $exception], 500);
        } elseif ($exception instanceof TokenMismatchException) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Данные формы устарели.']);
            }

            return redirect()->route('welcome');
        }

        return parent::render($request, $exception);
    }
}
