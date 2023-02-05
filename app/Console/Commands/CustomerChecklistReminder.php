<?php

namespace App\Console\Commands;

use DB;
use App\Traits\AppNotification;
use Illuminate\Console\Command;

class CustomerChecklistReminder extends Command
{
    use AppNotification;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_checklist:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer Checklist Reminder';

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
        $checklist = [];
        $customer_checklist = DB::table('checklists')->where('type', 'customer')->where('status', 'active')->get();
        $total_checklist = count($customer_checklist->toArray());

        $checklists = DB::table('completed_checklists')
            ->select(
                'users.id',
                DB::raw('COUNT(completed_checklists.id) as completed_checklist')
            )
            ->join('users', 'users.id', 'completed_checklists.user_id')
            ->where('completed_checklists.type', 'customer')
            ->where('completed_checklists.is_completed', 'yes')
            ->where('users.status', 'active')
            ->groupBy('completed_checklists.user_id')
            ->get();

        foreach ($checklists as $key => $checklist) {
            
            if($total_checklist > $$checklist->completed_checklist) {

                // send notification reminder to complete the checklist
                $id = null;
                $type = 'checklist';
                $title = 'Complete your To do list';
                $message = 'It is time to complete your To do list. Please follow the steps to complete the process.';
                $devices = DB::table('user_devices')->where('user_id', $checklist->id)->where('user_type','customer')->get();
                $this->sendNotification($title, $message, $devices, $type, $id);
            }
        }
    }
}
