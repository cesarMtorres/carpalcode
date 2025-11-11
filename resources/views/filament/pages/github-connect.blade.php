<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Connection Status Card -->
        <div class="bg-white shadow rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gray-900 dark:bg-white rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white dark:text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                GitHub Connection
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @if($this->isConnected)
                                    Connected as <span class="font-medium">{{ $this->githubLogin }}</span>
                                @else
                                    Connect your GitHub account to start cloning repositories
                                @endif
                            </p>
                        </div>
                    </div>
                    <div>
                        @php
                            $status = $this->getGithubStatus();
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($status['color'] === 'success') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                            @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @endif">
                            @if($status['color'] === 'success')
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                            {{ $status['status'] === 'connected' ? 'Connected' : 'Disconnected' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Security Information -->
            <div class="bg-white shadow rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Security
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    Encrypted Tokens
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Your GitHub access tokens are encrypted and stored securely.
                    </p>
                </div>
            </div>

            <!-- Permissions Information -->
            <div class="bg-white shadow rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Permissions
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    Repository Access
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        We only request access to read and clone your repositories.
                    </p>
                </div>
            </div>

            <!-- Usage Information -->
            <div class="bg-white shadow rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Features
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-white">
                                    Quick Clone
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Clone repositories directly with one click from your dashboard.
                    </p>
                </div>
            </div>
        </div>

        @if(!$this->isConnected)
        <!-- Getting Started Guide -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:border-blue-800">
            <div class="p-6">
                <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100 mb-4">
                    Getting Started
                </h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                1
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                Click the "Connect to GitHub" button to start the authentication process.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                2
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                Authorize the application on GitHub to access your repositories.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-medium">
                                3
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-800 dark:text-blue-200">
                                Start cloning and managing your repositories from the dashboard.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($this->isConnected)
        <!-- Connected User Information -->
        <div class="bg-green-50 border border-green-200 rounded-lg dark:bg-green-900/20 dark:border-green-800">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-green-900 dark:text-green-100">
                            Successfully Connected!
                        </h3>
                        <p class="text-sm text-green-700 dark:text-green-200">
                            Your GitHub account <strong>{{ $this->githubLogin }}</strong> (ID: {{ $this->githubId }}) is now connected.
                            You can view and clone your repositories from the main dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-filament-panels::page>