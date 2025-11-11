<div class="min-h-screen bg-gray-50">
    <!-- Menú de navegación -->
    <x-navigation-menu />

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header del perfil -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center">
                        <!-- Avatar -->
                        <div class="w-20 h-20 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center">
                            <span class="text-white text-2xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </span>
                        </div>
                        
                        <!-- Información del usuario -->
                        <div class="ml-6">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                Miembro desde {{ $user->created_at->format('F Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Acciones del perfil -->
                    @if($user->id === Auth::id())
                    <div class="mt-4 md:mt-0">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar Perfil
                        </button>
                    </div>
                    @endif
                </div>

                <!-- Estadísticas -->
                <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_projects'] }}</div>
                        <div class="text-sm text-blue-800">Proyectos</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['total_repositories'] }}</div>
                        <div class="text-sm text-green-800">Repositorios</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $stats['successful_clones'] }}</div>
                        <div class="text-sm text-purple-800">Clones Exitosos</div>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['purchased_rules_count'] }}</div>
                        <div class="text-sm text-yellow-800">Reglas Compradas</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navegación de tabs -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                    <button wire:click="setActiveTab('overview')" 
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                                   {{ $activeTab === 'overview' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Resumen
                    </button>
                    <button wire:click="setActiveTab('projects')" 
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                                   {{ $activeTab === 'projects' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Proyectos
                    </button>
                    <button wire:click="setActiveTab('rules')" 
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                                   {{ $activeTab === 'rules' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Reglas Compradas
                    </button>
                    <button wire:click="setActiveTab('repositories')" 
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                                   {{ $activeTab === 'repositories' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        Repositorios
                    </button>
                </nav>
            </div>
        </div>

        <!-- Contenido de las tabs -->
        <div class="bg-white shadow rounded-lg">
            <!-- Buscador (solo para tabs con contenido) -->
            @if($activeTab !== 'overview')
            <div class="p-6 border-b border-gray-200">
                <div class="relative">
                    <input type="text" 
                           wire:model.live="search"
                           placeholder="Buscar..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            @endif

            <div class="p-6">
                <!-- Tab: Resumen -->
                @if($activeTab === 'overview')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Actividad reciente -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Actividad Reciente</h3>
                        <div class="space-y-3">
                            @forelse($this->githubExecutions->take(3) as $execution)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-2 h-2 rounded-full mr-3 
                                    {{ $execution->status->value === 'completed' ? 'bg-green-500' : 
                                       ($execution->status->value === 'failed' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $execution->repo_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $execution->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-8">No hay actividad reciente</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Proyectos recientes -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Proyectos Recientes</h3>
                        <div class="space-y-3">
                            @forelse($this->projects->take(3) as $project)
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm font-medium text-gray-900">{{ $project->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $project->description ?? 'Sin descripción' }}</p>
                                <p class="text-xs text-gray-400">{{ $project->created_at->diffForHumans() }}</p>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-8">No hay proyectos</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tab: Proyectos -->
                @if($activeTab === 'projects')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($this->projects as $project)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900 truncate">{{ $project->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Activo
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">{{ $project->description ?? 'Sin descripción' }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $project->created_at->format('M d, Y') }}</span>
                            @if($project->repository_url)
                            <a href="{{ $project->repository_url }}" target="_blank" 
                               class="text-blue-600 hover:text-blue-800 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                Ver Repo
                            </a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay proyectos</h3>
                        <p class="mt-1 text-sm text-gray-500">Comienza creando tu primer proyecto.</p>
                    </div>
                    @endforelse
                </div>

                @if($this->projects->hasPages())
                <div class="mt-6">
                    {{ $this->projects->links() }}
                </div>
                @endif
                @endif

                <!-- Tab: Reglas Compradas -->
                @if($activeTab === 'rules')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($this->purchasedRules as $rule)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $rule->title ?? 'Regla #' . $rule->id }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Comprada
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">{{ $rule->description ?? 'Sin descripción disponible' }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>Comprada: {{ $rule->pivot->created_at->format('M d, Y') }}</span>
                            @if($rule->pivot->price)
                            <span class="font-medium text-green-600">${{ $rule->pivot->price }}</span>
                            @endif
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('rule.show', $rule->id) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Ver Detalles →
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No has comprado reglas</h3>
                        <p class="mt-1 text-sm text-gray-500">Explora el marketplace para encontrar reglas útiles.</p>
                        <div class="mt-6">
                            <a href="{{ route('marketplace') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Explorar Marketplace
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($this->purchasedRules->hasPages())
                <div class="mt-6">
                    {{ $this->purchasedRules->links() }}
                </div>
                @endif
                @endif

                <!-- Tab: Repositorios -->
                @if($activeTab === 'repositories')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($this->githubExecutions as $execution)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900 truncate">{{ $execution->repo_name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $execution->status->value === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($execution->status->value === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $execution->status->getLabel() }}
                            </span>
                        </div>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>Iniciado: {{ $execution->started_at ? $execution->started_at->format('M d, Y H:i') : 'No iniciado' }}</p>
                            @if($execution->completed_at)
                            <p>Completado: {{ $execution->completed_at->format('M d, Y H:i') }}</p>
                            @endif
                            @if($execution->error_message)
                            <p class="text-red-600 text-xs">{{ Str::limit($execution->error_message, 100) }}</p>
                            @endif
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            @if($execution->repo_url)
                            <a href="{{ $execution->repo_url }}" target="_blank" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.30.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                Ver Repo
                            </a>
                            @else
                            <span></span>
                            @endif
                            <span class="text-xs text-gray-500">{{ $execution->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay repositorios clonados</h3>
                        <p class="mt-1 text-sm text-gray-500">Conecta tu GitHub y clona tu primer repositorio.</p>
                        <div class="mt-6">
                            <a href="{{ route('github.dashboard') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                Ir a GitHub
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($this->githubExecutions->hasPages())
                <div class="mt-6">
                    {{ $this->githubExecutions->links() }}
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
