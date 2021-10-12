<?php

use App\Http\Controllers\TaskController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TestTask extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function addTasks()
    {
        $this->call('POST', '/api/tasks/add', array('name' => 'Task 1', 'Description' => 'Description 1', 'schedule_time' => '2021-10-12 16:00:00',));
        
    }
}
