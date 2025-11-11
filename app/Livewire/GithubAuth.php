<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\GithubExecution;
use App\Models\GithubToken;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class GithubAuth extends Component
{
    public $step = 'login';
     // login, authorize, dashboard
    public $authCode;

    public $githubUser;

    public $repositories = [];

    public $selectedRepo;

    public $prTitle = '';

    public $prDescription = '';

    public $branch = '';

    public $filePath = '';

    public $fileContent = '';

    public $isConnected = false;

    public $loading = false;

    public $message = '';

    protected $listeners = ['refreshComponent' => 'checkGithubConnection'];

    public function mount(): void
    {
        $this->checkGithubConnection();

        // Detectar si viene del callback desde sesión
        if (session()->has('github_code') && ! $this->isConnected) {
            $code = session()->pull('github_code');
            $this->message = 'Procesando autenticación...';
            $this->handleGithubCallback($code);
        }
    }

    public function checkGithubConnection(): void
    {
        if (Auth::check()) {
            $token = GithubToken::query()->where('user_id', Auth::id())
                ->where('is_valid', true)
                ->first();

            if ($token) {
                $this->isConnected = true;
                $this->step = 'dashboard';
                $this->loadRepositories();
            }
        }
    }

    public function redirectToGithub(): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $clientId = config('services.github.client_id');
        $redirectUri = route('github.callback');
        $scope = 'repo,user';

        $url = 'https://github.com/login/oauth/authorize?'.http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => $scope,
            'state' => session()->token(),
        ]);

        return redirect($url);
    }

    public function handleGithubCallback($code): void
    {
        $this->loading = true;

        try {
            throw_unless($code, Exception::class, 'Código de autorización no recibido');

            $clientId = config('services.github.client_id');
            $clientSecret = config('services.github.client_secret');

            throw_if( ! $clientId || ! $clientSecret, Exception::class, 'GitHub credentials no configuradas en .env');

            // Intercambiar código por token
            $response = Http::asForm()
                ->withHeaders(['Accept' => 'application/json'])
                ->post('https://github.com/login/oauth/access_token', [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'code' => $code,
                ]);

            $data = $response->json();

            \Illuminate\Support\Facades\Log::info('GitHub Token Response:', $data ?? []);

            if (isset($data['error'])) {
                throw new Exception('GitHub error: '.($data['error_description'] ?? $data['error']));
            }

            if ( ! isset($data['access_token']) || empty($data['access_token'])) {
                throw new Exception('No access token received. Response: '.json_encode($data));
            }

            $token = $data['access_token'];

            // Obtener información del usuario
            $userResponse = Http::withToken($token)
                ->withHeaders(['Accept' => 'application/vnd.github.v3+json'])
                ->get('https://api.github.com/user');

            if ($userResponse->failed()) {
                throw new Exception('Error al obtener información del usuario: '.$userResponse->body());
            }

            $githubUser = $userResponse->json();

            if ( ! $githubUser || ! isset($githubUser['id'])) {
                throw new Exception('No user data received from GitHub: '.json_encode($githubUser));
            }

            // Guardar el token
            GithubToken::query()->updateOrCreate(['user_id' => Auth::id()], [
                'github_id' => $githubUser['id'],
                'github_login' => $githubUser['login'] ?? 'unknown',
                'access_token' => encrypt($token),
                'is_valid' => true,
            ]);

            $this->isConnected = true;
            $this->step = 'dashboard';
            $this->githubUser = $githubUser;
            $this->message = '✓ Conectado exitosamente con GitHub como '.($githubUser['login'] ?? 'usuario');
            $this->loadRepositories();

        } catch (Exception $exception) {
            \Illuminate\Support\Facades\Log::error('GitHub Auth Error: '.$exception->getMessage());
            $this->message = 'Error: '.$exception->getMessage();
            $this->isConnected = false;
            $this->step = 'login';
        }

        $this->loading = false;
    }

    public function loadRepositories(): void
    {
        if ( ! Auth::check()) {
            return;
        }

        $tokenRecord = GithubToken::query()->where('user_id', Auth::id())->first();
        if ( ! $tokenRecord) {
            return;
        }

        try {
            $token = decrypt($tokenRecord->access_token);

            $response = Http::withToken($token)
                ->withHeaders(['Accept' => 'application/vnd.github.v3+json'])
                ->get('https://api.github.com/user/repos', [
                    'sort' => 'updated',
                    'per_page' => 30,
                ]);

            if ($response->successful()) {
                $this->repositories = $response->json() ?? [];
            } else {
                \Illuminate\Support\Facades\Log::error('Failed to load repos: '.$response->body());
                $this->message = 'Error al cargar repositorios';
            }
        } catch (Exception $exception) {
            \Illuminate\Support\Facades\Log::error('Error loading repositories: '.$exception->getMessage());
            $this->message = 'Error al cargar repositorios: '.$exception->getMessage();
        }
    }

    public function cloneRepository(string $repoName): void
    {
        $this->loading = true;

        try {
            $tokenRecord = GithubToken::query()->where('user_id', Auth::id())->first();
            if ( ! $tokenRecord) {
                $this->message = 'Token no encontrado';
                $this->loading = false;

                return;
            }

            $token = decrypt($tokenRecord->access_token);
            $login = $tokenRecord->github_login;

            // URL con autenticación
            $cloneUrl = sprintf('https://%s@github.com/%s/%s.git', $token, $login, $repoName);

            $targetPath = storage_path('app/github-repos/' . $repoName);

            // Limpiar si existe
            if (is_dir($targetPath)) {
                $this->deleteDirectory($targetPath);
            }

            $output = shell_exec('cd '.storage_path('app').sprintf(' && git clone %s github-repos/%s 2>&1', $cloneUrl, $repoName));

            $this->message = sprintf('Repositorio %s clonado exitosamente', $repoName);

            // GithubExecution::create([
            //     'user_id' => Auth::id(),
            //     'repo_name' => $repoName,
            //     'action' => 'clone',
            //     'status' => 'success',
            //     'message' => 'Repositorio clonado exitosamente',
            // ]);

            $this->selectedRepo = $repoName;

        } catch (Exception $exception) {
            $this->message = 'Error al clonar: '.$exception->getMessage();
        }

        $this->loading = false;
    }

    public function createPullRequest(): void
    {
        if ( ! $this->selectedRepo || ! $this->prTitle || ! $this->branch || ! $this->filePath || ! $this->fileContent) {
            $this->message = 'Por favor completa todos los campos';

            return;
        }

        $this->loading = true;

        try {
            $tokenRecord = GithubToken::query()->where('user_id', Auth::id())->first();
            $token = decrypt($tokenRecord->access_token);
            $login = $tokenRecord->github_login;

            // Configurar git
            shell_exec(sprintf("git config --global user.email '%s@github.com'", $login));
            shell_exec(sprintf("git config --global user.name '%s'", $login));

            $repoPath = storage_path('app/github-repos/' . $this->selectedRepo);

            // Crear rama
            shell_exec(sprintf('cd %s && git checkout -b %s', $repoPath, $this->branch));

            // Crear/modificar archivo
            $filePath = $repoPath.'/'.$this->filePath;
            $dir = dirname($filePath);

            if ( ! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            file_put_contents($filePath, $this->fileContent);

            // Commit y push
            shell_exec(sprintf('cd %s && git add %s', $repoPath, $this->filePath));
            shell_exec(sprintf("cd %s && git commit -m '%s'", $repoPath, $this->prTitle));
            shell_exec(sprintf('cd %s && git push origin %s', $repoPath, $this->branch));

            // Crear PR vía API
            $repo = collect($this->repositories)->firstWhere('name', $this->selectedRepo);

            $prResponse = Http::withToken($token)
                ->post(sprintf('https://api.github.com/repos/%s/pulls', $repo['full_name']), [
                    'title' => $this->prTitle,
                    'body' => $this->prDescription,
                    'head' => sprintf('%s:%s', $login, $this->branch),
                    'base' => $repo['default_branch'],
                ]);

            if ($prResponse->successful()) {
                $pr = $prResponse->json();
                $this->message = 'PR creado exitosamente: ' . $pr['html_url'];
                $this->resetPRForm();
            } else {
                $this->message = 'Error al crear PR: '.$prResponse->body();
            }

        } catch (Exception $exception) {
            $this->message = 'Error: '.$exception->getMessage();
        }

        $this->loading = false;
    }

    public function disconnect(): void
    {
        try {
            GithubToken::query()->where('user_id', Auth::id())->delete();
            $this->isConnected = false;
            $this->step = 'login';
            $this->message = 'Desconectado de GitHub';
            $this->reset('repositories', 'selectedRepo', 'githubUser');
        } catch (Exception $exception) {
            $this->message = 'Error al desconectar: '.$exception->getMessage();
        }
    }

    public function runRepository($repoName): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        return to_route('github.executions', ['repoName' => $repoName]);
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.github-auth');
    }

    private function resetPRForm(): void
    {
        $this->prTitle = '';
        $this->prDescription = '';
        $this->branch = '';
        $this->filePath = '';
        $this->fileContent = '';
    }

    private function deleteDirectory(string $path): void
    {
        if (is_dir($path)) {
            $files = array_diff(scandir($path), ['.', '..']);
            foreach ($files as $file) {
                $filePath = $path.'/'.$file;
                is_dir($filePath) ? $this->deleteDirectory($filePath) : unlink($filePath);
            }

            rmdir($path);
        }
    }
}
