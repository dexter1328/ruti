<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class uploadData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
         $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($user)
    {
        $admins = new Admin;
        $admins->name = $user->name;
        $admins->email = $user->email;
        $admins->password = bcrypt($user->password);
        $admins->role_id = $user->role_id;
        $admins->status = $user->status;

        $admins->save();

    }
}
