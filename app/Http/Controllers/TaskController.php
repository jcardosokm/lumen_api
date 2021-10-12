<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Task;
use App\Jobs\ProcessTasks;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DispatchesJobs;



class TaskController extends Controller
{

    public function showTask($uuid)
    {
        return response()->json(Task::where('uuid', '=', $uuid)->first());
    }

    public function create(Request $request)
    {
        $uuid = Str::uuid();
        $request->request->add(['uuid' => $uuid]);

        $task = Task::create($request->all());

        //calculate delay to dispatch
        $date = Carbon::parse($request->schedule_time);
        $now = Carbon::now();
        $diff = $date->diffInSeconds($now);

        //$job = new ProcessTasks($task);
        //$job->delay(Carbon::now()->addSeconds(10));
        //$this->dispatch($job);
        $this->dispatch((new ProcessTasks($task))->delay(Carbon::now()->addSeconds(10)));
        
        //$jobStatusId = $job->getJobStatusId();
        //dd($jobStatusId);

        

        return response()->json($task, 201);
    }

    public function update($uuid, Request $request)
    {
        $task = Task::where('uuid', '=', $uuid)->first();
        $task->update($request->all());

        return response()->json($task, 200);
    }

    public function delete($uuid)
    {
        $task = Task::where('uuid', '=', $uuid)->first();
        return response('Deleted with success', 200);
    }
}
