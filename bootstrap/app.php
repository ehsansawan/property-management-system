<?php

use App\Http\Responses\Response;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        $exceptions->renderable(function (\Illuminate\Validation\ValidationException $e,$request) {

            $validator = $e->validator;

            // نمرّ على كل الحقول والـ rules اللي عليهم
            $errors = collect($validator->failed())->map(function ($rules, $field) {
                // $rules بيكون Array [ 'Required' => [], 'Min' => [10] ... ]
                return array_map('strtolower', array_keys($rules));
            });

            return Response::Validation(
                $errors,'Validation Error.');
        });

        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e,$request) {
           return Response::Error($e->getMessage(),'Authentication Error.',401);
        });

        $exceptions->renderable(function(AccessDeniedHttpException $e, $request) {
            // that's for when someone has no permission to do smth we need to customize the message for fornt_end
            return \App\Http\Responses\Response::Error(
                '',
                'you do not have the authorization to access this page.',
                403
            );
        });



    })->create();


