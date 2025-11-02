<?php

namespace App\Actions\Rules;

class ApplyRuleAction
{
    public function handle(array $project): string
    {
        $projectPath = storage_path('app/projects/'.$project['name']);

        $rector = new RectorExecutor($projectPath);

        // Aplicar los cambios
        $result = $rector->apply(
            rules: $project['rules'] ?? null,
            paths: $project['paths'] ?? ['src', 'app']
        );

        return response()->json($result);
    }
}
