<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Work::class);
        $filters = request()->only([
            'search',
            'min_salary',
            'max_salary',
            'experience',
            'category'
        ]);

        return view('job.index',
         ['works' => Work::with('employer')->latest()->filter($filters)->get()]);
    }
    /**
     * Display the specified resource.
     */
    // public function show(Work $id)
    // {

    //     return view('job.show',
    //     ['work' => Work::find($id)->load('employer')]);
    //     // ['work' => Work::find($id)->load('employer.works')]);
    // }

    // public function show(String $id)
    // {
    //     $work = Work::find($id);
    //     return view('job.show', compact('work'));
    // }

    public function show(Work $job)
    {
        //letak parameter kalau ada je kat authorize tu
        $this->authorize('view', $job);
        return view('job.show', ['work' => $job->load('employer')]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
