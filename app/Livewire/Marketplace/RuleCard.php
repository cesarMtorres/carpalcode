<?php

namespace App\Livewire\Marketplace;

use Livewire\Attributes\On;
use Livewire\Component;

class RuleCard extends Component
{
    public array $data = [];

    #[On('openRule')]
    public function handleOpen(array $data = [])
    {
        if (empty($data['id'])) {
            return;
        }

        return redirect()->route('rule.show', ['id' => $data['id']]);
    }

    public function render()
    {
        return view('livewire.marketplace.rule-card');
    }
}
