<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkRequest;
use App\Models\Work;
use Illuminate\Http\Request;

class MyWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAnyEmployer', Work::class);
        return view('my_job.index',[
            'works' => auth()->user()->employer
                ->works()
                ->with(['employer', 'workApplications', 'workApplications.user'])
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Work::class);
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkRequest $request)
    {
        // $validatedData = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'location' => 'required|string|max:255',
        //     'salary' => 'required|numeric|min:5000',
        //     'description' => 'required|string',
        //     'experience' => 'required|in:' . implode(',', Work::$experience),
        //     'category' => 'required|in:' . implode(',', Work::$category),
        //     // implode tu dia pecahkan string dari model Work, dia lebih kurang mcm construct
        // ]);

        // $request = $request->user();
        // $validatedData['user_id'] = $request->id;

        // dd($validatedData);

        $this->authorize('create', Work::class);
        //create job guna relation dari user(employer yg login sama mcm create company tu)
        auth()->user()->employer->works()->create($request->validated());

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job was created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Work $myJob)
    {
        $this->authorize('update', $myJob);
        return view('my_job.edit', [ 'work' => $myJob] );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkRequest $request, Work $myJob)
    {
        $this->authorize('update', $myJob);
        $myJob->update($request->validated());

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}