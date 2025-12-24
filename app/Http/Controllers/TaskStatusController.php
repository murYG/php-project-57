<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Http\Requests\TaskStatusCreateUpdateRequest;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskStatusController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task_statuses = TaskStatus::orderBy('id')->paginate();
        return view('task_status.index', compact('task_statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task_status = new TaskStatus();
        return view('task_status.create', compact('task_status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStatusCreateUpdateRequest $request)
    {
        $data = $request->validated();

        $task_status = new TaskStatus($data);
        $task_status->save();
        flash(__('flash.task_status.store_success'))->success();

        return redirect()->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $task_status)
    {
        return view('task_status.edit', compact('task_status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskStatusCreateUpdateRequest $request, TaskStatus $task_status)
    {
        $data = $request->validated();

        $task_status->fill($data);
        $task_status->save();
        flash(__('flash.task_status.update_success'))->success();

        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $task_status)
    {
        if ($task_status->tasks()->exists()) {
            flash(__('flash.task_status.destroy_error'))->error();
        } else {
            $task_status->delete();
            flash(__('flash.task_status.destroy_success'))->success();
        }

        return redirect()->route('task_statuses.index');
    }
}
