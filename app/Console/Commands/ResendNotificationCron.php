<?php

namespace App\Console\Commands;

use DB;
use App\Traits\AppNotification;
use Illuminate\Console\Command;

class ResendNotificationCron extends Command
{
    use AppNotification;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:resend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resend Notification';

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
        $user_notifications = DB::table('user_notifications')
            ->select('user_notifications.*', 'user_devices.device_token')
            ->join("user_devices",function($join){
                    $join->on("user_devices.id","=","user_notifications.device_id")
                        ->on("user_devices.user_type","=","user_notifications.user_type");
                })
            ->where('user_notifications.is_send',0)
            ->where('user_notifications.resend','<',3)
            ->get();

        if($user_notifications->isNotEmpty()){
            
            foreach ($user_notifications as $key => $user_notification) {

                $id = $user_notification->reference_id;
                $type = $user_notification->type;
                $title = $user_notification->title;
                $message = $user_notification->description;
                $token = $user_notification->device_token;
                $response = $this->sendPushNotification($token, $title, $message, $type, $id);
                $someArray = json_decode($response, true);
                if($someArray['success'] == 1){
                    $suceess = 1;
                    DB::table('user_notifications')->where('id',$user_notification->id)->update(array('is_send'=>$suceess, 'updated_at' => now())); 
                }
                else{
                    $suceess = 0;
                    $resend = $user_notification->resend +1;
                    DB::table('user_notifications')->where('id',$user_notification->id)->update(array('resend'=>$resend, 'updated_at' => now())); 
                }
            }
            // \Log::info("notification:cron Cummand Run successfully!");
        }
    }
}
