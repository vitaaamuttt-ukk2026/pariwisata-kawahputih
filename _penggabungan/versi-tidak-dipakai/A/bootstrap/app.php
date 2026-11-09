<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // GANTI AdminMiddleware menjadi CheckRole di sini!
            'admin' => \App\Http\Middleware\CheckRole::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            if ($e instanceof \Illuminate\Auth\AuthenticationException ||
                $e instanceof \Illuminate\Validation\ValidationException) {
                return null;
            }

            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->view('errors.404', [], 404);
            }

            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException ||
                ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $e->getStatusCode() === 403) ||
                $e instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
                return response()->view('errors.403', [], 403);
            }

            if ($e instanceof \PDOException ||
                $e instanceof \Illuminate\Database\QueryException) {
                return response()->view('errors.500', ['message' => 'Saat ini layanan kami sedang mengalami gangguan teknis. Silakan coba beberapa saat lagi.'], 500);
            }

            return response()->view('errors.500', [], 500);
        });
    })->create();