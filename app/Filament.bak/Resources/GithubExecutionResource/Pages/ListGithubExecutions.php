<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutionResource\Pages;

use App\Filament\Resources\GithubExecutionResource;
use App\Filament\Widgets\ExecutionStatsWidget;
use App\Filament\Widgets\RepositoriesWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGithubExecutions extends ListRecords
{
    protected static string $resource = GithubExecutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('connect_github')
                ->label('Connect to GitHub')
                ->url('/github')
                ->icon('heroicon-o-link')
                ->color('primary'),
            Actions\Action::make('new_clone')
                ->label('Clone Repository')
                ->url('/github')
                ->icon('heroicon-o-document-duplicate')
                ->color('success'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ExecutionStatsWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            RepositoriesWidget::class,
        ];
    }
}
