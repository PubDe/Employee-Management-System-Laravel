<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Log;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
            $middleware->append(PreventBackHistory::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Handle database query exceptions
        $exceptions->render(function (\Illuminate\Database\QueryException $e, $request) {
            report($e);
            if (str_contains($e->getMessage(), 'No connection could be made')) {
                return response()->view('errors.500', [], 500);
            }
        });

        // Handle PDO exceptions
        $exceptions->render(function (\PDOException $e, $request) {
            report($e);
            return response()->view('errors.500', [], 500);
        });

        //Handle CSFR exception
        $exceptions->render(function (Illuminate\Session\TokenMismatchException $e, $request) {
            report($e);
            return response()->view('errors.419', [], 419);
        });
    })->create();
