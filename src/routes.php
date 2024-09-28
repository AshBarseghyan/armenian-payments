<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/abn-armenian-payments/success', function () {
        return view('armenian-payments.success');
    })->name('abn-armenian-payments.success');

    Route::get('/abn-armenian-payments/fail', function () {
        return view('armenian-payments.fail');
    })->name('abn-armenian-payments.fail');

    Route::get('payment-ameria-callback', [\Abn\ArmenianPayments\Payments\Ameria::class, 'callback'])->name('abn-armenian-payments.ameria.callback');
});