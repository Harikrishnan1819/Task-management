<?php

namespace App\Console\Commands;

use App\Mail\DueDateMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DueDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:due-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = now();

        $users = User::whereHas('tasks', function ($query) use ($currentDate) {
            $query->where('due_date', $currentDate->toDateString());
        })->get();
        
        

        if ($users->count() > 0) {
            
            foreach ($users as $user) {
                foreach ($user->tasks as $task) {
                    if ($task->due_date) {
                        // Send email or perform other actions for tasks due today
                        Mail::to($user->email)->send(new DueDateMail($task->due_date, $user->name));
                       
                    }
                }
            }
        }

        return 0;
    }

}
