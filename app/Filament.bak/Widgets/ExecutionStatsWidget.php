<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\Status;
use App\Models\GithubExecution;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ExecutionStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();

        $totalExecutions = GithubExecution::query()->where('user_id', $userId)->count();
        $completedExecutions = GithubExecution::query()->where('user_id', $userId)
            ->where('status', Status::COMPLETED)->count();
        $failedExecutions = GithubExecution::query()->where('user_id', $userId)
            ->where('status', Status::FAILED)->count();
        $inProgressExecutions = GithubExecution::query()->where('user_id', $userId)
            ->whereIn('status', [Status::PENDING, Status::CLONING])->count();

        // Calculate average duration
        $avgDuration = GithubExecution::query()->where('user_id', $userId)
            ->where('status', Status::COMPLETED)
            ->whereNotNull('started_at')
            ->whereNotNull('completed_at')
            ->get()
            ->map(fn ($execution) => $execution->started_at->diffInSeconds($execution->completed_at))
            ->avg();

        $avgDurationFormatted = $avgDuration ? gmdate('H:i:s', $avgDuration) : '—';

        return [
            Stat::make('Total Executions', $totalExecutions)
                ->description('All repository clones')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('primary'),

            Stat::make('Completed', $completedExecutions)
                ->description('Successfully completed')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart($this->getCompletedChart()),

            Stat::make('Failed', $failedExecutions)
                ->description('Failed executions')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
                ->chart($this->getFailedChart()),

            Stat::make('In Progress', $inProgressExecutions)
                ->description('Currently running')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Average Duration', $avgDurationFormatted)
                ->description('Time to complete')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),

            Stat::make('Success Rate', $totalExecutions > 0 ? round(($completedExecutions / $totalExecutions) * 100, 1).'%' : '—')
                ->description('Completion percentage')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($totalExecutions > 0 && ($completedExecutions / $totalExecutions) > 0.8 ? 'success' : 'warning'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }

    private function getCompletedChart(): array
    {
        return GithubExecution::query()->where('user_id', Auth::id())
            ->where('status', Status::COMPLETED)
            ->where('created_at', '>=', now()->subDays(7))
            ->get()
            ->groupBy(fn ($execution) => $execution->created_at->format('Y-m-d'))
            ->map
            ->count()
            ->values()
            ->toArray();
    }

    private function getFailedChart(): array
    {
        return GithubExecution::query()->where('user_id', Auth::id())
            ->where('status', Status::FAILED)
            ->where('created_at', '>=', now()->subDays(7))
            ->get()
            ->groupBy(fn ($execution) => $execution->created_at->format('Y-m-d'))
            ->map
            ->count()
            ->values()
            ->toArray();
    }
}
