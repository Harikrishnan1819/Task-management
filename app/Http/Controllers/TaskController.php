<?php

namespace App\Http\Controllers;

use App\Models\step;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tasks = Task::latest()->paginate(5);
            return view('user.taskindex',compact('tasks'))
                        ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.createform');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'task' => 'required',
            'task_descripton' => 'required',
        ]);

        $task = Task::create(
           [ 'task' => $request->input('task'),
            'task_descripton' => $request->input('task_descripton'),
            'user_id'=> auth()->user()->id,]
        );

        $steps = explode(',', $request->input('step_descripton'));
        $stepIds = [];

        foreach ($steps as $step) {
            $stepModel = Step::firstOrCreate(['step_descripton' => trim($step)]);
            $stepIds[] = $stepModel->id;
        }

        // Attach steps to the task
        $task->steps()->attach($stepIds);


            return redirect()->route('task.index')->with('success', 'Task created successfully.');


    }

    public function updateStatus(Request $request)
    {
        $stepIds = $request->input('step_ids', []);

        Step::whereIn('id', $stepIds)->update(['status' => '1']);

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function Edit(Task $task)
    {
        return view('user.edit',compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task' => 'required',
            'task_descripton' => 'required',
            'step_descripton' => 'required',
        ]);

        $task->update($request->only(['task', 'task_descripton']));

        $steps = explode(',', $request->input('step_descripton'));
        $stepIds = [];

        foreach ($steps as $step) {
            // Find or create the step associated with the task
            $stepModel = Step::firstOrCreate(['step_descripton' => trim($step)]);

            // Ensure the step is associated with the task
            $task->steps()->syncWithoutDetaching([$stepModel->id]);

            $stepIds[] = $stepModel->id;
        }

        // Sync steps with the task
        $task->steps()->sync($stepIds);

        return redirect()->route('task.index')->with('success', 'Task updated successfully.');
    }

    public function delete(Task $task)
    {
        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task deleted successfully.');
    }


}
