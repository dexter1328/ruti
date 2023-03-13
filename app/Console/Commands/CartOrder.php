<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Mail\CartOrderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CartOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart_order:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cart Order Mail';

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
        //
        $not_paid = DB::table('w2b_orders')->
        join('users', 'users.id', '=', 'w2b_orders.user_id')->
        where('w2b_orders.is_paid', 'no')
        ->whereDate( 'w2b_orders.created_at', '<=', now()->subDays(60))
        ->select('w2b_orders.*','users.email as user_email')
        ->get();
        // dd($not_paid);
        foreach ($not_paid as $np) {
            $date =  Carbon::parse($np->created_at)->format('d/m/Y');
            $details = [
                'title' => 'Your Application was last active ' . $date,
                'body' => "Hey there you have not orders a while and items are still in cart"
            ];
            Mail::to($np->user_email)->send(new CartOrderMail($details));
        }
    }
}
