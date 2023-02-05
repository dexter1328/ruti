<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use DB;
use App\Traits\Permission;
use App\Vendor;
use App\VendorStore;

class CategoryController extends Controller
{
	use Permission;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function __construct()
	{
		$this->middleware('auth:vendor');
		$this->middleware(function ($request, $next) {
			if(!$this->hasVendorPermission(Auth::user())){
				return redirect('vendor/home');
			}
			return $next($request);
		});
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		$categories = $this->getCategories();
		/*$categories = DB::table('categories as a')
		 	->leftjoin('categories AS b', 'b.id', '=', 'a.parent')
			->select('a.id', 'a.name', 'a.description', 'b.name as parent')
			->get();*/
		return view('vendor/categories/index',compact('categories'));
	}

	protected function getCategories($level = NULL, $prefix = '') 
	{
		$store_ids = getVendorStore();
		$span = '<span>—</span>';
		$categories = Category::where('parent', $level)->whereIn('store_id',$store_ids)->orderBy('id', 'asc')->get();
		$category_list = '';
		if ($categories->isNotEmpty()) {
			foreach ($categories as $key => $category) {

				//$category_list .= $prefix . $category->name . "\n";
				//$category_list .= '<tr><td>'.$prefix.$category->name .'</td></tr>';
				$category_list .= '<tr>';
					$category_list .= '<td>'.$prefix.$category->name.'</td>';
					$category_list .= '<td>'.nl2br(e($category->description)) ?: '-'.'</td>';
					//$category_list .= '<td>'.$category->parent.'</td>';
					$category_list .= '<td class="action">';
						$category_list .= '<form id="deletefrm_'.$category->id.'" action="'.route('vendor.categories.destroy', $category->id).'" method="POST" onsubmit="return confirm(\""Are you sure?"\");">';
							$category_list .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
							$category_list .= '<input type="hidden" name="_method" value="DELETE">';
							$category_list .= '<a href="'.route('vendor.categories.edit', $category->id).'" data-toggle="tooltip" data-placement="bottom" title="Edit Category">';
								$category_list .= '<i class="icon-note icons"></i>';
							$category_list .= '</a>';
							$category_list .= '<a href="javascript:void(0);" onclick="deleteRow('.$category->id.')" data-toggle="tooltip" data-placement="bottom" title="Delete Category">';
								$category_list .= '<i class="icon-trash icons"></i>';
							$category_list .= '</a>';
						$category_list .= '</form>';
					$category_list .= '</td>';
				$category_list .= '</tr>';
				
				$category_list .= $this->getCategories($category->id, $prefix . $span);
			}
		}
		return $category_list;
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$store_ids = getVendorStore();
		$categories = Category::all();
		$vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
		return view('vendor/categories/create',compact('categories','vendor_stores'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		$store_id = $request->input('store_id');
		$name = $request->input('name');
		$request->validate([
			// 'name' => 'required|unique:categories,name,NULL,id|max:255',
			'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
			'store_id' => 'required',
			'name'=> [
                'required',
                Rule::unique('categories')->where(function ($query) use($name,$store_id) {
                	return $query->where(DB::raw('LOWER(name)'), strtolower($name))
                    ->where('store_id', $store_id);
                }),
            ],
		]);
		$category = new Category;
		$category->name = $request->input('name');
		$category->description = $request->input('description');
		$category->vendor_id = Auth::user()->id;
		$category->store_id = $request->input('store_id');
		$category->parent = $request->input('parent');
		$category->created_by = Auth::user()->id;
		$category->updated_by = Auth::user()->id;

		if ($file = $request->file('image')){
			$path = 'public/images/categories';
			$image = date('YmdHis') . "." . $file->getClientOriginalExtension();
			$file->move($path, $image);   
			$category->image = $image;
		}
		$category->save();
		return redirect('/vendor/categories')->with('success',"Category has been added.");
	}

	/**
	* Display the specified resource.
	*
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function show(Category $category)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function edit(Category $category)
	{
		$store_ids = getVendorStore();
		$categories = Category::all();
		$vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
		return view('vendor/categories/edit',compact('category','categories','vendor_stores'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, Category $category)
	{
		$store_id = $request->input('store_id');
		$name = $request->input('name');
		$id = $category->id;
		$request->validate([
			// 'name' => 'required|unique:categories,name,'.$category->id.',id|max:255',
			'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
			'name'=> [
                'required',
                Rule::unique('categories')->where(function ($query) use($id, $name,$store_id) {
                    return $query->where(DB::raw('LOWER(name)'), strtolower($name))
                    ->where('store_id', $store_id)
                    ->where('id', '<>', $id);
                }),
            ],
		]);
		$category->name = $request->input('name');
		$category->description = $request->input('description');
		$category->store_id = $request->input('store_id');
		$category->parent = $request->input('parent');
		$category->updated_by = Auth::user()->id;

		if ($file = $request->file('image')){
			$path = 'public/images/categories';
			$image = date('YmdHis') . "." . $file->getClientOriginalExtension();
			$file->move($path, $image);   
			$category->image = $image;
		}
		$category->save();
		return redirect('/vendor/categories')->with('success',"Category has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Category $category)
	{
		$category->delete();
		return redirect('/vendor/categories')->with('success',"Category has been deleted.");
	}
}
