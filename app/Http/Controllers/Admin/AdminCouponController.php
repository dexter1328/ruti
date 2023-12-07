<?php

namespace App\Http\Controllers\Admin;

use App\AdminCoupon;
use Stripe\Stripe;
use App\Traits\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminCouponController extends Controller
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
		Stripe::setApiKey($this->stripe_secret);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons =  AdminCoupon::all();
        return view('admin.coupon.index', compact('coupons'));
    }

    public function updateStatus($id)
    {
        $coupon = AdminCoupon::find($id);
        if ($coupon) {
            $coupon->status = $coupon->status == 1 ? 0 : 1;
            $coupon->save();
        }

        return redirect()->back()->with('success', 'Coupon status updated successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    public function generate_coupon_code() {
        return response()->json(Str::random(10)) ;
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
            'code' => 'required',
            'title' => 'required|max:255',
            'start_date' => 'required',
            'expire_date' => 'required',
            'discount' => 'required|max:9',
            'min_purchase' => 'max:9',
            'max_discount' => 'max:9',
        ], [
            'title.max' => 'Title is too long!',
        ]);

        if ($request->discount_type == 'percent' && (int)$request->discount > 100) {
            return redirect()->back()->withErrors(['error' => 'discount_can_not_be_more_than_100%']);
        }

        DB::table('admin_coupons')->insert([
            'title' => $request->title,
            'code' => $request->code,
            'limit' => $request->limit,
            'coupon_type' => $request->coupon_type,
            'start_date' => $request->start_date,
            'expire_date' => $request->expire_date,
            'min_purchase' => $request->min_purchase != null ? $request->min_purchase : 0,
            'max_discount' => $request->max_discount != null ? $request->max_discount : 0,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin_coupon.index')->with('success', 'Coupon created successfully');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = AdminCoupon::find($id);
        if ($coupon) {
            $coupon->delete();
        }

        return redirect()->back()->with('success', 'Coupon deleted successfully');
    }
}
