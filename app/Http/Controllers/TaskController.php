<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Task;
use App\Jobs\ProcessTasks;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Imtigger\LaravelJobStatus\JobStatus;
use DispatchesJobs;



class TaskController extends Controller
{

    public function showTask($uuid)
    {
        $task = Task::where('uuid', '=', $uuid)->first();
        $jobStatus = JobStatus::find($task->job_status_id);
        return response()->json([Task::where('uuid', '=', $uuid)->first(),$jobStatus->status], 200,);
    }

    public function create(Request $request)
    {
        //generate uuid
        $uuid = Str::uuid();
        $request->request->add(['uuid' => $uuid]);

        $task = Task::create($request->all());

        //calculate delay to dispatch
        $date = Carbon::parse($request->schedule_time);
        $now = Carbon::now();

        if ($date->gt($now)) {
            $diff = $date->diffInSeconds($now);

            //if date is in future delay $diff seconds 
            $job = new ProcessTasks($task);
            $job->delay(Carbon::now()->addSeconds($diff));
            $this->dispatch($job);
        } else {
            //if not delay 20sec for testing
            $job = new ProcessTasks($task);
            $job->delay(Carbon::now()->addSeconds(20));
            $this->dispatch($job);
        }

        $jobStatusId = $job->getJobStatusId();

        $updateTask = Task::where('uuid', '=', $uuid)->first();
        $updateTask->update(['job_status_id' => $jobStatusId]);

        return response()->json($updateTask, 201);
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
