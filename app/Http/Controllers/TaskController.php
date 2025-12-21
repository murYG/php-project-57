<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $filter = array_merge(
            array_fill_keys(['status_id', 'created_by_id', 'assigned_to_id'], null),
            $request->get('filter') ?? []
        );

        $taskQuery = Task::with('status', 'author', 'responsible')->orderBy('id');
        $tasks = QueryBuilder::for($taskQuery)
                ->allowedFilters([
                    AllowedFilter::exact('status_id'),
                    AllowedFilter::exact('created_by_id'),
                    AllowedFilter::exact('assigned_to_id')
                ])
                ->paginate()
                ->withQueryString();

        return view('task.index', compact('tasks', 'statuses', 'users', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view('task.create', compact('task', 'statuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required',
                'status_id' => 'required',
                'description' => 'nullable|string',
                'assigned_to_id' => 'nullable|integer:users'
            ]
        );

        $task = new Task($data);
        $task->save();
        $task->labels()->sync($request->input('labels'));

        flash(__('flash.task.store_success'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();

        return view('task.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate(
            [
                'name' => 'required',
                'status_id' => 'required',
                'description' => 'nullable|string',
                'assigned_to_id' => 'nullable|integer:users'
            ]
        );

        $task->fill($data);
        $task->save();
        $task->labels()->sync($request->input('labels'));

        flash(__('flash.task.update_success'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (!Gate::allows('destroy-task', $task)) {
            flash(__('flash.task.destroy_auth_error'))->error();
            return redirect()->route('tasks.index');
        }

        try {
            $task->delete();
            flash(__('flash.task.destroy_success'))->success();
        } catch (\Exception $e) {
            flash(__('flash.task.destroy_error'))->error();
        }

        return redirect()->route('tasks.index');
    }
}
