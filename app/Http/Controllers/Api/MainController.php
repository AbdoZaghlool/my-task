<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Project as ProjectResource;

class MainController extends Controller
{
    public function projects()
    {
        $user = auth()->user();
        $projects = $user->projects()->with('tasks')->get();
        return ApiController::respondWithSuccess(ProjectResource::collection($projects));
    }
}