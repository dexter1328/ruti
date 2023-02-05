<?php

namespace App\Console\Commands;

use DB;
use App\Mail\WeeklySuggestedStoreMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class WeeklySuggestedStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suggested_store:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly suggested stores by customer';

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
        $to = date('Y-m-d');
        $from = date('Y-m-d',strtotime("-7 days"));

        $suggested_stores = \DB::table('suggested_places')
                ->select(
                    'suggested_places.store', 
                    'suggested_places.address', 
                    'suggested_places.email', 
                    'suggested_places.mobile_no'
                )
                ->whereDate('suggested_places.created_at', '>=', $from)
                ->whereDate('suggested_places.created_at', '<=', $to)
                ->get();

        if($suggested_stores->isNotEmpty()) {

            Mail::to('joseph@ezsiop.com')->send(new WeeklySuggestedStoreMail($suggested_stores));
        }
    }
}
