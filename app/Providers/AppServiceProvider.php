<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('jsonResponse', function(mixed $data, string $message, int $statusCode){
            return response()->json([
                'data' => $data,
                'message' => $message,
                'statusCode' => $statusCode
            ], $statusCode);
        });
    }
}
