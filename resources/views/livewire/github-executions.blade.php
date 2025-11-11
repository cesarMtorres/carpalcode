<div class="min-h-screen bg-gray-50">
    <!-- Menú de navegación -->
    <x-navigation-menu />

    <!-- resources/views/livewire/github-executions.blade.php -->
    <div class="max-w-6xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6">
                <!-- Header -->
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Ejecuciones de Clonado</h1>
                        <p class="text-gray-600 mt-1">Histórico de repositorios clonados</p>
                    </div>
                    <a href="{{ route('github.dashboard') }}" class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        ← Volver a Repositorios
        </a>
    </div>

    <!-- Mensajes -->
    @if ($message)
        <div class="mb-4 p-4 {{ strpos($message, 'Error') !== false ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} rounded">
            {{ $message }}
        </div>
    @endif

    <!-- Loading en progreso -->
    @if ($loading)
        <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded flex items-center gap-2">
            <div class="animate-spin inline-block w-4 h-4 border-2 border-blue-500 border-t-transparent rounded-full"></div>
            Clonando repositorio...
        </div>
    @endif

    <!-- Filtros -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Búsqueda -->
            <div>
                <label class="block text-sm font-semibold mb-2">Buscar por repositorio</label>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="ej: rector..."
                    class="w-full px-3 py-2 border rounded"
                />
            </div>

            <!-- Filtro de estado -->
            <div>
                <label class="block text-sm font-semibold mb-2">Filtrar por estado</label>
                <select wire:model.live="statusFilter" class="w-full px-3 py-2 border rounded">
                    <option value="">Todos</option>
                    <option value="pending">Pendiente</option>
                    <option value="cloning">Clonando</option>
                    <option value="completed">Completado</option>
                    <option value="failed">Error</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabla de Ejecuciones -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b-2 border-gray-300">
                    <th class="px-4 py-3 text-left font-semibold">Repositorio</th>
                    <th class="px-4 py-3 text-left font-semibold">Estado</th>
                    <th class="px-4 py-3 text-left font-semibold">Inicio</th>
                    <th class="px-4 py-3 text-left font-semibold">Finalización</th>
                    <th class="px-4 py-3 text-left font-semibold">Duración</th>
                    <th class="px-4 py-3 text-center font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($executions as $execution)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <!-- Repo Name -->
                        <td class="px-4 py-3">
                            <div class="font-semibold">{{ $execution->repo_name }}</div>
                            <div class="text-xs text-gray-500">{{ $execution->repo_url }}</div>
                        </td>

                        <!-- Status -->
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($execution->status === 'completed') bg-green-100 text-green-800
                                @elseif($execution->status === 'failed') bg-red-100 text-red-800
                                @elseif($execution->status === 'cloning') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif
                            ">
                                {{ $execution->status_label }}
                            </span>
                        </td>

                        <!-- Started -->
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @if($execution->started_at)
                                {{ $execution->started_at->format('Y-m-d H:i:s') }}
                            @else
                                —
                            @endif
                        </td>

                        <!-- Completed -->
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @if($execution->completed_at)
                                {{ $execution->completed_at->format('Y-m-d H:i:s') }}
                            @else
                                —
                            @endif
                        </td>

                        <!-- Duration -->
                        <td class="px-4 py-3 text-sm text-gray-600">
                            @if($execution->started_at && $execution->completed_at)
                                {{ $execution->completed_at->diffInSeconds($execution->started_at) }}s
                            @else
                                —
                            @endif
                        </td>

                        <!-- Acciones -->
                        <td class="px-4 py-3 text-center space-x-2">
                            @if($execution->status === 'completed')
                                <button
                                    onclick="navigator.clipboard.writeText('{{ $execution->clone_path }}')"
                                    class="px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600"
                                    title="Copiar ruta"
                                >
                                    📋
                                </button>
                            @endif

                            @if($execution->status === 'failed')
                                <button
                                    wire:click="retryExecution({{ $execution->id }})"
                                    class="px-3 py-1 text-xs bg-orange-500 text-white rounded hover:bg-orange-600"
                                >
                                    Reintentar
                                </button>
                            @endif

                            <button
                                wire:click="deleteExecution({{ $execution->id }})"
                                wire:confirm="¿Eliminar esta ejecución?"
                                class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>

                    <!-- Error Row -->
                    @if($execution->status === 'failed' && $execution->error_message)
                        <tr class="bg-red-50 border-b">
                            <td colspan="6" class="px-4 py-2">
                                <p class="text-sm text-red-800">
                                    <strong>Error:</strong> {{ $execution->error_message }}
                                </p>
                            </td>
                        </tr>
                    @endif

                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            No hay ejecuciones aún. Vuelve a repositorios y haz clic en "Run"
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $executions->links() }}
    </div>

    <!-- Stats -->
    @php
        $total = \App\Models\GithubExecution::where('user_id', auth()->id())->count();
        $completed = \App\Models\GithubExecution::where('user_id', auth()->id())->where('status', 'completed')->count();
        $failed = \App\Models\GithubExecution::where('user_id', auth()->id())->where('status', 'failed')->count();
    @endphp

    <div class="mt-8 grid grid-cols-3 gap-4 pt-6 border-t">
        <div class="bg-blue-50 p-4 rounded text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $total }}</div>
            <div class="text-sm text-gray-600">Total Ejecuciones</div>
        </div>
        <div class="bg-green-50 p-4 rounded text-center">
            <div class="text-2xl font-bold text-green-600">{{ $completed }}</div>
            <div class="text-sm text-gray-600">Completadas</div>
        </div>
        <div class="bg-red-50 p-4 rounded text-center">
            <div class="text-2xl font-bold text-red-600">{{ $failed }}</div>
            <div class="text-sm text-gray-600">Con Error</div>
        </div>
    </div>
            </div>
        </div>
    </div>
</div>
