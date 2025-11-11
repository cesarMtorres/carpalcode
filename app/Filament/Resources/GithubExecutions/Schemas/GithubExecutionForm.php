<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GithubExecutionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Repository Information')
                    ->schema([
                        TextInput::make('repo_name')
                            ->label('Repository Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('repo_url')
                            ->label('Repository URL')
                            ->url()
                            ->required()
                            ->maxLength(500),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'cloning' => 'Cloning',
                                'completed' => 'Completed',
                                'failed' => 'Failed',
                            ])
                            ->required(),
                    ])->columns(2),

                Section::make('Execution Details')
                    ->schema([
                        TextInput::make('clone_path')
                            ->label('Clone Path')
                            ->maxLength(500),
                        Textarea::make('error_message')
                            ->label('Error Message')
                            ->rows(3)
                            ->columnSpanFull(),
                        DateTimePicker::make('started_at')
                            ->label('Started At'),
                        DateTimePicker::make('completed_at')
                            ->label('Completed At'),
                    ])->columns(2),
            ]);
    }
}
