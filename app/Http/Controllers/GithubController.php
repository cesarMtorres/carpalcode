<?php

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

    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();

        // Guardas el token para futuras operaciones
        auth()->user()->update([
            'github_token' => encrypt($githubUser->token),
        ]);

        return redirect()->route('projects.connect.success');
    }
}
