<?php

namespace App\Http\Controllers;

use App\Models\WorkApplication;
use App\Models\Work;
use Illuminate\Http\Request;

class MyWorkApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view ('
        my_job_application.index',
            [
                //workapplication tu dari model user, dia relation
                'applications' => auth()->user()->workApplications()
                    // ->with('work') query dia banyak sbb x gabung skelai
                    //yg cara bawah ni dia gabung, jadi query dia sikit kalau load dekat debugbar
                    ->with(['work' => fn($query) => $query->withCount('workApplications')
                        ->withAvg('workApplications', 'expected_salary'),
                     'work.employer'])
                    ->latest()->get()
            ]
        );
    }

    //cara ke 2
    // public function index(Work $work)
    // {
    //     $user = auth()->user();
    //     $applications = $user->workApplications; // Fetch the user's applications

    //     return view('job_application.create', [
    //         'work' => $work,
    //         'applications' => $applications,
    //     ]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(WorkApplication $myJobApplication)
    {
        // dd($myJobApplication);
        $myJobApplication->delete();

        return redirect()->back()->with(
            'success',
            'Job application removed.'
        );
    }
}
