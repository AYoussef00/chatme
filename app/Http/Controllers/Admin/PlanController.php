<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::all();

        return Inertia::render('Admin/Plans/Index', [
            'plans' => $plans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Plans/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        Plan::create($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plan = Plan::findOrFail($id);

        return Inertia::render('Admin/Plans/Show', [
            'plan' => $plan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = Plan::findOrFail($id);

        return Inertia::render('Admin/Plans/Edit', [
            'plan' => $plan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plan = Plan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $plan->update($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully!');
    }
}
