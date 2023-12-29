<?php

namespace App\Http\Controllers;

use App\Models\step;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        // Fetches tasks from the "Task" model along with their related "steps" only for the authenticated user
        $tasks = Task::with('steps', 'user')
            ->where('user_id', auth()->id()) // Filter tasks for the currently logged-in user
            ->latest()
            ->paginate(3);
    
        return view('user.taskindex', compact('tasks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('user.createform'); //Return Form for create new task
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required', // Validation
            'task_descripton' => 'required',
            'due_date' => 'required',
        ]);

        $task = Task::create(
            ['task' => $request->input('task'),
                'task_descripton' => $request->input('task_descripton'), // Create new Task in the Database
                'due_date' => $request->input('due_date'),
                'user_id' => auth()->user()->id]
        );

        // Split the 'step_descripton' string from the request into an array of individual steps.

        $steps = explode(',', $request->input('step_descripton'));
        $stepIds = [];

        // Retrieve an existing Step or create a new one if it doesn't exist.
        foreach ($steps as $step) {
            $stepModel = Step::firstOrCreate(['step_descripton' => trim($step)]);
            $stepIds[] = $stepModel->id;
        }

        // The IDs of the steps are attached to the newly created task
        $task->steps()->attach($stepIds);

        return redirect()->route('task.index')->with('success', 'Task created successfully.');

    }

    public function updateStatus(Request $request)
    {
        $stepIds = $request->input('step_ids', []); // Update the 'status' column in the 'steps' table
        Step::whereIn('id', $stepIds)->update(['status' => '1']);

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function Edit(Task $task)
    {
        return view('user.edit', compact('task')); // Return Edit Form
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task' => 'required',
            'task_descripton' => 'required', // Validation
            'step_descripton' => 'required',
            'due_date' => 'required',
        ]);

        $task->update($request->only(['task', 'task_descripton']));

        $steps = explode(',', $request->input('step_descripton'));
        $stepIds = [];

        // Attach the step to the task

        foreach ($steps as $step) {
            $stepModel = Step::firstOrCreate(['step_descripton' => trim($step)]);
            $task->steps()->syncWithoutDetaching([$stepModel->id]);
            $stepIds[] = $stepModel->id;
        }

        $task->steps()->sync($stepIds);

        return redirect()->route('task.index')->with('success', 'Task updated successfully.');
    }

    public function delete(Task $task)
    {
        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task deleted successfully.');
    }

}
