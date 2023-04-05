<?php

namespace App\Http\Controllers\Supplier;

use App\W2bOrder;
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
                return redirect('supplier/home');
            }
            return $next($request);
        });
    }

    public function customerTransaction(Request $request)
    {

        $input = $request->transaction_filter;
        $orders = W2bOrder::selectRaw('sum(w2b_orders.total_price) as total_price,
                        sum(ordered_products.quantity) as quantity,
                        users.first_name,
                        users.last_name,
                        users.image,
                        w2b_orders.created_at')
                    ->join('users','users.id','w2b_orders.user_id')
                    ->join('ordered_products','ordered_products.order_id','w2b_orders.order_id')
                    ->groupBy(['w2b_orders.user_id']);

        if($request->transaction_filter == 'monthly'){

            $orders = $orders->whereMonth('w2b_orders.created_at', Carbon::now()->month);

        }else if($request->transaction_filter == 'weekly'){

            $orders = $orders->where('w2b_orders.created_at', '>', Carbon::now()->startOfWeek())
                            ->where('w2b_orders.created_at', '<', Carbon::now()->endOfWeek());

        }else {

            $orders = $orders->whereDate('w2b_orders.created_at', '=', Carbon::today()->toDateString());
        }

        $orders = $orders->get();
        return view('supplier.transcations.customer_transaction', compact('orders','input'));
    }

}
