<?php

declare(strict_types=1);

use App\Http\Controllers\GithubCallbackController;
use App\Livewire\GithubAuth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', fn () => Inertia::render('Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
]))->name('home');

Route::get('dashboard', App\Livewire\Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/socialite.php';

Route::get('/marketplace', App\Livewire\Marketplace\Explore::class)->name('marketplace');
Route::get('/marketplace/{id}', App\Livewire\Marketplace\RuleShow::class)->name('rule.show');

Route::middleware('auth')->group(function (): void {
    // GitHub OAuth callback
    Route::get('/github/callback', [GithubCallbackController::class, 'handle'])->name('github.callback');

    // GitHub repositories (Livewire)
    Route::get('/github', GithubAuth::class)->name('github.dashboard');

    // GitHub executions (Livewire)
    Route::get('/github/executions', App\Livewire\GithubExecutions::class)->name('github.executions');

    // User Profile
    Route::get('/profile/{user}', App\Livewire\UserProfile::class)->name('user.profile');
});

Route::get('/test-github', function (): void {
    $response = Http::asForm()
        ->withHeaders(['Accept' => 'application/json'])
        ->post('https://github.com/login/oauth/access_token', [
            'client_id' => config('services.github.client_id'),
            'client_secret' => config('services.github.client_secret'),
            'code' => 'test_code',
        ]);

    dd($response->json());
});
