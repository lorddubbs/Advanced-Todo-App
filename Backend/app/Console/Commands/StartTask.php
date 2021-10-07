<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\StartTaskReminder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Console\Command;

class StartTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind user about tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = DB::table('tasks')->whereNotNull('start_date')
                                   ->where('start_date', '<=', Carbon::now()->add(60, 'minute')->toDateTimeString())
                                   ->where('start_date', '>', Carbon::now()->toDateTimeString())
                                   ->where('reminder', '0')
                                   ->get();
        foreach($tasks as $task) {
          $checkDay = $task->start_date->diff(Carbon::now())->days;
          Notification::send($task->user->email, new StartTaskReminder($tasks, $checkDay));
          $task->update([
              'reminder' => '0'
          ]);
        }
    }
}
