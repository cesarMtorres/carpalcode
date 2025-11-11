<?php

declare(strict_types=1);

use App\Http\Controllers\CloneProjectController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Socialite;

Route::get('/auth/redirect', fn () => Socialite::driver('github')->redirect());

// Route::get('/auth/callback', function ($github) {
//     $github->handle();

//     return redirect()->route('/dashboard');
// });

Route::get('/clone/{userName}/{repo}', [CloneProjectController::class, 'index']);
