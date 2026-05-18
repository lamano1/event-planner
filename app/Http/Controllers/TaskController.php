<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['label' => 'required|string', 'event_id' => 'required']);
        
        Task::create([
            'label' => $request->label,
            'event_id' => $request->event_id,
            'is_completed' => false
        ]);

        return back()->with('success', 'Tâche ajoutée !');
    }

    public function update(Task $task)
    {
        $task->update(['is_completed' => !$task->is_completed]);
        return back();
    }
}