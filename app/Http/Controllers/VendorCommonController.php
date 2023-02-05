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

class VendorCommonController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:vendor');
		
	}

	protected function getStoresByVendorID($vid) 
	{
		$stores = VendorStore::select('id','name')->where('vendor_id',$vid)->where('status', 'enable')->get();
		echo json_encode($stores);
	}

	protected function getBrandsByStoreID($sid) 
	{
		$brands = Brand::select('id','name')->where('store_id',$sid)->where('status', 'enable')->get();
		echo json_encode($brands);
	}

	protected function getCategoriesByStoreID($sid) 
	{
		$categories = Category::select('id','name')->where('store_id',$sid)->where('status', 'enable')->get();
		echo json_encode($categories);
	}

	protected function getCategoriesDropDownByStoreID($sid) 
	{
		$result = [];
		$categories = Category::select('id','name','parent')->where('store_id',$sid)->where('status', 'enable')->get();
 		if($categories->isNotEmpty()){
			$ref   = [];
			$items = [];
			foreach ($categories as $key => $value) {
				
				$thisRef = &$ref[$value->id];

				$thisRef['id'] = $value->id;
				$thisRef['name'] = $value->name;
				$thisRef['parent'] = $value->parent;
				
				if($value->parent == 0) {
					$items[$value->id] = &$thisRef;
				} else {
					$ref[$value->parent]['child'][$value->id] = &$thisRef;
				}
			}
			$result = $this->getCategoriesDropDown('', $items);
		}
		return response()->json(['categories'=>$result]);
	}

	protected function getCategoriesDropDown($prefix, $items)
	{
		$str = '';
		$span = '<span>—</span>';
		foreach($items as $key=>$value) {
			$str .= '<option value="'.$value['id'].'">'.$prefix.$value['name'].'</option>';					
			if(array_key_exists('child',$value)) {
				$str .= $this->getCategoriesDropDown($prefix.$span, $value['child'],'child');
			}
			
		}
		return $str;
	}

	protected function getCategoriesHierarchyByStoreID($sid) 
	{
		$result = [];
		$categories = Category::select('id','name','parent')->where('store_id',$sid)->where('status', 'enable')->get();
 		if($categories->isNotEmpty()){
			$ref   = [];
			$items = [];
			foreach ($categories as $key => $value) {
				
				$thisRef = &$ref[$value->id];

				$thisRef['id'] = $value->id;
				$thisRef['name'] = $value->name;
				$thisRef['parent'] = $value->parent;
				
				if($value->parent == 0) {
					$items[$value->id] = &$thisRef;
				} else {
					$ref[$value->parent]['child'][$value->id] = &$thisRef;
				}
			}
			$result = $this->getCategoriesHierarchy($items);
		}
		return response()->json(['categories'=>$result]);

		//$categories = $this->getCategoriesHierarchy($sid);
		//return response()->json(['categories'=>$categories]);
	}

	protected function getCategoriesHierarchy($items)
	{
		$str = '<ul class="category_heirarchy">';
		foreach($items as $key=>$value) {
			$str .= '<li>';
				$str .= '<div class="icheck-material-primary">';
                    $str .= '<input type="checkbox" name="category[]" id="category_'.$value['id'].'" value="'.$value['id'].'" class="checkbox">';
                    $str .= '<label for="category_'.$value['id'].'">'.$value['name'].'</label>';
                $str .= '</div>';
				/*$str .= '<label>';
					$str .= '<input type="checkbox" name="" value="'.$value['id'].'"> '.$value['name'];
				$str .= '</label>';*/
				if(array_key_exists('child',$value)) {
					$str .= $this->getCategoriesHierarchy($value['child'],'child');
				}
			$str .= '</li>';
		}
		$str .= '</ul>';
		return $str;
	}

	public function mobileCMS($slug)
	{
	
		$pages = Page::where('slug',$slug)->first();
		return view('admin/mobile_cms_page/about',compact('pages'));
	}

	public function getProductByStore($sid)
	{
		$products = Products::where('store_id',$sid)->get();
		$str = '';
		foreach ($products as $key => $value) {
			# code...
			$str .= '<option value="'.$value['id'].'">'.$value['title'].'</option>';		
		}
			return response()->json(['products'=>$str]);
		// echo json_encode($str);
	}

	public function getState($id){
		$states = DB::table("states")->where('country_id',$id)->get();
		echo json_encode($states);
	}

	public function getCity($id){
		$cities = DB::table("cities")->where('state_id',$id)->get();
		echo json_encode($cities);
	}

	
	
}
