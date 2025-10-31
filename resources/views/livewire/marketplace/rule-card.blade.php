<div>
    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition cursor-pointer"
         wire:click="$dispatch('openRule', { data: @js($data) })">

        <h2 class="text-lg font-semibold text-gray-800 mb-2">
            {{ $data['title'] }}
        </h2>

        <p class="text-sm text-gray-500 mb-3">
            Type: <span class="{{ $data['type'] === 'premium' ? 'text-yellow-600 font-semibold' : 'text-green-600' }}">
                {{ ucfirst($data['type']) }}
            </span>
        </p>

        <div class="flex justify-between text-sm text-gray-400">
            <span>⭐ {{ $data['rating'] }}</span>
            <span>⬇ {{ $data['downloads'] }}</span>
        </div>
    </div>

</div>
