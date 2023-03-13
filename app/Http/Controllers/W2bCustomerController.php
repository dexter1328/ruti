<?php

namespace App\Http\Controllers;
use View;
use App\PageMeta;
use App\WbWishlist;
use App\W2bCategory;
use App\OrderedProduct;
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
        $categories2 = W2bCategory::inRandomOrder()
        ->whereNotIn('category1', ['others','other'])
        ->paginate(6);
        return view('front_end.user_account',compact('wb_wishlist','orders','categories2'));
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
         'w2b_orders.created_at as p_created_at', 'w2b_orders.status as p_status')
        ->get();
        // dd($ordered_products);
        $categories2 = W2bCategory::inRandomOrder()
        ->whereNotIn('category1', ['others','other'])
        ->paginate(6);

        return view('front_end.user_products',compact('wb_wishlist','ordered_products','categories2'));
    }

}
