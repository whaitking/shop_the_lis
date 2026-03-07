<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

// Esta URL será: tu-dominio.com/api/stripe/webhook
Route::post('/stripe/webhook', [WebhookController::class, 'handlePayment']);
