<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Socialite\CloneRepositoryAction;
use Symfony\Component\Process\Process;

class CloneProjectController extends Controller
{
    public function index(CloneRepositoryAction $action, string $userName, string $repo)
    {
        $repoUrl = sprintf('https://github.com/%s/%s.git', $userName, $repo);

        $path = $action->handle($user, $repoUrl);

        dd($path);

        $process = new Process([
            'vendor/bin/rector', 'process', $path, '--dry-run', '--diff',
        ]);
        $process->run();

        $output = $process->getOutput();

        return response()->json([
            'output' => $output,
        ]);

    }
}
