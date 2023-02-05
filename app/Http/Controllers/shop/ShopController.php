<?php

namespace App\Http\Controllers\shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index()
    {
        // dd('abc');
        $products = DB::table('w2b_products')->paginate(15);
        return view('front_end.shop',compact('products'));
    }
}
