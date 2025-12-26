<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use App\Http\Requests\TaskCreateUpdateRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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

        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('task.index', compact('tasks', 'statuses', 'users', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();

        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('task.create', compact('task', 'statuses', 'users', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskCreateUpdateRequest $request)
    {
        $data = $request->validated();

        $currentUser = Auth::user();
        //$task = $currentUser->tasksByMe()->make($data);
        $task = new Task($data);
        $task->created_by_id = $currentUser->id;
        $task->save();

        $labels = $request->input('labels') ?? [];
        $task->labels()->sync($labels);

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
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');

        return view('task.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskCreateUpdateRequest $request, Task $task)
    {
        $data = $request->validated();

        $task->fill($data);
        $task->save();

        $labels = $request->input('labels') ?? [];
        $task->labels()->sync($labels);

        flash(__('flash.task.update_success'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->labels()->detach();
        $task->delete();

        flash(__('flash.task.destroy_success'))->success();

        return redirect()->route('tasks.index');
    }
}
