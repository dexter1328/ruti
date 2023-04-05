<?php

namespace App\Http\Controllers\Supplier;

use App\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductReview;
use App\Products;
use App\User;
use App\Orders;
use Auth;
use App\Traits\Permission;

class ProductReviewsController extends Controller
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

		$product_reviews = Rating::select([
                'w2b_products.title as product',
                'ratings.id',
                'ratings.comment',
                'ratings.star as rating',
                'ratings.user_name',
                'ratings.user_email',
                'users.first_name'
            ])
            ->join('w2b_products','w2b_products.sku','=', 'ratings.product_id')
            ->join('users','users.email','=', 'ratings.user_email')
            ->where('w2b_products.supplier_id', !empty(auth()->user()->parent_id)?auth()->user()->parent_id:auth()->id())
            ->get();

		return view('supplier/products_reviews/index',compact('product_reviews'));
	}

	/**
	* Remove the specified resource from storage.
	*/
	public function destroy(Rating  $rating)
	{
        $rating->delete();

		return redirect('/supplier/product_reviews')->with('success',"Review successfully deleted.");
	}
}
