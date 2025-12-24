<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Http\Requests\LabelCreateUpdateRequest;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LabelController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Label::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = Label::orderBy('id')->paginate();
        return view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $label = new Label();
        return view('label.create', compact('label'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LabelCreateUpdateRequest $request)
    {
        $data = $request->validated();

        $label = new Label($data);
        $label->save();
        flash(__('flash.label.store_success'))->success();

        return redirect()->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        return view('label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LabelCreateUpdateRequest $request, Label $label)
    {
        $data = $request->validated();

        $label->fill($data);
        $label->save();
        flash(__('flash.label.update_success'))->success();

        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash(__('flash.label.destroy_error'))->error();
        } else {
            $label->delete();
            flash(__('flash.label.destroy_success'))->success();
        }

        return redirect()->route('labels.index');
    }
}
