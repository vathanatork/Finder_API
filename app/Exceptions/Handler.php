<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        if (request()->is('api/*') || request()->is('api_backend/*')) {
            DB::rollBack();
            if ($e instanceof ModelNotFoundException) {
                return response()->json(['code' => 404, 'message' => __("error.not_found",  ['attribute' => $e->getModel()]), 'data' => null, 'error' => null], 200);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json(['code' => 404, 'message' => 'Not Found', 'data' => null, 'error' => null], 200);
            }

            if ($e instanceof AuthorizationException) {
                return response()->json(['code' => 401, 'message' => 'Unauthorized', 'data' => null, 'error' => null], 200);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json(['code' => 403, 'message' => 'Unauthenticated', 'data' => null, 'error' => null], 200);
            }

            if ($e instanceof ValidationException) {
                $errors = $e->validator->errors()->getMessages();

                return response()->json(['code' => 406, 'message' => 'Validation Errors!', 'data' => null, 'error' => $errors], 200);
            }

            if ($e instanceof HttpException) {
                $code = $e->getStatusCode();
                $message = Response::$statusTexts[$code];
                return response()->json(['code' => 405, 'message' => 'An Error Occurred', 'data' => null, 'error' => $message], 200);
            }

            if ($e instanceof BusinessException) {
                return response()->json(['code' => $e->getCustomStatusCode(), 'message' => $e->getMessage(), 'data' => null, 'error' => $e->getMessage()], 200);
            }

            if ($e instanceof Exception) {
                return response()->json(['code' => 500, 'message' => 'An Error Occurred', 'data' => null, 'error' => $e->getMessage()], 200);
            }
            return response()->json(['code' => 405, 'message' => 'An Error Occurred', 'data' => null, 'error' => $e->getMessage()], 200);
        }
        else {
            if ($e->getCode() == '0') {
                return response()->json(['code' => 404, 'message' => 'An Error Occurred', 'data' => null, 'error' => $e->getMessage()], 200);
            }
            return parent::render($request, $e);
        }
    }
}
