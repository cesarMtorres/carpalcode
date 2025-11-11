<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserProfile extends Component
{
    use WithPagination;

    public $user;

    #[\Livewire\Attributes\Url]
    public $activeTab = 'overview';

    #[\Livewire\Attributes\Url]
    public $search = '';

    public function mount(?User $user = null): void
    {
        $this->user = $user ?: Auth::user();
    }

    public function setActiveTab($tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[\Livewire\Attributes\Computed]
    public function projects()
    {
        return $this->user->projects()
            ->when($this->search, function ($query): void {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(6, ['*'], 'projectsPage');
    }

    #[\Livewire\Attributes\Computed]
    public function purchasedRules()
    {
        return $this->user->purchasedRules()
            ->when($this->search, function ($query): void {
                $query->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->latest('user_rules.created_at')
            ->paginate(6, ['*'], 'rulesPage');
    }

    #[\Livewire\Attributes\Computed]
    public function githubExecutions()
    {
        return $this->user->githubExecutions()
            ->when($this->search, function ($query): void {
                $query->where('repo_name', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(6, ['*'], 'executionsPage');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.user-profile', [
            'stats' => $this->user->stats,
        ]);
    }
}
