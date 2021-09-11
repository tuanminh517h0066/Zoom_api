<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Cookie;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
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
        if ($exception instanceof UnauthorizedHttpException) {
            $preException = $exception->getPrevious();
            if ($preException instanceof
                          \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'TOKEN_EXPIRED']);
            } else if ($preException instanceof
                          \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'TOKEN_INVALID']);
            } else if ($preException instanceof
                     \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                 return response()->json(['error' => 'TOKEN_BLACKLISTED']);
           }
           if ($exception->getMessage() === 'Token not provided') {
               return response()->json(['error' => 'Token not provided']);
           }
        }

        if ($request->expectsJson() &&
            !$exception instanceof \Illuminate\Validation\ValidationException &&
            !redprint()
        ) {
            $response['exception'] = join('', array_slice(explode('\\', get_class($exception)), -1));
            $response['message'] = $exception->getMessage();
            $status = 400;

            if ($this->isHttpException($exception)) {
                $status = $exception->getStatusCode();
            }

            return response()->json($response, $status);
        }
        
        if($this->isHttpException($exception)){

            switch ($exception->getStatusCode()) {
                case 400:
                case 401:
                case 403:
                case 404:
                case 405:
                case 422:
                case 500:
                    return response()->view('errors.500', [], 500);
                    break;
            }
        }

        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        if (!config('app.debug') && $this->isHttpException($exception)) {
            return response()->view('errors.500', [], 500);
        }
        
        return parent::render($request, $exception);
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
        if( $request->query('is_app') ) {
            Cookie::queue('is_app', 1,  time()+3600*24*30);
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $guard = array_get($exception->guards(),0);

        if ($guard == 'web') {
            return redirect()->guest(route('backend.login.form'));
        } else {
            return redirect()->guest(route('login.form'));
        }
    }
}
