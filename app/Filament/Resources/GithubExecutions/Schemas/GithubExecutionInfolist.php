<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutions\Schemas;

use App\Enums\Status;
use App\Models\GithubExecution;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class GithubExecutionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Repository Information')
                    ->schema([
                        TextEntry::make('repo_name')
                            ->label('Repository Name'),
                        TextEntry::make('repo_url')
                            ->label('Repository URL')
                            ->url()
                            ->openUrlInNewTab(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->formatStateUsing(fn (Status $state): string => $state->getLabel())
                            ->badge()
                            ->color(fn (Status $state): string => $state->getColor()),
                    ])->columns(2),

                Section::make('Execution Details')
                    ->schema([
                        TextEntry::make('clone_path')
                            ->label('Clone Path')
                            ->placeholder('Not set'),
                        TextEntry::make('started_at')
                            ->label('Started At')
                            ->dateTime()
                            ->placeholder('Not started'),
                        TextEntry::make('completed_at')
                            ->label('Completed At')
                            ->dateTime()
                            ->placeholder('Not completed'),
                        TextEntry::make('duration')
                            ->label('Duration')
                            ->getStateUsing(function (GithubExecution $record): string {
                                if ( ! $record->started_at) {
                                    return 'Not started';
                                }

                                if ( ! $record->completed_at) {
                                    return 'In progress ('.$record->started_at->diffForHumans().')';
                                }

                                return $record->started_at->diffForHumans($record->completed_at, true);
                            }),
                    ])->columns(2),

                Section::make('Error Details')
                    ->schema([
                        TextEntry::make('error_message')
                            ->label('Error Message')
                            ->formatStateUsing(fn (?string $state): HtmlString => new HtmlString(
                                $state ? '<pre class="whitespace-pre-wrap">'.htmlspecialchars($state).'</pre>' : 'No errors'
                            ))
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (GithubExecution $record): bool => ! empty($record->error_message)),
            ]);
    }
}
