<?php

namespace App\Livewire\Marketplace;

use App\Actions\Rules\TryCode;
use App\Models\Rule;
use Livewire\Component;

class RuleShow extends Component
{
    public array $rule;

    public string $ruleInput = '';

    public string $output = '';

    public function mount($id)
    {
        $this->rule = Rule::find($id)->toArray();
    }

    public function render()
    {
        return view('livewire.marketplace.rule-show');
    }

    public function tryRule()
    {
        $tryCode = new TryCode;
        $validated = $tryCode->validate($this->ruleInput);

        $executor = $tryCode->execute($this->ruleInput);

        $this->output = $executor['output'];
    }
}
