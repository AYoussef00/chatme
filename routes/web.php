<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $plans = \App\Models\Plan::where('is_active', true)->get();
    return Inertia::render('Welcome', [
        'plans' => $plans
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('chat', function () {
    $plans = \App\Models\Plan::where('is_active', true)->get();
    return Inertia::render('Chat', [
        'plans' => $plans
    ]);
})->name('chat');

Route::get('help-center', function () {
    $plans = \App\Models\Plan::where('is_active', true)->get();
    return Inertia::render('HelpCenter', [
        'plans' => $plans
    ]);
})->name('help-center');



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
