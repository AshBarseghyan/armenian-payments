<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware('api')->group(function () {
    Route::post('payment-ameria-callback', function () {
        $data = request()->all();
        Log::info('Ameria Callback', $data);

        return response()->json(['status' => 'success']);
    });
});