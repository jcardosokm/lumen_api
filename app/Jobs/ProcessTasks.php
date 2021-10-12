<?php

namespace App\Jobs;

use App\Task;

class ProcessTasks extends Job
{
    /**
     * The task instance.
     *
     * @var \App\Task
     */
    protected $task;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->prepareStatus();
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //do something
    }
}
