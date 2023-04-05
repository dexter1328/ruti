<?php

namespace App\Http\Controllers\Supplier;

use App\W2bCategory;
use Auth;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use DB;
use App\Traits\Permission;

class CategoryController extends Controller
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

	/**
	* Display a listing of the resource.
	*/
	public function index()
	{
		$categories = $this->getCategories();
		/*$categories = DB::table('categories as a')
		 	->leftjoin('categories AS b', 'b.id', '=', 'a.parent')
			->select('a.id', 'a.name', 'a.description', 'b.name as parent')
			->get();*/
		return view('supplier/categories/index',compact('categories'));
	}

	protected function getCategories($parent = null, $prefix = '')
	{
		$span = '<span>—</span>';
		$categories = W2bCategory::with('parent')->where('supplier_id', auth()->id())->orderBy('id')->get();
		$category_list = '';
//                dd($categories);
		if ($categories->isNotEmpty()) {
			foreach ($categories as $key => $category) {
				$category_list .= '<tr>';
					$category_list .= '<td>'.$prefix.$category->category1.'</td>';
					$category_list .= '<td>'. (!empty($category->parent) ? $category->parent->category1 : null) . '</td>';
					$category_list .= '<td class="action">';
						$category_list .= '<form id="deletefrm_'.$category->id.'" action="'.route('supplier.categories.destroy', $category->id).'" method="POST" onsubmit="return confirm(\""Are you sure?"\");">';
							$category_list .= '<input type="hidden" name="_token" value="'.csrf_token().'">';
							$category_list .= '<input type="hidden" name="_method" value="DELETE">';
							$category_list .= '<a href="'.route('supplier.categories.edit', $category->id).'" data-toggle="tooltip" data-placement="bottom" title="Edit Category">';
								$category_list .= '<i class="icon-note icons"></i>';
							$category_list .= '</a>';
							$category_list .= '<a href="javascript:void(0);" onclick="deleteRow('.$category->id.')" data-toggle="tooltip" data-placement="bottom" title="Delete Category">';
								$category_list .= '<i class="icon-trash icons"></i>';
							$category_list .= '</a>';
						$category_list .= '</form>';
					$category_list .= '</td>';
				$category_list .= '</tr>';

//				$category_list .= $this->getCategories($category->parent_id, $prefix . $span);
			}
		}
		return $category_list;
	}

	/**
	* Show the form for creating a new resource.
	*/
	public function create()
	{
		$w2b_categories = W2bCategory::whereNull(['parent_id', 'supplier_id'])->orWhere(['parent_id' => 0])->get();
        $categories = W2bCategory::where('supplier_id', Auth::user()->id)->get();

		return view('supplier.categories.create', compact('categories','w2b_categories'));
	}

	/**
	* Store a newly created resource in storage.
	*
	*/
	public function store(Request $request)
	{
		$request->validate([
			'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
			'category'=> ['required'],
		]);

		$category = new W2bCategory();
		$category->category1 = $request->input('category');
		$category->parent_id = $request->input('parent_id');
		$category->source_id = $request->input('source_id');
		$category->supplier_id = Auth::user()->id;

		if ($file = $request->file('image')){
			$path = 'public/images/categories';
			$image = date('YmdHis') . "." . $file->getClientOriginalExtension();
			$file->move($path, $image);
			$category->image = $image;
		}
		$category->save();

		return redirect('supplier/categories')->with('success',"Category has been added.");
	}

	/**
	* Display the specified resource.
	*/
	public function show(Category $category)
	{
		//
	}

	/**
	* Show the form for editing the specified resource.
	*/
	public function edit(W2bCategory $category)
	{
        $w2b_categories = W2bCategory::whereNull(['parent_id', 'supplier_id'])->orWhere(['parent_id' => 0])->get();
        $categories = W2bCategory::where('supplier_id', Auth::user()->id)->get();
        $item = $category;

		return view('supplier/categories/edit',compact('item','w2b_categories', 'categories'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, W2bCategory $category)
	{
		$id = $category->id;

        $request->validate([
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'category'=> ['required'],
        ]);

        $category->category1 = $request->input('category');
        $category->parent_id = $request->input('parent_id');
        $category->source_id = $request->input('source_id');
        $category->supplier_id = Auth::user()->id;

		if ($file = $request->file('image')){
			$path = 'public/images/categories';
			$image = date('YmdHis') . "." . $file->getClientOriginalExtension();
			$file->move($path, $image);
			$category->image = $image;
		}
		$category->save();

		return redirect('/supplier/categories')->with('success',"Category has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function destroy(W2bCategory $category)
	{
		$category->delete();
		return redirect('/supplier/categories')->with('success',"Category has been deleted.");
	}
}
