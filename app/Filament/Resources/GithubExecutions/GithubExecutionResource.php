<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutions;

use App\Filament\Resources\GithubExecutions\Pages\CreateGithubExecution;
use App\Filament\Resources\GithubExecutions\Pages\EditGithubExecution;
use App\Filament\Resources\GithubExecutions\Pages\ListGithubExecutions;
use App\Filament\Resources\GithubExecutions\Pages\ViewGithubExecution;
use App\Filament\Resources\GithubExecutions\Schemas\GithubExecutionForm;
use App\Filament\Resources\GithubExecutions\Schemas\GithubExecutionInfolist;
use App\Filament\Resources\GithubExecutions\Tables\GithubExecutionsTable;
use App\Models\GithubExecution;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GithubExecutionResource extends Resource
{
    protected static ?string $model = GithubExecution::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'GitHub Executions';

    protected static ?string $modelLabel = 'GitHub Execution';

    protected static ?string $pluralModelLabel = 'GitHub Executions';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'repo_name';

    public static function form(Schema $schema): Schema
    {
        return GithubExecutionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GithubExecutionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GithubExecutionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGithubExecutions::route('/'),
            'create' => CreateGithubExecution::route('/create'),
            'view' => ViewGithubExecution::route('/{record}'),
            'edit' => EditGithubExecution::route('/{record}/edit'),
        ];
    }
}
