<?php

namespace App\Livewire\Marketplace;

use Livewire\Attributes\On;
use Livewire\Component;

class RuleCard extends Component
{
    public array $rule = [];

    #[On('openRule')]
    public function handleOpen($data)
    {
        // Redirige al detalle
        return redirect()->route('rule.show', ['id' => $data['id']]);
    }

    public function render()
    {
        return view('livewire.marketplace.rule-card');
    }
}
