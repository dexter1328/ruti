<?php

namespace App\Console\Commands;

use DB;
use App\Traits\AppNotification;
use Illuminate\Console\Command;

class ParticipationExpired extends Command
{
    use AppNotification;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'participation:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer one year participation expired for incentive program';

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
        $customers = DB::table('users')
            ->where('status', 'active')
            ->where('is_join', 1)
            ->whereDate('joining_expired_date', '<', date('Y-m-d'))
            ->get();

        foreach ($customers as $key => $customer) {
            
            DB::table('users')->where('id',$customer->id)->update(array('is_join' => 0, 'updated_at' => now()));

            // send notification participation expired for incentive program
            $id = null;
            $type = 'incentive_program';
            $title = 'Incentive Program Expired';
            $message = 'Your participation in the incentive program has been expired. Participate again to win prizes, vouchers, gift cards, and many more.';
            $devices = DB::table('user_devices')->where('user_id', $customer->id)->where('user_type','customer')->get();
            $this->sendNotification($title, $message, $devices, $type, $id);
        }
    }
}
