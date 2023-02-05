<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\Customer;
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
        $this->middleware('auth:vendor');
        // check for permission
        $this->middleware(function ($request, $next) {
            if(!$this->hasPermission(Auth::user())){
                return redirect('vendor/home');
            }
            return $next($request);
        });
    }

    public function customerTransaction(Request $request)
    {
        
        $input = $request->transaction_filter;
        $orders = Orders::selectRaw('sum(orders.total_price) as total_price,
                        sum(order_items.quantity) as quantity,
                        users.first_name,
                        users.last_name,
                        users.image,
                        orders.created_at')
                    ->join('users','users.id','orders.customer_id')
                    ->join('order_items','order_items.order_id','orders.id')
                    ->groupBy('orders.customer_id');
                  
        if($request->transaction_filter == 'monthly'){

            $orders = $orders->whereMonth('orders.created_at', Carbon::now()->month);
           
        }else if($request->transaction_filter == 'weekly'){

            $orders = $orders->where('orders.created_at', '>', Carbon::now()->startOfWeek())
                            ->where('orders.created_at', '<', Carbon::now()->endOfWeek());
          
        }else {

            $orders = $orders->whereDate('orders.created_at', '=', Carbon::today()->toDateString());
        }

        $orders = $orders->get();
        return view('vendor.transcations.customer_transaction',compact('orders','input'));
    }

}
