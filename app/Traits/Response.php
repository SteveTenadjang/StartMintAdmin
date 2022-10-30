<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class Response{
    public function auth($data,$token): array
    {
        Log::channel()->info(Route::getCurrentRoute()?->getActionName()." method success");
        return [
            'status' => 200,
            'success' => true,
            'data' => $data,
            'access_token' => $token
        ];
    }

    public function success($data): array
    {
        Log::channel()->info(Route::getCurrentRoute()?->getActionName()." method success");
        return [
            'status' => 200,
            'success' => true,
            'data' => $data
        ];
    }

    public function created($data): array
    {
        Log::channel()->info(Route::getCurrentRoute()?->getActionName()." creation success");
        return [
            'status' => 201,
            'success' => true,
            'data' => $data
        ];
    }

    public function idNotFound(): array
    {
        Log::channel()->warning(Route::getCurrentRoute()?->getActionName()." data not found");
        return [
            'status' => 404,
            'success' => false,
            'message' => "Unknown data",
        ];
    }

    public function notFound(): array
    {
        Log::channel()->warning(Route::getCurrentRoute()?->getActionName()." ID not found");
        return [
            'status' => 404,
            'success' => false,
            'message' => "Unknown ID",
        ];
    }

    public function failed($message): array
    {
        Log::channel()->warning(Route::getCurrentRoute()?->getActionName()." Request failed to execute");
        return [
            'status' => 400,
            'success' => false,
            'message' => $message?:"Request failed to execute",
        ];
    }

    public function error($statusCode = 500, $data = null,$message = null): array
    {
        Log::channel()->error(Route::getCurrentRoute()?->getActionName()." failed, an error occurred");
        return [
            'status' => $statusCode,
            'success' => false,
            'message' => $message?:"An error occurred",
            'data' => $data,
        ];
    }

}
