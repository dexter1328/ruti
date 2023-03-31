<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Traits\Permission;
use App\Vendor;
use App\W2bCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SupplierCategoryController extends Controller
{
    use Permission;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if(!$this->hasVendorPermission(Auth::user())){
                return redirect('admin/home');
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

        return view('admin/suppliers/categories/index',compact('categories'));
    }

    protected function getCategories($parent = null, $prefix = '')
    {
        $categories = W2bCategory::with('parent', 'supplier')->whereNotNull('supplier_id')->orderBy('id')->get();
        $category_list = '';
        if ($categories->isNotEmpty()) {
            foreach ($categories as $key => $category) {
                $category_list .= '<tr>';
                $category_list .= '<td>'.$prefix.$category->category1.'</td>';
                $category_list .= '<td>'. (!empty($category->parent) ? $category->parent->category1 : null) . '</td>';
                $category_list .= '<td>'. (!empty($category->supplier) ? $category->supplier->name : null) . '</td>';
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
        $suppliers = Vendor::supplier()->get();

        return view('supplier.categories.create', compact('categories','w2b_categories', 'suppliers'));
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
            'supplier_id'=> ['required'],
        ]);

        $category = new W2bCategory();
        $this->saveW2bCategory($request, $category);

        return redirect('/admin/supplier/categories')->with('success',"Category has been added.");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(W2bCategory $category)
    {
        $w2b_categories = W2bCategory::whereNull(['parent_id', 'supplier_id'])->orWhere(['parent_id' => 0])->get();
        $categories = W2bCategory::where('supplier_id', Auth::user()->id)->get();
        $item = $category;

        return view('admin/suppliers/categories/edit',compact('item','w2b_categories', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, W2bCategory $category)
    {
        $request->validate([
            'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'category'=> ['required'],
            'supplier_id'=> ['required'],
        ]);

        $this->saveW2bCategory($request, $category);

        return redirect('/admin/supplier/categories')->with('success',"Category has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(W2bCategory $category)
    {
        $category->delete();

        return redirect('/admin/supplier/categories')->with('success',"Category has been deleted.");
    }

    public function saveW2bCategory(Request $request, W2bCategory $category): void
    {
        $category->category1 = $request->input('category');
        $category->parent_id = $request->input('parent_id');
        $category->source_id = $request->input('source_id');
        $category->supplier_id = $request->input('supplier_id');

        if ($file = $request->file('image')) {
            $path = 'public/images/categories';
            $image = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($path, $image);
            $category->image = $image;
        }
        $category->save();
    }
}
