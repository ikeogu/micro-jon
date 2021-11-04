<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;

use App\Http\Resources\JobResource;
use App\Traits\ApiResponser;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class JobController extends Controller
{
    use ApiResponser;
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index','show','search');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jobs = Job::latest()->get();
        return JobResource::collection($jobs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $job =  new Job();

        $job->job_title = $request->job_title;
        $job->job_type = $request->job_type;
        $job->job_category = $request->job_category;
        $job->job_condition = $request->job_condition;
        $user = User::find(auth()->user()->id);
        $job->user()->associate($user);

        if ($job->save()) {
            return new JobResource($job);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
        return new JobResource($job);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        //

        // $updateJob= Job::whereId($job)->update($request->except('_token','_method'));
        $data = $request->all();
        $job->update($data);
        return new JobResource($job);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
        $job->delete();
        return $this->success([
            'item' => "Deleted"
        ]);
    }

    public function myjobs(){
     $me  = User::find(auth()->user()->id);
     return JobResource::collection($me->job);
    }
    public function search(Request $request){
        $q = $request->search;
        $jobs = Job::where('job_title', 'LIKE', '%' . $q . '%')
        ->orWhere('job_condition', 'LIKE', '%' . $q . '%')->orWhere('job_type', 'LIKE', '%' . $q . '%')->orWhere('job_category', 'LIKE', '%' . $q . '%')->get();
        return  (count($jobs) > 0) ? JobResource::collection($jobs) :response('Not Found', 404)->header('Content-Type', 'text/plain');;
            ;
    }
}