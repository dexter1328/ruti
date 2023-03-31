<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\VendorPayment;
use Auth;
use DB;

class SupplierPaymentController extends Controller
{
    use Permission;

    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if(!$this->hasPermission(Auth::user())){
                return redirect('admin/home');
            }
            return $next($request);
        });
    }

    public function index()
    {
       $vendor_payments = VendorPayment::select([
            'vendor_payments.amount',
            'vendor_payments.status',
            'vendor_payments.vendor_id as vendor_id',
            'vendors.name as vendor',
            DB::raw('sum(vendor_payments.amount) as total_price')
        ])
        ->join('vendors','vendors.id','=','vendor_payments.vendor_id')
        ->where('vendor_payments.status','=','pending')
        ->groupBy('vendor_payments.vendor_id')
        ->get();

        return view('admin.vendor_payment.index',compact('vendor_payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required'
        ]);

        foreach ($request->id as $key => $value) {
            VendorPayment::where('id',$value)->update(array('status'=>'completed','paid_date'=>date("Y-m-d"),'transaction_id' => $request->transaction_id));
        }
        echo json_encode('Translation Completed');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $payments = VendorPayment::select([
            'vendor_payments.amount',
            'vendor_payments.id as payment_id',
            'vendor_stores.name as store',
            'orders.order_no'
        ])
        ->join('vendor_stores','vendor_stores.id','=','vendor_payments.store_id')
        ->join('orders','orders.id','=','vendor_payments.order_id')
        ->where('vendor_payments.vendor_id','=', $id)
        ->where('vendor_payments.status','pending')
        ->get();
        return view('admin.vendor_payment.vendor_payment',compact('payments'));
        // echo json_encode($payment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function vendorPay(Request $request)
    {
        $sum = 0;
        $id = $request->id;
        foreach ($request->id as $key => $value) {
            $vendor_payment = VendorPayment::where('id',$value)->first();
            $sum += $vendor_payment->amount;
        }
        return response()->json(['sum'=>$sum,'id'=>$id]);
    }
}
