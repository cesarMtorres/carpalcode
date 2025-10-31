<?php

namespace App\Livewire\Marketplace;

use Livewire\Component;

class Explore extends Component
{
    public string $search = '';

    public string $filter = '';

    public array $rules = [];

    public function mount()
    {
        // Simulamos reglas de ejemplo (mock)
        $this->rules = [
            ['id' => 1, 'title' => 'Collective to Spatie HTML', 'type' => 'free', 'downloads' => 230, 'rating' => 4.8],
            ['id' => 2, 'title' => 'Migrate Eloquent to Query Builder', 'type' => 'premium', 'downloads' => 120, 'rating' => 4.9],
            ['id' => 3, 'title' => 'Blade Components to Volt', 'type' => 'free', 'downloads' => 400, 'rating' => 4.7],
        ];

    }

    public function render()
    {
        $rules = collect($this->rules)
            ->when($this->search, fn ($q) => $q->filter(fn ($r) => str_contains(strtolower($r['title']), strtolower($this->search))))
            ->when($this->filter, fn ($q) => $q->where('type', $this->filter))
            ->values()
            ->toArray();

        return view('livewire.marketplace.explore', ['rules' => $rules]);
    }
}
