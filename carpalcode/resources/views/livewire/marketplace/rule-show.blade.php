<div>
    <div class="min-h-screen bg-gray-50 py-12 px-6">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow">
            <h1 class="text-3xl font-bold mb-2">{{ $rule['title'] }}</h1>

            <p class="text-gray-600 mb-4">
                <span class="px-2 py-1 text-xs rounded-full
                    {{ $rule['type'] === 'premium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                    {{ ucfirst($rule['type']) }}
                </span>
            </p>

            <p class="text-gray-700 mb-6">This rule helps you migrate Laravel Collective forms to Spatie HTML helpers easily.</p>

            <div class="flex items-center justify-between">
                <button class="px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    Try Demo
                </button>
                <button class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-50">
                    Back
                </button>
            </div>
        </div>
    </div>

</div>
