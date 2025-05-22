<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $tasks = Task::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Task/Index/Index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('Task/Create'); // Update with actual form component if necessary
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:todo,in-progress,done',
            'priority' => 'required|in:high,medium,low',
            'due_date' => 'nullable|date',
        ]);
        $new_task = new Task();
        $new_task->user_id = auth()->id();
        $new_task->title = $validated['title'];
        $new_task->description = $validated['description'];
        $new_task->status = $validated['status'];
        $new_task->priority = $validated['priority'];
        $new_task->due_date = $validated['due_date'];
        $new_task->save();

        return redirect()->route('tasks')->with('flash.banner', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Display task details (optional)
        $task = Task::findOrFail($id);
        return Inertia::render('Task/Show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $task = Task::findOrFail($id);
    
    return Inertia::render('Task/Edit', [ // Make sure this matches your file path
        'task' => [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'priority' => $task->priority,
            'due_date' => $task->due_date,
        ]
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:todo,in-progress,done',
            'priority' => 'required|in:high,medium,low',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::findOrFail($id);
        $task->update($validated);

        return redirect()->route('tasks')->with('flash.banner', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted!');
    }
}
