<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 shadow rounded-lg">
            <div class="px-6 py-8 text-white">
                <h1 class="text-3xl font-bold">GitHub Repository Manager</h1>
                <p class="mt-2 text-blue-100">
                    Manage and clone your GitHub repositories with ease. Track executions, monitor performance, and access your projects quickly.
                </p>
                <div class="mt-4 flex space-x-3">
                    <a href="{{ url('/github') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        View Repositories
                    </a>
                    <a href="{{ url('/admin/github-connect') }}" 
                       class="inline-flex items-center px-4 py-2 border border-white/20 rounded-md text-sm font-medium text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        GitHub Connection
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white shadow rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Total Repositories
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ \App\Models\GithubExecution::where('user_id', auth()->id())->distinct('repo_name')->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Successful Clones
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ \App\Models\GithubExecution::where('user_id', auth()->id())->where('status', 'completed')->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Failed Executions
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ \App\Models\GithubExecution::where('user_id', auth()->id())->where('status', 'failed')->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    In Progress
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ \App\Models\GithubExecution::where('user_id', auth()->id())->whereIn('status', ['pending', 'cloning'])->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widgets Section -->
        <x-filament-widgets::widgets
            :widgets="$this->getWidgets()"
            :columns="$this->getColumns()"
        />

        <!-- Recent Activity -->
        <div class="bg-white shadow rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Activity</h3>
                    <a href="{{ url('/admin/github-executions') }}" 
                       class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400">
                        View all →
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
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-gray-700">
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
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $execution->repo_name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $execution->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($execution->status->value === 'completed') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                    @elseif($execution->status->value === 'failed') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                    @elseif($execution->status->value === 'cloning') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 @endif">
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
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No executions yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by cloning your first repository.</p>
                        <div class="mt-6">
                            <a href="{{ url('/github') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Start Cloning
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>