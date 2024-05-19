<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WorkApplicationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Work $job , Request $request)
    //jadi ini route model binding apa2 bole tengok parameter kat route:list
    {
        // dd($job);

        //ini guna gate
        // Gate::authorize('apply', $job);

        // Check if the user can apply for this job
        // if (!$job->canUserApply($request->user())) {
        //     return redirect()->back()->with('error', 'You cannot apply for a job at your own company.');
        // }

        $this->authorize('canUserApply', $job);

        // ini guna user model(ini cek user tu kena login baru boleh apply/create kerja)
        //untuk setup ni kena set condtion dari model dulu/yg ni memng fungsi dari model
        //lepastu yg bawah ni sesuai guna kalau nak display custom view/message dekat view blade
        if ($request->user()->cannot('apply', $job)) {
            abort(403);
        }

        // $this->authorize('cannotApplyOwnJob', $job);

        return view('job_application.create', ['work' => $job]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Work $job, Request $request)
    {
        $this->authorize('canUserApply', $job);

        if ($request->user()->cannot('apply', $job)) {
            abort(403);
        }

        // dd($job);
        $validatedData = $request->validate([
            'expected_salary' => 'required|min:1|max:1000000',
            'cv' => 'required|file|mimes:pdf|max:2048',
        ]);

        $file = $request->file('cv');
        $path = $file->store('cvs', 'private');


        $job->workApplications()->create([
            //untuk dptkn current auth user login
            //maksud .. unpack elemet array
            // 'user_id' => auth()->user()->id,
            'user_id' => $request->user()->id,
            'expected_salary' => $validatedData['expected_salary'],
            'cv' => $path,
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job application submitted.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}