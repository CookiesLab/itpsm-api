<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
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

    protected function invalidJson($request, ValidationException $exception)
    {
        $errors = [];

        foreach ($exception->errors() as $key => $value) {
            array_push($errors, [
                'status' => $exception->status,
                'source' => ['pointer' => $key],
                'title' => array_reduce($value, function($carry, $item){
                    return $item;
                })
            ]);
        }

        return response()->json([
            'errors' => $errors,
            'status' => $exception->status,
            'jsonapi' => [
                'version' => "1.00"
            ]
        ], $exception->status);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson())
        {
            return response()->json([
                'errors' => [
                    'status' => "401",
                    'title' =>  __('auth.Unauthorized'),
                    'detail' => __('auth.UnauthorizedDetail')
                ],
                'jsonapi' => [
                    'version' => "1.00"
                ]
            ], 401);
        }

        return redirect()->guest(route('login'));
    }
}
