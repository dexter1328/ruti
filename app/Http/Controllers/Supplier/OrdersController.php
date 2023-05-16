<?php

namespace App\Http\Controllers\Supplier;

use App\City;
use Auth;
use Shippo;
use App\User;
use App\W2bOrder;
use App\OrderedProduct;
use App\SuppliersOrder;
use App\Traits\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\State;
use App\Vendor;
use App\W2bProduct;

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

	// public function index()
	// {
    //     if (request()->ajax()) {
    //         $orders = SuppliersOrder::where('supplier_id', !empty(auth()->user()->parent_id)?auth()->user()->parent_id:auth()->id())
    //             ->with(['user', 'supplier', 'w2bOrder'])->latest('id')->where('status', '!=', 'cancelled');

    //         return datatables($orders)
    //             ->addIndexColumn()
    //             ->editColumn('user.first_name', function ($order) {
    //                 return $order->user->first_name . " " . $order->user->last_name;
    //             })
    //             ->addColumn('show', function ($order) {
    //                 return '<a href="' . route('supplier.orders.view_order', $order->id) . '" class="btn btn-info">Show</a>';
    //             })
    //             ->addColumn('action', function (SuppliersOrder $order) {
    //                 if($order->status == "processing") {
    //                     return '<select class="form-control" onchange="updateStatus1('. $order->id .', $(this))" >
    //                         <option value="processing" selected> processing</option>
    //                         <option value="shipped" > shipped</option>
    //                         <option value="cancelled" > Cancel</option>
    //                     </select>';
    //                 } elseif($order->status == "shipped") {
    //                     return '<select class="form-control" onchange="updateStatus1('. $order->id .', $(this))" >
    //                         <option value="processing" > processing</option>
    //                         <option value="shipped" selected> shipped</option>
    //                         <option value="cancelled" > Cancel</option>
    //                     </select>';
    //                 }  else {
    //                     return '<select class="form-control" onchange="updateStatus1('. $order->id .', $(this))" >
    //                         <option value="processing" > processing</option>
    //                         <option value="shipped" > shipped</option>
    //                         <option value="cancelled" selected> Cancel</option>
    //                     </select>';
    //                 }
    //             })
    //             ->rawColumns(['show', 'action'])
    //             ->toJson();
    //     }

	// 	// $orders = SuppliersOrder::with(['user', 'supplier', 'w2bOrder'])->get();

	// 	return view('supplier.orders.index');
	// }
    public function index()
    {
        $op = OrderedProduct::join('w2b_orders', 'ordered_products.order_id', 'w2b_orders.order_id')
        ->join('users', 'w2b_orders.user_id', 'users.id')
        ->where('ordered_products.supplier_id', !empty(auth()->user()->parent_id)?auth()->user()->parent_id:auth()->id())
        ->select('ordered_products.*', 'w2b_orders.status as status', 'w2b_orders.is_paid as is_paid', 'users.first_name as user_name', 'users.id as user_id')
        ->get();



        // dd($op);


        return view('supplier.orders.index', compact('op'));

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

    public function supplierShippo($userId, $sku, $supplierId)
    {
        // dd('here');
        $supplier = Vendor::where('seller_type', 'supplier')->where('id', $supplierId)->first();
        $user = User::where('id', $userId)->first();
        $product = W2bProduct::where('sku', $sku)->first();
        $user_state = State::where('id', $user->state)->first();
        $user_city = City::where('id', $user->city)->first();
        $supplier_state = State::where('id', $supplier->state)->first();
        $supplier_city = City::where('id', $supplier->city)->first();
        Shippo::setApiKey('shippo_test_b66928bb949e945822b287f9b8a6580cdfca4ab0');

        // Example from_address array
        // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
        $from_address = array(
            'name' => $supplier->name,
            'company' => 'Shippo',
            'street1' =>  $supplier->address,
            'city' => $supplier_city->name,
            'state' => $supplier_state->name,
            'zip' => $supplier->pincode,
            'country' => 'US',
            'phone' => $supplier->mobile_number,
            'email' => $supplier->email,
        );

        // Example to_address array
        // The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
        $to_address = array(
            'name' => $user->first_name,
            'company' => $user->last_name,
            'street1' => $user->address,
            'city' => $user_city->name,
            'state' => $user_state->name,
            'zip' => $user->zip_code,
            'country' => 'US',
            'phone' => $user->mobile,
            'email' => $user->email,
        );

        // Parcel information array
        // The complete reference for parcel object is here: https://goshippo.com/docs/reference#parcels
        $parcel = array(
            'length'=> '5',
            'width'=> '5',
            'height'=> '5',
            'distance_unit'=> 'in',
            'weight'=> '2',
            'mass_unit'=> 'lb',
        );

        // Example shipment object
        // For complete reference to the shipment object: https://goshippo.com/docs/reference#shipments
        // This object has async=false, indicating that the function will wait until all rates are generated before it returns.
        // By default, Shippo handles responses asynchronously. However this will be depreciated soon. Learn more: https://goshippo.com/docs/async
        $shipment = \Shippo_Shipment::create(
        array(
            'address_from'=> $from_address,
            'address_to'=> $to_address,
            'parcels'=> array($parcel),
            'async'=> false,
        ));
        //  dd($shipment);

        // Rates are stored in the `rates` array
        // The details on the returned object are here: https://goshippo.com/docs/reference#rates
        // Get the first rate in the rates results for demo purposes.
        $rate = $shipment['rates'][0];
        // dd($rate);

        // Purchase the desired rate with a transaction request
        // Set async=false, indicating that the function will wait until the carrier returns a shipping label before it returns
        $transaction = \Shippo_Transaction::create(array(
            'rate'=> $rate['object_id'],
            'async'=> false,
        ));
        // dd($transaction);

        // Print the shipping label from label_url
        // Get the tracking number from tracking_number
        if ($transaction['status'] == 'SUCCESS'){
            return redirect()->back()->with('success', 'Order has been shipped');
            // echo "--> " . "Shipping label url: " . $transaction['label_url'] . "\n";
            // echo "--> " . "Shipping tracking number: " . $transaction['tracking_number'] . "\n";
        } else {
            return redirect()->back()->with('error', 'Order not shipped, Please try again later');
            // echo "Transaction failed with messages:" . "\n";
            // foreach ($transaction['messages'] as $message) {
            //     echo "--> " . $message . "\n";
            // }
        }
    }


}
