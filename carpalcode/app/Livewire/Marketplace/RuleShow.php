<?php

namespace App\Livewire\Marketplace;

use Livewire\Component;

class RuleShow extends Component
{
    public array $rule;

    public function mount($id)
    {
        $this->rule = [
            'id' => $id,
            'title' => 'Collective to Spatie HTML',
            'type' => 'free',
        ];
    }

    public function render()
    {
        return view('livewire.marketplace.rule-show');
    }
}
