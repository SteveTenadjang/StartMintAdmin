<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Response::macro('auth',
            function ($data,$token) {
                Log::channel()->info(Route::getCurrentRoute()?->getActionName()." method success");
                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'access_token' => $token
                ], 201);
            });

        Response::macro('created',
            function ($data) {
                Log::channel()->info(Route::currentRouteAction()." creation success");
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ], 201);
            });

        Response::macro('executed',
            function ($message) {
                Log::channel()->info(Route::currentRouteAction()." creation success");
                return response()->json([
                    'success' => true,
                    'message' => $message
                ], 201);
            });

        Response::macro('success',
            function ($data) {
                Log::channel()->info(Route::currentRouteAction()." method success");
                return response()->json([
                    'success' => true,
                    'data' => $data,
                ]);
            });

        Response::macro('idNotFound',
            function ($message=null): JsonResponse {
                Log::channel()->warning(Route::currentRouteAction()." ID not found");
                return response()->json([
                    'success' => false,
                    'message' => $message?:"Unknown ID",
                ], 404);
            });

        Response::macro('error',
            function ($data, $statusCode) {
                Log::channel()->error(Route::currentRouteAction()." failed, an error occurred");
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred',
                    'data' => $data,
                ], $statusCode);
            });

        Response::macro('notFound',
            function ($message): JsonResponse {
                Log::channel()->warning(Route::currentRouteAction()." failed, Not found");
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 404);
            });

        Response::macro('failed',
            function ($message): JsonResponse {
                Log::channel()->warning(Route::getCurrentRoute()?->getActionName()." Request failed to execute");
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            });
    }
}
