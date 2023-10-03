<?php

namespace App\Console\Commands;

use DB;
use App\Mail\WeeklyRetailerRegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class WeeklyRetailerRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retailer_register:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly registered retailer list';

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

        $users = \DB::table('vendors')
            ->select(
                'vendors.name',
                'vendors.email',
                'vendors.mobile_number',
                'vendors.address',
                'countries.name as country',
                'states.name as state',
                'cities.name as city',
                'vendors.pincode',
            )
            ->join('countries','countries.id','=','vendors.country')
            ->join('states','states.id','=','vendors.state')
            ->join('cities','cities.id','=','vendors.city')
            ->whereDate('vendors.created_at', '>=', $from)
            ->whereDate('vendors.created_at', '<=', $to)
            ->get();

        if($users->isNotEmpty()) {

            Mail::to('info@naturecheckout.com')->send(new WeeklyRetailerRegisterMail($users));
        }
    }
}
