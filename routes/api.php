<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'healthy']);
});

Route::get('/test', function () {
    return response()->json(['message' => 'Test OK']);
});

Route::get('/status', function () {
    return response()->json([
        'status' => 'online',
        'app' => 'CashDigital',
        'timestamp' => now()->toIso8601String(),
    ]);
});
