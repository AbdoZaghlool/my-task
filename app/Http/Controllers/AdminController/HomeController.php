<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function projects()
    {
        $projects = Project::with('creator')->get();
        return view('admin.projects.index', compact('projects'));
    }
}