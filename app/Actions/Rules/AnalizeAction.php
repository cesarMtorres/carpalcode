<?php

namespace App\Actions\Rules;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

final class AnalizeAction
{
    public function handle(string $project)
    {
        $path = Storage::path("projects/{$project}");

        if ( ! is_dir($path)) {
            return 'No existe';
        }

        $process = new Process([
            'vendor/bin/rector',
            'process',
            $path,
            '--dry-run',
            '--ansi',
            '--no-progress-bar',
        ]);

        $process->run();

        if ( ! $process->isSuccessful()) {
            return 'No se pudo analizar';
        }

        return [
            'output' => $process->getOutput(),
        ];
    }
}
