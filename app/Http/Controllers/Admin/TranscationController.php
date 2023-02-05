<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\User;
use App\Vendor;
use App\CustomerWallet;
use App\Orders;
use Carbon\Carbon;
use Auth;

class TranscationController extends Controller
{
    use Permission;
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:admin');
        // check for permission
        $this->middleware(function ($request, $next) {
            if(!$this->hasPermission(Auth::user())){
                return redirect('admin/home');
            }
            return $next($request);
        });
    }

    public function customerTransaction(Request $request)
    {
        $input = $request->transaction_filter;
        //$orders = [];
        $data = [];

        $customer_wallets = CustomerWallet::select('vendor_stores.name',
                'vendor_stores.image',
                'customer_wallets.id',
                'customer_wallets.type',
                'customer_wallets.amount',
                'customer_wallets.closing_amount',
                'customer_wallets.created_at',
                'customer_wallets.customer_id',
                'customer_wallets.sent_received_id',
                'users.wallet_amount',
                'users.email',
                'users.first_name',
                'users.last_name',
                'memberships.name as membership_name'
            )
            ->leftjoin('vendor_stores','vendor_stores.id','=','customer_wallets.store_id')
            ->join('users','users.id','=','customer_wallets.customer_id')
            ->join('user_subscriptions','user_subscriptions.user_id','=','users.id')
            ->join('memberships','memberships.id','=','user_subscriptions.membership_id');

        if($request->transaction_filter == 'monthly'){

            $customer_wallets = $customer_wallets->whereMonth('customer_wallets.created_at', Carbon::now()->month)
                ->whereYear('customer_wallets.created_at', Carbon::now()->year);
        }else if($request->transaction_filter == 'weekly'){

            $customer_wallets = $customer_wallets->where('customer_wallets.created_at', '>', Carbon::now()->startOfWeek())
                            ->where('customer_wallets.created_at', '<', Carbon::now()->endOfWeek());
        }else {

            $customer_wallets = $customer_wallets->whereDate('customer_wallets.created_at', '=', Carbon::today()->toDateString());
        }
        
        $customer_wallets = $customer_wallets->orderBy('customer_wallets.created_at', 'desc')->get();
        

        if($customer_wallets->isNotEmpty()) {

            foreach ($customer_wallets as $key => $value) {

                $type = $value->type;
                $wallet_amount = $value->wallet_amount;
                if($value->type == 'debit') {
                    $description = "paid to  ".$value->name;
                }elseif($value->type == 'credit') {
                    $description ='Money added to Wallet';
                }elseif($value->type == 'refund'){
                    $type = 'credit';
                    $description ='Refund Money to Wallet';
                }elseif($value->type == 'sent'){
                    $user = User::where('id', $value->sent_received_id)->first();
                    $description ='Sent to '.' '.$user->first_name.' '.$user->last_name;
                }elseif($value->type == 'received'){
                    $user = User::where('id', $value->sent_received_id)->first();
                    $description ='Received from '.' '.$user->first_name.' '.$user->last_name;
                }elseif($value->type == 'subscription_charge'){
                    $description = $value->first_name.' '.$value->last_name . ' subscribe for '.$value->membership_name;
                }elseif($value->type == 'one_time_fees'){
                    $description = $value->first_name.' '.$value->last_name . ' has joined the incentive program';
                }
                
                $data[] = array(
                    'first_name' => $value->first_name,
                    'last_name' => $value->last_name,
                    'type' => $type,
                    'description' => $description,
                    'amount' => $value->amount,
                    'closing_amount' => $value->closing_amount,
                    'placed_on' => $value->created_at
                );
            }
        }
        // echo '<pre>'; print_r($data); exit();
        /*$orders = Orders::selectRaw('sum(orders.total_price) as total_price,
                        sum(order_items.quantity) as quantity,
                        users.first_name,
                        users.last_name,
                        users.image,
                        orders.created_at')
                    ->join('users','users.id','orders.customer_id')
                    ->join('order_items','order_items.order_id','orders.id')
                    ->groupBy('orders.customer_id');
                  
        if($request->transaction_filter == 'monthly'){

            $orders = $orders->whereMonth('orders.created_at', Carbon::now()->month)
                ->whereYear('orders.created_at', Carbon::now()->year);
           
        }else if($request->transaction_filter == 'weekly'){

            $orders = $orders->where('orders.created_at', '>=', Carbon::now()->startOfWeek())
                ->where('orders.created_at', '<=', Carbon::now()->endOfWeek());
          
        }else {

            $orders = $orders->whereDate('orders.created_at', '=', Carbon::today()->toDateString());
        }

        $orders = $orders->get();*/
        return view('admin.transcations.customer_transaction',compact('data','input'));
    }

    public function vendorTransaction(Request $request)
    {
        $input = $request->transaction_filter;
        $orders = Orders::selectRaw(
                            'sum(orders.total_price) as total_price,
                            sum(order_items.quantity) as quantity,
                            vendors.business_name,
                            vendors.name,
                            vendors.image,
                            vendors.admin_commision,
                            vendors.bank_routing_number,
                            vendors.bank_account_number,
                            orders.created_at,
                            CONCAT(vendors.address, ", ", cities.name,", ", states.name,", ", countries.name) AS full_address'
                        )
                        ->join('vendors','vendors.id','orders.vendor_id')
                        ->join('order_items','order_items.order_id','orders.id')
                        ->leftjoin('countries','countries.id','vendors.country')
                        ->leftjoin('states','states.id','vendors.state')
                        ->leftjoin('cities','cities.id','vendors.city')
                        ->groupBy('orders.vendor_id');
        
        if($request->transaction_filter == 'monthly'){

            $orders = $orders->whereMonth('orders.created_at', Carbon::now()->month)
                ->whereYear('orders.created_at', Carbon::now()->year);
        }else if($request->transaction_filter == 'weekly'){

            $orders = $orders->where('orders.created_at', '>=', Carbon::now()->startOfWeek())
                ->where('orders.created_at', '<=', Carbon::now()->endOfWeek());
        }else {

            $orders = $orders->whereDate('orders.created_at', '=', Carbon::today()->toDateString());
        }
        $orders = $orders->get();

        $vendor_invoices = vendor::selectRaw(
                'invoices.amount_paid as total_price,
                invoices.created_at,
                vendors.business_name,
                vendors.name,
                vendors.image,
                vendors.bank_routing_number,
                vendors.bank_account_number,
                CONCAT(vendors.address, ", ", cities.name,", ", states.name,", ", countries.name) AS full_address'
            )
            ->join('invoices', 'invoices.customer_id', 'vendors.stripe_customer_id')
            ->leftjoin('countries','countries.id','vendors.country')
            ->leftjoin('states','states.id','vendors.state')
            ->leftjoin('cities','cities.id','vendors.city');
            
        if($request->transaction_filter == 'monthly'){

            $vendor_invoices = $vendor_invoices->whereMonth('invoices.created_at', Carbon::now()->month)
                ->whereYear('invoices.created_at', Carbon::now()->year);
        }else if($request->transaction_filter == 'weekly'){

            $vendor_invoices = $vendor_invoices->where('invoices.created_at', '>=', Carbon::now()->startOfWeek())
                ->where('invoices.created_at', '<=', Carbon::now()->endOfWeek());
        }else {

            $vendor_invoices = $vendor_invoices->whereDate('invoices.created_at', '=', Carbon::today()->toDateString());
        }
        $vendor_invoices = $vendor_invoices->get();

        
        $data = [];
        foreach ($orders as $key => $value) {

            $data[] = array(
                'image' => $value->image,
                'business_name' => $value->business_name,
                'name' => $value->name,
                'full_address' => $value->full_address,
                'type' => 'Order',
                'bank_routing_number' => $value->bank_routing_number,
                'bank_account_number' => $value->bank_account_number,
                'amount_recieved' => number_format($value->total_price,2),
                'less_transaction_fee' => number_format($value->total_price*$value->admin_commision/100,2),
                'amount_remitting' => number_format($value->total_price-$value->total_price*$value->admin_commision/100,2)
            );
        }

        foreach ($vendor_invoices as $key => $value) {

            $data[] = array(
                'image' => $value->image,
                'business_name' => $value->business_name,
                'name' => $value->name,
                'full_address' => $value->full_address,
                'type' => 'Subscription',
                'bank_routing_number' => $value->bank_routing_number,
                'bank_account_number' => $value->bank_account_number,
                'amount_recieved' => number_format($value->total_price/100,2),
                'less_transaction_fee' => 0,
                'amount_remitting' => 0
            );
        }

        return view('admin.transcations.vendor_transaction',compact('data','input'));
    }
    
}
