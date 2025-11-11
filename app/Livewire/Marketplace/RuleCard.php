<?php

declare(strict_types=1);

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

        return to_route('rule.show', ['id' => $data['id']]);
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.marketplace.rule-card');
    }
}
