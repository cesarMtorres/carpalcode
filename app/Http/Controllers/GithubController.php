<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')
            ->scopes(['repo'])
            ->redirect();
    }

    public function callback(): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        // Guardas el token para futuras operaciones
        auth()->user()->update([
            'github_token' => encrypt($githubUser->token),
        ]);

        return to_route('projects.connect.success');
    }
}
