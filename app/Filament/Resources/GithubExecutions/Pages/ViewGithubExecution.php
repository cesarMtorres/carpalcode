<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutions\Pages;

use App\Filament\Resources\GithubExecutions\GithubExecutionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGithubExecution extends ViewRecord
{
    protected static string $resource = GithubExecutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
