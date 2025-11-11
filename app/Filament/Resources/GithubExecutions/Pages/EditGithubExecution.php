<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutions\Pages;

use App\Filament\Resources\GithubExecutions\GithubExecutionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGithubExecution extends EditRecord
{
    protected static string $resource = GithubExecutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
