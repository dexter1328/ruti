<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Stripe;
use App\MembershipCoupon;
use App\Traits\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MembershipCouponController extends Controller
{
    use Permission;

    private $stripe_secret;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if(!$this->hasPermission(Auth::user())){
                return redirect('admin/home');
            }
            return $next($request);
        });

        $this->stripe_secret = config('services.stripe.secret');
        \Stripe\Stripe::setApiKey($this->stripe_secret);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $membership_coupons  = MembershipCoupon::select('membership_coupons.*', 'vendors.name as vendor_name', 'vendor_stores.name as store_name')
            ->join('vendors', 'vendors.id', 'membership_coupons.vendor_id')
            ->join('vendor_stores', 'vendor_stores.id', 'membership_coupons.store_id')
            ->get();
        return view('admin/membership_coupons/index',compact('membership_coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coupons = common_membership_coupons();
        $vendors = DB::table('vendors')->select('id','name')->where('status', 'active')->where('parent_id', 0)->get();
        return view('admin/membership_coupons/create', compact('coupons', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            //'coupon_code' => 'required',
            'stripe_coupon_id' => [
                'required',
                Rule::unique('membership_coupons')->where(function ($query) use($request) {
                    return $query->where('stripe_coupon_id', $request->stripe_coupon_id)
                        ->where('is_used', 'no')
                        ->where('vendor_id', $request->vendor)
                        ->where('store_id', $request->store);
                }),
            ],
            'name' => 'required',
            'discount' => 'required',
            'vendor' => 'required',
            'store' => 'required',
            //'type' => 'required',
            //'amount' => 'required|numeric',
            //'duration' => 'required',
            //'number_of_month' => 'required_if:duration,repeating'
        ],[
            'stripe_coupon_id.required' => 'The coupon code field is required.',
            'stripe_coupon_id.unique' => 'The coupon code has already been inserted for the selected store.',
            //'number_of_month.required_if' => 'The number of month field is required when duration is multiple month(s).'
        ]);

        /*$stripe_arr = array(
                'name' => $request->name,
                'duration' => $request->duration
            );
        if($request->type == 'percentage_discount'){
            $stripe_arr['percent_off'] = $request->amount;
        }else{
            $stripe_arr['amount_off'] = $request->amount;
        }
        if($request->duration == 'repeating'){
            $stripe_arr['duration_in_months'] = $request->number_of_month;
        }

        $coupon = \Stripe\Coupon::create($stripe_arr);
        $coupon_id = $coupon->id;*/

        $membership_coupon = new MembershipCoupon;
        $membership_coupon->vendor_id = $request->vendor;
        $membership_coupon->store_id = $request->store;
        $membership_coupon->stripe_coupon_id = $request->stripe_coupon_id;
        //$membership_coupon->stripe_coupon_id = $coupon_id;
        //$membership_coupon->code = $request->coupon_code;
        $membership_coupon->name = $request->name;
        //$membership_coupon->type = $request->type;
        //$membership_coupon->amount = $request->amount;
        //$membership_coupon->duration = $request->duration;
        //$membership_coupon->number_of_month = $request->number_of_month;
        $membership_coupon->discount = $request->discount;
        $membership_coupon->save();
        
        return redirect('/admin/membership-coupons')->with('success',"Membership coupon has been assigned to the vendor.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*$membership_coupons = common_membership_coupons();
        $coupon = MembershipCoupon::findOrFail($id);
        return view('/admin/membership_coupons/edit',compact('membership_coupons','coupon'));*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*$request->validate([
            'name' => 'required',
        ]);

        $membership_coupon = MembershipCoupon::findOrFail($id);
        $membership_coupon->name = $request->name;
        $membership_coupon->save();

        return redirect('/admin/membership-coupons')->with('success',"Membership coupon has been saved.");*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $membership_coupon = MembershipCoupon::findOrFail($id);
        $membership_coupon->delete();
        return redirect('/admin/membership-coupons')->with('success',"Membership coupon has been deleted.");
    }

    public function retrive($sid)
    {
        $coupon = \Stripe\Coupon::retrieve($sid);
        return response()->json($coupon);
    }
}
