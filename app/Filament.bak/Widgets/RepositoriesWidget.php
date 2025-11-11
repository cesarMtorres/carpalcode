<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\Status;
use App\Models\GithubExecution;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class RepositoriesWidget extends ChartWidget
{
    protected static ?string $heading = 'Repository Executions Overview';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function getDescription(): ?string
    {
        return 'Comparison of total executions vs completed executions for each repository.';
    }

    protected function getData(): array
    {
        $executions = GithubExecution::query()->where('user_id', Auth::id())
            ->get()
            ->groupBy('repo_name');

        $repositories = [];
        $totalExecutions = [];
        $completedExecutions = [];

        foreach ($executions as $repoName => $repoExecutions) {
            $repositories[] = $repoName;
            $totalExecutions[] = $repoExecutions->count();
            $completedExecutions[] = $repoExecutions->where('status', Status::COMPLETED)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Executions',
                    'data' => $totalExecutions,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Completed',
                    'data' => $completedExecutions,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $repositories,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Executions by Repository',
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Repositories',
                    ],
                ],
                'y' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Number of Executions',
                    ],
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
