<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutions\Tables;

use App\Enums\Status;
use App\Models\GithubExecution;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class GithubExecutionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('user_id', Auth::id()))
            ->columns([
                TextColumn::make('repo_name')
                    ->label('Repository')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (Status $state): string => $state->getColor())
                    ->formatStateUsing(fn (Status $state): string => $state->getLabel()),

                TextColumn::make('started_at')
                    ->label('Started')
                    ->dateTime()
                    ->sortable()
                    ->since(),

                TextColumn::make('completed_at')
                    ->label('Completed')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->placeholder('—'),

                TextColumn::make('duration')
                    ->label('Duration')
                    ->getStateUsing(function (GithubExecution $record): string {
                        if ( ! $record->started_at || ! $record->completed_at) {
                            return '—';
                        }

                        return $record->started_at->diffForHumans($record->completed_at, true);
                    }),

                TextColumn::make('error_message')
                    ->label('Error')
                    ->getStateUsing(fn (GithubExecution $record): string => empty($record->error_message) ? 'No' : 'Yes')
                    ->badge()
                    ->color(fn (GithubExecution $record): string => empty($record->error_message) ? 'success' : 'danger'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'cloning' => 'Cloning',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ])
                    ->multiple(),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(fn ($query, array $data) => $query
                        ->when($data['created_from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                        ->when($data['created_until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date))),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(function ($records): void {
                            foreach ($records as $record) {
                                if ($record->clone_path && is_dir($record->clone_path)) {
                                    self::deleteDirectory($record->clone_path);
                                }

                                $record->delete();
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    private static function deleteDirectory(string $path): void
    {
        if (is_dir($path)) {
            $files = array_diff(scandir($path), ['.', '..']);
            foreach ($files as $file) {
                $filePath = $path.'/'.$file;
                is_dir($filePath) ? self::deleteDirectory($filePath) : @unlink($filePath);
            }

            @rmdir($path);
        }
    }
}
