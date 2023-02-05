<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Brand;
use App\Category;
use App\VendorStore;
use App\Page;
use App\Products;
use App\UserNotification;
use App\User;
use DB;

class CmsController extends Controller
{
	
	public function mobileCMS($slug)
	{
	
		$pages = Page::where('slug',$slug)->first();
		return view('admin/mobile_cms_page/about',compact('pages'));
	}
	
	
}
