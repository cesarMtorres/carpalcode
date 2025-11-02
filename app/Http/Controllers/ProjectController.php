<?php

namespace App\Http\Controllers;

use App\Actions\Project\CreateProject;
use App\Http\Requests\CreateProjectRequest;
use App\Models\Project;

final readonly class ProjectController
{
    public function store(CreateProjectRequest $request, Project $project, CreateProject $action)
    {
        $project = $action->handle($project, $request->array('attributes'));

        return response()->json($project);
    }

    // Ejecutar reglas
    public function executeRules($projectId)
    {
        $results = $this->projectManager->executeRules($projectId);

        return response()->json($results);
    }

    // Listar proyectos
    public function index()
    {
        $projects = $this->projectManager->listProjects();

        return response()->json($projects);
    }

    // Info del proyecto
    public function show($projectId)
    {
        $info = $this->projectManager->getProjectInfo($projectId);

        return response()->json($info);
    }
}
