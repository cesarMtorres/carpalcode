<div class="min-h-screen bg-gray-50">
    <!-- Menú de navegación -->
    <x-navigation-menu />

    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <!-- Mensajes -->
                @if ($message)
                    <div class="mb-4 p-4 {{ strpos($message, 'Error') !== false ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} rounded">
                        {{ $message }}
                    </div>
                @endif

    <!-- Estado de Conexión -->
    <div class="mb-6 p-4 bg-gray-50 rounded border border-gray-200 text-black">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">GitHub Integration</h2>
                @if ($githubUser)
                    <p class="text-green-600 mt-1">✓ Conectado como: <strong>{{ $githubUser['login'] }}</strong></p>
                @endif
            </div>
            @if ($isConnected)
                <button wire:click="disconnect" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Desconectar
                </button>
            @endif
        </div>
    </div>

    <!-- Login Step -->
    @if ($step === 'login' && !$isConnected)
        <div class="text-center">
            <h3 class="text-lg font-bold mb-4">Conecta tu cuenta de GitHub</h3>
            <button wire:click="redirectToGithub" class="px-6 py-3 bg-gray-800 text-white rounded hover:bg-gray-900 flex items-center gap-2 mx-auto">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v 3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                </svg>
                Conectar con GitHub
            </button>
        </div>
    @endif

    <!-- Dashboard Step -->
    @if ($step === 'dashboard' && $isConnected)
        <div class="space-y-6">
            <!-- Sección de Repositorios -->
            <div class="border rounded-lg p-4 text-black">
                <h3 class="text-lg font-bold mb-4">Tus Repositorios</h3>

                @if (empty($repositories))
                    <p class="text-gray-500">Cargando repositorios...</p>
                @else
                    <div class="space-y-2">
                        @foreach ($repositories as $repo)
                            <div class="flex justify-between items-center p-3 border rounded hover:bg-gray-50 transition">
                                <div class="flex-1">
                                    <div class="font-semibold">{{ $repo['name'] }}</div>
                                    <div class="text-sm text-gray-600">{{ $repo['description'] ?? 'Sin descripción' }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        ⭐ {{ $repo['stargazers_count'] }} | 🔀 {{ $repo['forks_count'] }}
                                    </div>
                                </div>
                                <button
                                    wire:click="runRepository('{{ $repo['name'] }}')"
                                    class="ml-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 whitespace-nowrap"
                                >
                                    Run
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

        <!-- Loading indicator -->
    @if ($loading)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded">
            <div class="bg-white p-6 rounded-lg">
                <div class="animate-spin inline-block w-6 h-6 border-4 border-blue-500 border-t-transparent rounded-full"></div>
                <p class="mt-2">Procesando...</p>
            </div>
        </div>
    @endif
            </div>
        </div>
    </div>
</div>
