<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            // $tasks = Task::all();
            $user = \Auth::user();

            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            // $tasks = Task::orderBy('id', 'asc')->paginate(25);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];

            //return view('tasks.index', [
            //    'tasks' => $tasks,
            // ]);
        }
        return view('tasks.index', $data);
    }

    public function dashboard() {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required|max:255',
        ]);

        $task = new Task;
        $task->user_id = \Auth::id();
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        return redirect('/dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        return redirect('/dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $request->validate([
                'status' => 'required|max:10',
                'content' => 'required|max:255',
            ]);

            $task = Task::findOrFail($id);

            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();

        return redirect('/dashboard');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);

        if(\Auth::id() === $task->user_id) {
            $task->delete();
            return redirect('/dashboard');
        }

        return redirect('/dashboard');
    }
}
