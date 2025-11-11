<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarpalCode - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Menú de navegación -->
    <x-navigation-menu />

    <div class="min-h-screen">
        <!-- Main Content -->
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Welcome Section -->
                <div class="px-4 py-6 sm:px-0">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg">
                        <div class="px-6 py-8 text-white">
                            <h2 class="text-3xl font-bold">Bienvenido a CarpalCode</h2>
                            <p class="mt-2 text-blue-100 text-lg">
                                Administra tus repositorios de GitHub, rastrea operaciones de clonado y supervisa tu flujo de desarrollo.
                            </p>
                            <p class="mt-1 text-blue-200">
                                ¡Hola, {{ Auth::user()->name }}! 👋
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Cards -->
                <div class="px-4 py-6 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- GitHub Repositories -->
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                GitHub
                                            </dt>
                                            <dd class="text-lg font-medium text-gray-900">
                                                Repositorios
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('github.dashboard') }}" 
                                       class="w-full bg-blue-600 border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Ver y Clonar Repos
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Marketplace -->
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Reglas
                                            </dt>
                                            <dd class="text-lg font-medium text-gray-900">
                                                Marketplace
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('marketplace') }}" 
                                       class="w-full bg-green-600 border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Explorar Reglas
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Panel -->
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Filament
                                            </dt>
                                            <dd class="text-lg font-medium text-gray-900">
                                                Admin Panel
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <a href="{{ url('/admin') }}" 
                                       class="w-full bg-purple-600 border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                        Abrir Admin
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile -->
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Mi
                                            </dt>
                                            <dd class="text-lg font-medium text-gray-900">
                                                Perfil
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('user.profile', Auth::user()) }}" 
                                       class="w-full bg-indigo-600 border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Ver Perfil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Section -->
                <div class="px-4 py-6 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Mis Estadísticas</h3>
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Repositorios</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                        {{ \App\Models\GithubExecution::where('user_id', auth()->id())->distinct('repo_name')->count() }}
                                    </dd>
                                </div>
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Clones Exitosos</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-green-600">
                                        {{ \App\Models\GithubExecution::where('user_id', auth()->id())->where('status', 'completed')->count() }}
                                    </dd>
                                </div>
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Proyectos</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-blue-600">
                                        {{ Auth::user()->projects()->count() }}
                                    </dd>
                                </div>
                                <div class="text-center">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Reglas Compradas</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-purple-600">
                                        {{ Auth::user()->purchasedRules()->count() }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rule Reports Section -->
                <div class="px-4 py-6 sm:px-0">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">📊 Reportes de Rules Generados</h3>
                                <a href="{{ route('marketplace') }}" 
                                   class="text-sm text-blue-600 hover:text-blue-500">
                                    Ver Marketplace →
                                </a>
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            @php
                                $projectsWithRules = \App\Models\Project::where('user_id', auth()->id())
                                    ->latest()
                                    ->take(10)
                                    ->get();
                            @endphp

                            @if($projectsWithRules->count() > 0)
                                <div class="space-y-4">
                                    @foreach($projectsWithRules as $project)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-2 mb-2">
                                                        <h4 class="text-base font-semibold text-gray-900">{{ $project->name ?? ($project->repo ?? 'Proyecto sin nombre') }}</h4>
                                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                                            {{ ($project->status ?? 'pending') === 'completed' ? 'bg-green-100 text-green-800' : 
                                                               (($project->status ?? 'pending') === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                            {{ ucfirst($project->status ?? 'pending') }}
                                                        </span>
                                                    </div>
                                                    @if(isset($project->description) && $project->description)
                                                        <p class="text-sm text-gray-600 mb-2">{{ $project->description }}</p>
                                                    @endif
                                                    @if(isset($project->repository_url) && $project->repository_url)
                                                        <p class="text-xs text-gray-500 mb-3">
                                                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                                            </svg>
                                                            {{ $project->repository_url }}
                                                        </p>
                                                    @elseif(isset($project->repo) && $project->repo)
                                                        <p class="text-xs text-gray-500 mb-3">
                                                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                                            </svg>
                                                            {{ $project->owner ?? 'usuario' }}/{{ $project->repo }}
                                                        </p>
                                                    @endif
                                                    @php
                                                        $projectRules = [];
                                                        if (isset($project->rules) && is_string($project->rules)) {
                                                            $projectRules = json_decode($project->rules, true) ?? [];
                                                        } elseif (isset($project->rules) && is_array($project->rules)) {
                                                            $projectRules = $project->rules;
                                                        } elseif (method_exists($project, 'getRulesAttribute') || $project->relationLoaded('rules')) {
                                                            try {
                                                                $projectRules = $project->rules ?? [];
                                                            } catch (\Exception $e) {
                                                                $projectRules = [];
                                                            }
                                                        }
                                                    @endphp
                                                    @if(!empty($projectRules))
                                                        <div class="flex flex-wrap gap-2 mb-2">
                                                            @if(is_array($projectRules) && !empty($projectRules))
                                                                @foreach($projectRules as $ruleId => $ruleData)
                                                                    @php
                                                                        $ruleTitle = is_array($ruleData) ? ($ruleData['title'] ?? $ruleId) : (is_numeric($ruleId) ? 'Rule #' . $ruleId : $ruleId);
                                                                    @endphp
                                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                                        {{ $ruleTitle }}
                                                                    </span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <p class="text-xs text-gray-400 mt-2">
                                                        Generado: {{ $project->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay reportes aún</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza analizando un proyecto con rules desde el marketplace.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('marketplace') }}" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            Explorar Rules
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="px-4 py-6 sm:px-0">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Actividad Reciente</h3>
                                <a href="{{ route('user.profile', Auth::user()) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-500">
                                    Ver todo →
                                </a>
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            @php
                                $recentExecutions = \App\Models\GithubExecution::where('user_id', auth()->id())
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp

                            @if($recentExecutions->count() > 0)
                                <div class="space-y-3">
                                    @foreach($recentExecutions as $execution)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    @if($execution->status->value === 'completed')
                                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                    @elseif($execution->status->value === 'failed')
                                                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                    @elseif($execution->status->value === 'cloning')
                                                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                                    @else
                                                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $execution->repo_name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $execution->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                {{ $execution->status->value === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($execution->status->value === 'failed' ? 'bg-red-100 text-red-800' : 
                                                   ($execution->status->value === 'cloning' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                                {{ $execution->status->getLabel() }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay actividad aún</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza clonando tu primer repositorio.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('github.dashboard') }}" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.30.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                            </svg>
                                            Comenzar Ahora
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500">
                    CarpalCode GitHub Manager con Filament - Construido con Laravel y Livewire
                </p>
            </div>
        </footer>
    </div>
</body>
</html>