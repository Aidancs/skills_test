<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::orderBy('priority', 'asc')->get();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'tasks' => 'required'
        ]);

        $updated_tasks = $request->tasks;
        $tasks = Task::all();

        foreach ($tasks as $task) {
            $id = $task->id;
            foreach ($updated_tasks as $updated_task) {
                if ($updated_task['id'] == $id) {
                    $task->update([
                        'priority' => $updated_task['priority']
                    ]);
                }
            }
        }

        return back()->with('status', 'Task updated!');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'task_name' => 'required',
        ]);

        Task::create([
            'task_name' => $request->task_name,
            'priority' => $this->tasksCount() + 1,
        ]);

        return back()->with('status', 'Task created!');
    }

    public function edit(Task $task, $new_task_name)
    {
        $task->update([
            'task_name' => $new_task_name
        ]);

        return back()->with('status', 'Task edited!');
    }

    public function destroy(Task $task)
    {
        Task::where('id', $task->id)->delete();
        $tasks = Task::where('priority', '>', $task->priority)->get();

        $tasks->map(function ($task) {
            $task->update([
                'priority' => $task->priority - 1,
            ]);
        });

        return back()->with('status', 'Task deleted!');
    }

    public function tasksCount()
    {
        return Task::all()->count();
    }
}
