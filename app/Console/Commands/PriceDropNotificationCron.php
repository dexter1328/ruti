<?php

namespace App\Console\Commands;

use DB;
use App\Notification;
use App\Traits\AppNotification;
use Illuminate\Console\Command;

class PriceDropNotificationCron extends Command
{
    use AppNotification;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:price_drop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send price drop notification to the users who has this products on wishlist';

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
        $notifications = Notification::with('userWishlist')->get();

        if($notifications->isNotEmpty()){
            
            foreach ($notifications as $key => $notification) {

                $id = $notification->reference_id;
                $type = $notification->type;
                $title = $notification->title;
                $message = $notification->description;
                foreach ($notification->userWishlist as $key => $user_wishlist) {
                
                    $devices = DB::table('user_devices')->where('user_id', $user_wishlist->user_id)->where('user_type', 'customer')->get();
                    $this->sendNotification($title, $message, $devices, $type, $id);    
                }
                
                DB::table('notifications')->where('id', $notification->id)->delete();
            }
        }
    }
}
