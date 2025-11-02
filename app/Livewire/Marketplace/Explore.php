<?php

namespace App\Livewire\Marketplace;

use App\Models\Rule;
use Livewire\Component;

class Explore extends Component
{
    public string $search = '';

    public string $filter = '';

    public array $rules = [];

    public function mount(): void
    {
        $this->rules = Rule::all()->toArray();
    }

    public function render()
    {
        return view('livewire.marketplace.explore', ['rules' => $this->rules]);
    }

    public function updatedSearch()
    {
        $this->rules = collect($this->allRules)
            ->when($this->search, fn ($q) => $q->filter(fn ($r) => str_contains(strtolower($r['title']), strtolower($this->search))
            ))
            ->when($this->filter, fn ($q) => $q->where('type', $this->filter))
            ->values()
            ->toArray();
    }
}
