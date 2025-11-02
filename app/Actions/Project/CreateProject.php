<?php

namespace App\Actions\Project;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

final class CreateProject
{
    public function handle(Project $project, array $attributes): Project
    {
        DB::transaction(function () use ($project, $attributes) {

            $project = Project::create([
                'owner' => $attributes['owner'],
                'repo' => $attributes['repo'],
                'cloned_path' => $attributes['cloned_path'],
                'rules' => $attributes['rules'] ?? [],
            ]);
        });

        return $project;
    }
}
