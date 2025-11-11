<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\ProjectBatch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Symfony\Component\Process\Process;

class ProcessBatchJob implements ShouldQueue
{
    use Queueable;
    public $batchId;

    public $configPath;

    /** Create a new job instance. */
    public function __construct(private int $projectId, private int $batchIndex) {}

    /** Execute the job. */
    public function handle(): void
    {
        $batch = ProjectBatch::query()->find($this->batchId);
        $files = json_decode((string) $batch->files, true);

        $process = new Process([
            '/usr/bin/env', 'php',
            base_path('vendor/bin/rector'),
            'process',
            '--config='.$this->configPath,
            '--dry-run',
            '--ansi',
            ...$files,
        ]);

        $process->setTimeout(120);
        $process->run();

        $batch->update([
            'status' => $process->isSuccessful() ? 'done' : 'error',
            'output' => $process->getOutput(),
        ]);

        // Enviar PR parcial si hay cambios significativos
        if ($this->hasDiffs()) {
            dispatch(new CreatePullRequestJob($project->id, $batch->id));
        }
    }

    public function hasDiffs(): bool
    {
        // Verifica si hay cambios no committeados en el repo local
        $process = new Process(['git', 'status', '--porcelain'], $this->configPath);
        $process->run();

        return trim($process->getOutput()) !== '';
    }
}
