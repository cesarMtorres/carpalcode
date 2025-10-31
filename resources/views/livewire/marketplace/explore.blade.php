<div>
    <div class="min-h-screen bg-gray-50 py-10 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">🎯 Rule Marketplace</h1>

                <div class="flex items-center gap-3 mt-4 sm:mt-0">
                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="Search rules..."
                        class="rounded-lg border border-gray-300 px-4 py-2 focus:ring focus:ring-indigo-300 w-72"
                    >
                    <select wire:model.live="filter" class="rounded-lg border border-gray-300 px-3 py-2">
                        <option value="">All</option>
                        <option value="free">Free</option>
                        <option value="premium">Premium</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($rules as $rule)
                    <livewire:marketplace.rule-card :data="$rule" :key="$rule['id']" />
                @endforeach
            </div>

            @if (empty($rules))
                <p class="text-gray-500 text-center mt-10">No rules found.</p>
            @endif
        </div>
    </div>
</div>
