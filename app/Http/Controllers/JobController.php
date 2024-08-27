<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    // index route implementation for the Jobs
    public function index()
    {
        $jobs = Job::with('employer')->latest()->cursorPaginate(3);


        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    // create route implementation for the Jobs
    public function create()
    {
        return view('Jobs.create');
    }

    // show route implementation for the Jobs
    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    // store route implementation for the Jobs
    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        $job =  Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        Mail::to($job->employer->user)->queue(
            new JobPosted($job)
        );

        return redirect('/jobs');
    }

    // edit route implementation for the Jobs
    public function edit(Job $job)
    {
        // 1. User need to be signed in
//        if(Auth::guest()){
//            return redirect('/login');
//        }
        /*
         * Above logic is irrelevant since we have used the Gate
         */
        // 2. User need to be responsible for that Job
//        if($job->employer->user->isNot(Auth::user())){
//            abort(403);
//        }
        /*
        Above Block is extracted and put into a Gate..
        */
//        Gate::authorize('edit-job', $job);  removed, because same action is done with middleware authorization

        return view('jobs.edit', ['job' => $job]);
    }

    // update route implementation for the Jobs
    public function update(Job $job)
    {
        // validate
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        // authorize (onHold).. next chapter..

        // update the job
        // and persist
        // $job = Job::findOrFail($id);  // No Need of this because Job is found with Route Model Binding..

        // $job->title = request('title');
        // $job->salary = request('salary');
        // $job->save();                                  The method shown below also similar to this one..

        $job->update([
            'title' => request('title'),
            'salary' => request('salary')
        ]);

        // redirect to the job page..
        return redirect('/jobs/' . $job->id);
    }

    // delete route implementation for the Jobs
    public function delete(Job $job)
    {
        // authorize the request (on hold)

        // delete the job
        // $job = Job::findOrFail($id); // No need Route Model Binding is used later.

        $job->delete();

        // redirect
        return redirect('/jobs');
    }
}
