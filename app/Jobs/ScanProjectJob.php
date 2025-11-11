<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\ProjectBatch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ScanProjectJob implements ShouldQueue
{
    use Queueable;

    /** Execute the job. */
    public function handle(): void
    {
        // Ejemplo pseudo-código
        $files = collect(File::allFiles($repoPath))
            ->filter(fn ($f) => Str::endsWith($f, '.php'))
            ->chunk(100);

        foreach ($files as $index => $chunk) {
            ProjectBatch::query()->create([
                'project_id' => $project->id,
                'batch_index' => $index,
                'files' => json_encode($chunk->toArray()),
                'status' => 'pending',
            ]);

            dispatch(new ProcessBatchJob($project->id, $index));
        }

    }
}
