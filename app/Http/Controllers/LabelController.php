<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
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
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required|unique:labels',
                'description' => 'nullable|string'
            ],
            [
                'name.unique' => __('validation.label.name.unique')
            ]
        );

        $label = new Label($data);
        $label->save();
        flash(__('flash.label.store_success'))->success();

        return redirect()->route('labels.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Label $label)
    {
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
    public function update(Request $request, Label $label)
    {
        $data = $request->validate(
            [
                'name' => 'required|unique:labels',
                'description' => 'nullable|string'
            ],
            [
                'name.unique' => __('validation.label.name.unique')
            ]
        );

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
        try {
            $label->delete();
            flash(__('flash.label.destroy_success'))->success();
        } catch (\Exception $e) {
            flash(__('flash.label.destroy_error'))->error();
        }

        return redirect()->route('labels.index');
    }
}
