<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\GithubExecution;
use App\Models\GithubToken;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use Livewire\Component;
use Livewire\WithPagination;

class GithubExecutions extends Component
{
    use WithPagination;

    #[\Livewire\Attributes\Url]
    public $search = '';

    #[\Livewire\Attributes\Url]
    public $statusFilter = '';

    public $repoName;

    public $loading = false;

    public $message = '';

    public function mount($repoName = null): void
    {
        $this->repoName = $repoName;
        if ($repoName) {
            $this->runClone($repoName);
        }
    }

    public function runClone($repoName): void
    {
        if ($this->loading) {
            return;
        }

        $this->loading = true;

        try {
            $tokenRecord = GithubToken::query()->where('user_id', Auth::id())->first();
            if ( ! $tokenRecord) {
                $this->message = 'No estás conectado a GitHub';
                $this->loading = false;

                return;
            }

            // Crear registro de ejecución
            $execution = GithubExecution::query()->create([
                'user_id' => Auth::id(),
                'repo_name' => $repoName,
                'repo_url' => sprintf('https://github.com/%s/%s', $tokenRecord->github_login, $repoName),
                'status' => 'pending',
                'started_at' => now(),
            ]);

            // Actualizar a clonando
            $execution->update(['status' => 'cloning']);

            // Desencriptar token
            $token = decrypt($tokenRecord->access_token);
            $login = $tokenRecord->github_login;

            $cloneUrl = sprintf('https://%s@github.com/%s/%s.git', $token, $login, $repoName);
            $targetPath = storage_path(sprintf('app/github-repos/%s-', $repoName).time());

            // Crear directorio
            @mkdir(storage_path('app/github-repos'), 0755, true);

            // Clonar repositorio
            $result = Process::timeout(300)
                ->run(sprintf('git clone %s %s', $cloneUrl, $targetPath));

            if ($result->failed()) {
                throw new Exception('Git clone failed: '.$result->errorOutput());
            }

            // Actualizar a completado
            $execution->update([
                'status' => 'completed',
                'clone_path' => $targetPath,
                'completed_at' => now(),
            ]);

            $this->message = sprintf('✓ Repositorio %s clonado exitosamente', $repoName);
            $this->dispatch('executionCompleted', repoName: $repoName);

        } catch (Exception $exception) {
            \Illuminate\Support\Facades\Log::error('Clone Error: '.$exception->getMessage());
            $execution?->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
                'completed_at' => now(),
            ]);

            $this->message = 'Error: '.$exception->getMessage();
        }

        $this->loading = false;
    }

    public function getExecutions()
    {
        $query = GithubExecution::query()->where('user_id', Auth::id());

        if ($this->search) {
            $query->where('repo_name', 'like', sprintf('%%%s%%', $this->search));
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return $query->latest()->paginate(15);
    }

    public function deleteExecution($executionId): void
    {
        $execution = GithubExecution::query()->findOrFail($executionId);

        // Verificar que es del usuario
        if ($execution->user_id !== Auth::id()) {
            $this->message = 'No autorizado';

            return;
        }

        // Eliminar carpeta si existe
        if ($execution->clone_path && is_dir($execution->clone_path)) {
            $this->deleteDirectory($execution->clone_path);
        }

        $execution->delete();
        $this->message = 'Ejecución eliminada';
    }

    public function retryExecution($executionId): void
    {
        $execution = GithubExecution::query()->findOrFail($executionId);

        if ($execution->user_id !== Auth::id()) {
            $this->message = 'No autorizado';

            return;
        }

        // Eliminar anterior si existe
        if ($execution->clone_path && is_dir($execution->clone_path)) {
            $this->deleteDirectory($execution->clone_path);
        }

        $execution->delete();
        $this->runClone($execution->repo_name);
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.github-executions', [
            'executions' => $this->getExecutions(),
        ]);
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
