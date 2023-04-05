<?php

namespace App\Http\Controllers;

use App\GiftReceipt;
use View;
use App\User;
use App\PageMeta;
use App\WbWishlist;
use App\W2bCategory;
use App\OrderedProduct;
use App\ReturnItem;
use App\W2bOrder;
use App\W2bProduct;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class W2bCustomerController extends Controller
{
    public function __construct()
	{

		$page_meta = PageMeta::pluck('meta_value', 'meta_key')->all();
		View::share('page_meta', $page_meta);
        $categories = W2bCategory::with('childrens')->get();
        View::share('categories', $categories);



	}
    //
    public function userAccount()
    {
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
            ->get();
        }

        $orders = DB::table('w2b_orders')
        ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
        ->where('w2b_orders.is_paid','yes')
        ->get();

        $user = User::where('id', Auth::guard('w2bcustomer')->user()->id)->first();
        // dd($user_info);
        $categories2 = W2bCategory::whereIn('id', [1, 6, 9,12,20,23])
        ->get();
        return view('front_end.user_account',compact('wb_wishlist','orders','categories2','user'));
    }
    public function userProduct($id)
    {
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
            ->get();
        }

        $ordered_products = DB::table('w2b_orders')
        ->join('ordered_products', 'ordered_products.order_id', '=', 'w2b_orders.order_id')
        ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
        ->where('w2b_orders.is_paid','yes')
        ->where('w2b_orders.order_id', $id)
        ->select('ordered_products.*', 'w2b_orders.order_id as p_order_id', 'w2b_orders.total_price as p_total_price',
         'w2b_orders.created_at as p_created_at', 'w2b_orders.status as p_status', 'w2b_orders.user_id as p_user_id')
        ->get();
        //  dd($ordered_products);
        $categories2 = W2bCategory::whereIn('id', [1, 6, 9,12,20,23])
        ->get();

        return view('front_end.user_products',compact('wb_wishlist','ordered_products','categories2'));
    }

    public function orderInvoice($id)
    {
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
            ->get();
        }
        $order = DB::table('w2b_orders')
        ->join('users', 'users.id', '=', 'w2b_orders.user_id')
        ->join('states', 'states.id', '=', 'users.state')
        ->join('cities', 'cities.id', '=', 'users.city')
        ->where('w2b_orders.order_id', $id)
        ->select('w2b_orders.*', 'users.first_name as fname','users.last_name as lname','users.email as email',
        'users.address as address','users.zip_code as zip_code','users.mobile as mobile','states.name as state_name','cities.name as city_name')
        ->first();
        // dd($order);

        $ordered_products = DB::table('w2b_orders')
        ->join('ordered_products', 'ordered_products.order_id', '=', 'w2b_orders.order_id')
        ->where('w2b_orders.user_id', Auth::guard('w2bcustomer')->user()->id)
        ->where('w2b_orders.is_paid','yes')
        ->where('w2b_orders.order_id', $id)
        ->select('ordered_products.*', 'w2b_orders.order_id as p_order_id', 'w2b_orders.total_price as p_total_price',
         'w2b_orders.created_at as p_created_at', 'w2b_orders.status as p_status')
        ->get();
        //   dd($ordered_products);
        $categories2 = W2bCategory::whereIn('id', [1, 6, 9,12,20,23])
        ->get();

        return view('front_end.order_invoice',compact('wb_wishlist','order', 'ordered_products','categories2'));
    }

    public function userProfileUpdate(Request $request, $id)
    {
        //  dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'confirmed'
        ]);

        if ($request->filled('password')) {
            $input = $request->except('password_confirmation');
            $input['password'] = bcrypt($request->password);
        }
        else {
            $input = $request->except('password_confirmation','password');
        }
        //  dd($input);

        if ($image = $request->file('image')) {
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('user_photo'), $imageName);
            $input['image'] = $imageName;
        }else{
            unset($input['image']);
        }
        $user = User::where('id', $id)->first();

        $user->update($input);

        return redirect()->back()->withInput(['tab' => 'profile']);
    }

    public function giftReceipt($orderId)
    {
        # code...
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
            ->get();
        }
        $categories2 = W2bCategory::whereIn('id', [1, 6, 9,12,20,23])
        ->get();
        return view('front_end.gift_receipt', compact('wb_wishlist','categories2','orderId'));

    }

    public function giftReceiptUpdate(Request $request, $orderId)
    {
        # code...
        // dd($request->all());

        $input = $request->all();
        //  dd($input);


        GiftReceipt::create($input);


        return redirect('/user-account');

    }

    public function returnItem($sku, $orderId, $userId)
    {
        // dd($sku, $orderId, $userId);
        $wb_wishlist = null;

        if (Auth::guard('w2bcustomer')->user()) {
            $wb_wishlist = WbWishlist::where('user_id', Auth::guard('w2bcustomer')->user()->id)
            ->get();
        }
        $categories2 = W2bCategory::whereIn('id', [1, 6, 9,12,20,23])
        ->get();

        $product = W2bProduct::where('sku', $sku)->first();
        return view('front_end.return_item', compact('sku','orderId','userId','wb_wishlist','categories2','product'));
    }

    public function returnItemSubmit(Request $request)
    {
        # code...
        $input = $request->all();
        ReturnItem::create($input);
        return redirect('/user-account')->with('success', 'Your Request is in process. One of our representative will contact you soon.');;


    }

}
