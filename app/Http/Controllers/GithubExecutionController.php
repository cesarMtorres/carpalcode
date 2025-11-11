<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class GithubExecutionController extends Controller
{
    public function __invoke(string $repoName): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {

        return view('github_execution', ['repoName' => $repoName]);
    }
}
