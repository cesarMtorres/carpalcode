<?php

declare(strict_types=1);

namespace App\Livewire\Marketplace;

use App\Models\Rule;
use Livewire\Component;

class Explore extends Component
{
    public string $search = '';

    public string $filter = '';

    public array $rules = [];

    public array $allRules = [];

    public function mount(): void
    {
        $this->allRules = Rule::all()->toArray();
        $this->rules = $this->allRules;
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.marketplace.explore', ['rules' => $this->rules]);
    }

    public function updatedSearch(): void
    {
        $this->applyFilters();
    }

    public function updatedFilter(): void
    {
        $this->applyFilters();
    }

    private function applyFilters(): void
    {
        $this->rules = collect($this->allRules ?? $this->rules)
            ->when($this->search, fn ($q) => $q->filter(
                fn ($r): bool => str_contains(strtolower((string) $r['title']), strtolower($this->search))
            ))
            ->when($this->filter, fn ($q) => $q->where('type', $this->filter))
            ->values()
            ->toArray();
    }
}
