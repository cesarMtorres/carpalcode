<?php

declare(strict_types=1);

use App\Livewire\GithubAuth;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(GithubAuth::class)
        ->assertStatus(200);
});
