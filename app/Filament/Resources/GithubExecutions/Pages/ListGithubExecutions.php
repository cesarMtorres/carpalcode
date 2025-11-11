<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutions\Pages;

use App\Filament\Resources\GithubExecutions\GithubExecutionResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGithubExecutions extends ListRecords
{
    protected static string $resource = GithubExecutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('connect_github')
                ->label('Connect to GitHub')
                ->url('/github')
                ->icon('heroicon-o-link')
                ->color('primary'),
            Action::make('new_clone')
                ->label('Clone Repository')
                ->url('/github')
                ->icon('heroicon-o-document-duplicate')
                ->color('success'),
        ];
    }
}
