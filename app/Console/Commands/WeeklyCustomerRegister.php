<?php

namespace App\Console\Commands;

use DB;
use App\Mail\WeeklyCustomerRegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class WeeklyCustomerRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer_register:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly registered customer list';

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

        $users = \DB::table('users')
            ->select(
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.mobile',
                'users.address',
                'countries.name as country',
                'states.name as state',
                'cities.name as city',
                'users.pincode',
            )
            ->join('countries','countries.id','=','users.country')
            ->join('states','states.id','=','users.state')
            ->join('cities','cities.id','=','users.city')
            ->whereDate('users.created_at', '>=', $from)
            ->whereDate('users.created_at', '<=', $to)
            ->get();

        if($users->isNotEmpty()) {

            Mail::to('info@naturecheckout.com')->send(new WeeklyCustomerRegisterMail($users));
        }
    }
}
