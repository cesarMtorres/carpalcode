<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutions\Pages;

use App\Filament\Resources\GithubExecutions\GithubExecutionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGithubExecution extends CreateRecord
{
    protected static string $resource = GithubExecutionResource::class;
}
