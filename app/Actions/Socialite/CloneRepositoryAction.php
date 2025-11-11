<?php

declare(strict_types=1);

namespace App\Actions\Socialite;

use RuntimeException;
use Symfony\Component\Process\Process;

class CloneRepositoryAction
{
    public function handle(string $user, string $repoUrl): string
    {
        $token = decrypt($user->github_token);
        $tempPath = storage_path('app/tmp/repos/'.uniqid());

        // Agrega el token al URL (para acceso seguro)
        $authUrl = str_replace('https://', sprintf('https://%s@', $token), $repoUrl);

        $process = new Process(['git', 'clone', '--depth=1', $authUrl, $tempPath]);
        $process->run();

        if ( ! $process->isSuccessful()) {
            throw new RuntimeException('Failed to clone repository: '.$process->getErrorOutput());
        }

        return $tempPath;
    }
}
