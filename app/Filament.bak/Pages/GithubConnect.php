<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\GithubToken;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class GithubConnect extends Page implements HasForms
{
    use InteractsWithForms;

    public bool $isConnected = false;

    public ?string $githubLogin = null;

    public ?int $githubId = null;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static string $view = 'filament.pages.github-connect';

    protected static ?string $navigationLabel = 'GitHub Connection';

    protected static ?int $navigationSort = 1;

    public function mount(): void
    {
        $this->checkGithubConnection();
    }

    public function connectGithub(): void
    {
        $clientId = config('services.github.client_id');

        if ( ! $clientId) {
            Notification::make()
                ->title('Configuration Error')
                ->body('GitHub client ID is not configured.')
                ->danger()
                ->send();

            return;
        }

        $redirectUri = route('github.callback');
        $scope = 'repo,user';

        $url = 'https://github.com/login/oauth/authorize?'.http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => $scope,
            'state' => session()->token(),
        ]);

        redirect($url);
    }

    public function disconnectGithub(): void
    {
        try {
            GithubToken::query()->where('user_id', Auth::id())->delete();

            $this->isConnected = false;
            $this->githubLogin = null;
            $this->githubId = null;

            Notification::make()
                ->title('Disconnected Successfully')
                ->body('Your GitHub account has been disconnected.')
                ->success()
                ->send();

        } catch (Exception $exception) {
            Notification::make()
                ->title('Error')
                ->body('Failed to disconnect GitHub account: '.$exception->getMessage())
                ->danger()
                ->send();
        }
    }

    public function getGithubStatus(): array
    {
        if ( ! $this->isConnected) {
            return [
                'status' => 'disconnected',
                'message' => 'Not connected to GitHub',
                'color' => 'danger',
            ];
        }

        return [
            'status' => 'connected',
            'message' => 'Connected as '.($this->githubLogin ?? 'Unknown'),
            'color' => 'success',
        ];
    }

    protected function getHeaderActions(): array
    {
        if ($this->isConnected) {
            return [
                Action::make('disconnect')
                    ->label('Disconnect GitHub')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->action(fn () => $this->disconnectGithub())
                    ->requiresConfirmation()
                    ->modalDescription('Are you sure you want to disconnect your GitHub account? This will remove all stored tokens and you will need to reconnect.'),
                Action::make('repositories')
                    ->label('View Repositories')
                    ->icon('heroicon-o-folder')
                    ->url('/github')
                    ->color('primary'),
            ];
        }

        return [
            Action::make('connect')
                ->label('Connect to GitHub')
                ->icon('heroicon-o-link')
                ->color('success')
                ->action(fn () => $this->connectGithub()),
        ];
    }

    private function checkGithubConnection(): void
    {
        if (Auth::check()) {
            $token = GithubToken::query()->where('user_id', Auth::id())
                ->where('is_valid', true)
                ->first();

            if ($token) {
                $this->isConnected = true;
                $this->githubLogin = $token->github_login;
                $this->githubId = $token->github_id;
            }
        }
    }
}
