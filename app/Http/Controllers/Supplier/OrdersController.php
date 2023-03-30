<?php

namespace App\Http\Controllers\Supplier;

use App\SuppliersOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use Auth;

class OrdersController extends Controller
{
	use Permission;
	/**
	* Display a listing of the resource.
	*/
	public function __construct()
	{
		$this->middleware('auth:vendor');
		$this->middleware(function ($request, $next) {
			if(!$this->hasVendorPermission(Auth::user())){
				return redirect('supplier/home');
			}
			return $next($request);
		});
	}

	public function index()
	{
        if (request()->ajax()) {
            $orders = SuppliersOrder::where('supplier_id', !empty(auth()->user()->parent_id)?auth()->user()->parent_id:auth()->id())
                ->with(['user', 'supplier', 'w2bOrder'])->latest('id')->where('status', '!=', 'cancelled');

            return datatables($orders)
                ->addIndexColumn()
                ->editColumn('user.first_name', function ($order) {
                    return $order->user->first_name . " " . $order->user->last_name;
                })
                ->addColumn('show', function ($order) {
                    return '<a href="' . route('supplier.orders.view_order', $order->id) . '" class="btn btn-info">Show</a>';
                })
                ->addColumn('action', function (SuppliersOrder $order) {
                    if($order->status == "processing") {
                        return '<select class="form-control" onchange="updateStatus1('. $order->id .', $(this))" >
                            <option value="processing" selected> processing</option>
                            <option value="shipped" > shipped</option>
                            <option value="cancelled" > Cancel</option>
                        </select>';
                    } elseif($order->status == "shipped") {
                        return '<select class="form-control" onchange="updateStatus1('. $order->id .', $(this))" >
                            <option value="processing" > processing</option>
                            <option value="shipped" selected> shipped</option>
                            <option value="cancelled" > Cancel</option>
                        </select>';
                    }  else {
                        return '<select class="form-control" onchange="updateStatus1('. $order->id .', $(this))" >
                            <option value="processing" > processing</option>
                            <option value="shipped" > shipped</option>
                            <option value="cancelled" selected> Cancel</option>
                        </select>';
                    }
                })
                ->rawColumns(['show', 'action'])
                ->toJson();
        }

		// $orders = SuppliersOrder::with(['user', 'supplier', 'w2bOrder'])->get();

		return view('supplier.orders.index');
	}

	/**
	* Display the specified resource.
	*/
	public function view_order($id)
	{
        $order = SuppliersOrder::with(['user', 'w2bOrder', 'w2bOrder.products'])->find($id);
        $order_items = $order->w2bOrder->products;

		return view('supplier/orders/show',compact('order', 'order_items'));
	}


	/**
	* Update the specified resource in storage.
	*/
	public function update(Request $request, $id)
	{
        SuppliersOrder::where('id', $id)->update(['status' => $request->status]);

        return [
            'success' => true,
        ];

	}


}
