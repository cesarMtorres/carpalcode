<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;

class ProcessRepositoryJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    public $repoUrl;

    public function __construct(private int $project, public array $config) {}

    public function handle(): void
    {
        $path = '/tmp/repos/' . $this->project;
        (new Process(['git', 'clone', $this->repoUrl, $path]))->mustRun();

        $process = new Process([
            '/usr/bin/env', 'php',
            base_path('vendor/bin/rector'),
            'process', $path,
            '--config='.$this->config,
            '--dry-run',
            '--ansi',
        ], null, [
            'HOME' => '/home/sandbox_user',
        ]);

        $process->setTimeout(60);
        $process->run();

        $this->storeResults($process->getOutput());
    }

    private function storeResults(string $output): void
    {
        Project::query()->create([
            'name' => $this->project,
            'output' => $output,
        ]);
    }
}
