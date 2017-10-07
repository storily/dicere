<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\Debug\Exception\FlattenException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new HttpException(403, $e->getMessage());
        } elseif ($e instanceof ValidationException && $e->getResponse()) {
            return $e->getResponse();
        }

        if ($e instanceof FlattenException) {
            try {
                $content = [];
                $count = count($e->getAllPrevious());
                $total = $count + 1;
                foreach ($e->toArray() as $position => $err) {
                    $ind = $count - $position + 1;
                    $message = $err['message'];
                    $ej = [
                        'message' => sprintf("(%2d/%2d) - %s: %s\n", $ind, $total, $err['class'], $message),
                        'trace' => []
                    ];

                    foreach ($err['trace'] as $trace) {
                        if ($trace['function']) {
                            $ej['trace'][] = sprintf(
                                'at %s(%s): %s%s%s(%s)',
                                $trace['file'] ?? 'unknown',
                                $trace['line'] ?? 0,
                                $trace['class'],
                                $trace['type'],
                                $trace['function'],
                                json_encode($trace['args'])
                            );
                        }
                    }

                    $content[] = $ej;
                }
            } catch (\Exception $e) {
                $content = [[
                    'message' => sprintf('Exception thrown when handling an exception (%s: %s)', get_class($e), $e->getMessage()),
                    'trace' => explode("\n", $e->getTraceAsString())
                ]];
            }
        } else {
            $content = [[
                'message' => sprintf('%s: %s', get_class($e), $e->getMessage()),
                'trace' => explode("\n", $e->getTraceAsString())
            ]];
        }

        $fe = FlattenException::create($e);
        $response = new Response(json_encode(['errors' => $content]), $fe->getStatusCode(), array_merge(
            ['Content-Type' => 'application/json'],
            $fe->getHeaders()
        ));

        $response->exception = $e;
        return $response;
    }
}
