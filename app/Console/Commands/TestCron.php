<?php

namespace App\Console\Commands;

use Log;
use App\Admin;
use Illuminate\Console\Command;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        /*$admins = new Admin;
		$admins->name = 'testcron';
		$admins->email = 'testcron@gmail.com';
		$admins->password = '1212121212';
		$admins->role_id = 1;
		$admins->status = 'active';
		$admins->save();*/
        Log::info("Test Cron is working fine!");
        exit();
    }
}
