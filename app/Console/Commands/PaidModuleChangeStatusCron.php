<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\VendorPaidModule;

class PaidModuleChangeStatusCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paid_module_change_status:cron';

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
        $date = date('m/d/Y');
        $paid_module = VendorPaidModule::where('start_date','<',$date)->where('end_date','>',$date)->update(array('status'=>'no'));
    }
}
