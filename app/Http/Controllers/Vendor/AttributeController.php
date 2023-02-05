<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use Validator;
use App\Attribute;
use App\AttributeValue;
use App\VendorStore;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Traits\Permission;

class AttributeController extends Controller
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
        $store_ids = getVendorStore();
        $attributes = Attribute::select('attributes.id','attributes.name','attributes.description','vendor_stores.name as store')
                            ->leftjoin('vendor_stores','vendor_stores.id','attributes.store_id')
                            ->whereIn('store_id',$store_ids)->get();
        return view('vendor/attributes/index',compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store_ids = getVendorStore();
        $vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
        return view('vendor/attributes/create',compact('vendor_stores'));
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
            
            'store_id' => 'required',
            // 'vendor_id' => 'required',
            'name'=> [
                'required',
                Rule::unique('attributes')->where(function ($query) use($name,$store_id) {
                    return $query->where('name', $name)
                    ->where('store_id', $store_id);
                }),
            ],
        ]);



        $attribute = new Attribute;
        $attribute->name = $request->input('name');
        $attribute->vendor_id = Auth::user()->id;
        $attribute->store_id = $request->input('store_id');
        $attribute->description = $request->input('description');
        $attribute->created_by = Auth::user()->id;
        $attribute->updated_by = Auth::user()->id;
        $attribute->save();

        if($request->has('values')){
            foreach ($request->values as $key => $value) {
                
                if($value!=''){
                    $attribute_value = new AttributeValue;
                    $attribute_value->attribute_id = $attribute->id;
                    $attribute_value->vendor_id = Auth::user()->id;
                    $attribute_value->store_id = $request->input('store_id');
                    $attribute_value->name = $value;
                    if($request->has('defual_value') && $request->defual_value == $key){
                        $attribute_value->is_default = 'yes';
                    }
                    $attribute_value->save();
                }
            }
        }
        return redirect('/vendor/attributes')->with('success',"Attribute has been added.");
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        die('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        $store_ids = getVendorStore();
        $vendor_stores = VendorStore::whereIn('id', $store_ids)->get();
        $attribute_values = AttributeValue::where('attribute_id', $attribute->id)->get();
        return view('vendor/attributes/edit',compact('attribute', 'attribute_values','vendor_stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        //echo '<pre>'; print_r($request->all()); echo '</pre>';exit();
        // print_r($attribute->id);die();
        $store_id = $request->input('store_id');
        $name = $request->input('name');
        $id = $attribute->id;
        $request->validate([
            // 'name' => 'required|unique:attributes,name,'.$attribute->id.',id|max:255',
            'name'=> [
                'required',
                Rule::unique('attributes')->where(function ($query) use($id, $name,$store_id) {
                    return $query->where('name', $name)
                    ->where('store_id', $store_id)
                    ->where('id', '<>', $id);
                }),
            ],
        ]);

        $attribute->name = $request->input('name');
        $attribute->store_id = $request->input('store_id');
        $attribute->description = $request->input('description');
        $attribute->updated_by = Auth::user()->id;
        $attribute->save();
        if($request->has('values')){
            foreach ($request->values as $key => $value) {
                
                if($value!=''){
                    if (array_key_exists($key,$request->value_ids)){
                        $attribute_value = AttributeValue::findOrFail($request->value_ids[$key]);

                    }else{
                        $attribute_value = new AttributeValue;
                        $attribute_value->attribute_id = $attribute->id;
                        $attribute_value->store_id = $request->input('store_id');
                    }
                    $attribute_value->name = $value;
                    if($request->has('defual_value') && $request->defual_value == $key){
                        $attribute_value->is_default = 'yes';
                    }else{
                        $attribute_value->is_default = 'no';
                    }
                    $attribute_value->save();
                }
            }
        }
        return redirect('/vendor/attributes')->with('success',"Attribute has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect('/vendor/attributes')->with('success',"Attribute has been deleted.");
    }

    public function deleteAttributeValue($id)
    {
        $attribute_value = AttributeValue::findOrFail($id);
        $attribute_value->delete();
        echo 1;exit();
    }
 
}
