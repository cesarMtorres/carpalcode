<?php

namespace App\Livewire\Marketplace;

use Livewire\Component;

class RuleShow extends Component
{
    public array $rule;

    public function mount($id)
    {
        // Simula carga desde BD o dataset
        $rules = [
            1 => [
                'id' => 1,
                'title' => 'Collective to Spatie HTML',
                'type' => 'free',
                'downloads' => 230,
                'rating' => 4.8,
            ],
            2 => [
                'id' => 2,
                'title' => 'Laravel to Symfony Migration',
                'type' => 'premium',
                'downloads' => 120,
                'rating' => 4.9,
            ],
            3 => [
                'id' => 3,
                'title' => 'Blade to Vue Converter',
                'type' => 'free',
                'downloads' => 90,
                'rating' => 4.7,
            ],
        ];
        $this->rule = $rules[$id] ?? ['title' => 'Rule not found'];

    }

    public function render()
    {
        return view('livewire.marketplace.rule-show');
    }
}
