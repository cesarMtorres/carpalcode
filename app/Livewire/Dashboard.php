<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\Status;
use App\Models\GithubExecution;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $user = Auth::user();

        $stats = [
            'total_repositories' => GithubExecution::query()->where('user_id', $user->id)->distinct('repo_name')->count(),
            'successful_clones' => GithubExecution::query()->where('user_id', $user->id)->where('status', Status::COMPLETED)->count(),
            'projects' => $user?->projects()?->count() ?? 0,
            'purchased_rules' => $user->purchasedRules()->count(),
        ];

        $projectsWithRules = Project::query()->where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $recentExecutions = GithubExecution::query()->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.dashboard', [
            'stats' => $stats,
            'projectsWithRules' => $projectsWithRules,
            'recentExecutions' => $recentExecutions,
        ]);
    }
}
