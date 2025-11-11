<?php

declare(strict_types=1);

namespace App\Filament\Resources\GithubExecutionResource\Pages;

use App\Enums\Status;
use App\Filament\Resources\GithubExecutionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGithubExecution extends ViewRecord
{
    protected static string $resource = GithubExecutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('retry')
                ->label('Retry Execution')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->visible(fn (): bool => $this->record->status === Status::FAILED)
                ->action(function (): void {
                    $this->record->update([
                        'status' => Status::PENDING,
                        'error_message' => null,
                        'started_at' => now(),
                        'completed_at' => null,
                    ]);

                    $this->redirect(static::getResource()::getUrl('index'));
                })
                ->requiresConfirmation()
                ->modalDescription('This will reset the execution and mark it as pending.'),

            Actions\Action::make('open_repository')
                ->label('Open Repository')
                ->icon('heroicon-o-globe-alt')
                ->url(fn (): string => $this->record->repo_url)
                ->openUrlInNewTab()
                ->visible(fn (): bool => ! empty($this->record->repo_url)),

            Actions\Action::make('open_clone_path')
                ->label('View Clone Path')
                ->icon('heroicon-o-folder')
                ->visible(fn (): bool => ! empty($this->record->clone_path) && is_dir($this->record->clone_path))
                ->action(function (): void {
                    // In a real application, you might want to show the directory contents
                    // or provide a download option
                })
                ->modalContent(fn (): string => 'Clone path: '.$this->record->clone_path),

            Actions\DeleteAction::make()
                ->action(function (): void {
                    if ($this->record->clone_path && is_dir($this->record->clone_path)) {
                        $this->deleteDirectory($this->record->clone_path);
                    }

                    $this->record->delete();

                    $this->redirect(static::getResource()::getUrl('index'));
                }),
        ];
    }

    private function deleteDirectory(string $path): void
    {
        if (is_dir($path)) {
            $files = array_diff(scandir($path), ['.', '..']);
            foreach ($files as $file) {
                $filePath = $path.'/'.$file;
                is_dir($filePath) ? $this->deleteDirectory($filePath) : @unlink($filePath);
            }

            @rmdir($path);
        }
    }
}
