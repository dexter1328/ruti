<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\VendorSetting;
use App\Traits\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
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
        $settings = VendorSetting::where('vendor_id', Auth::user()->id)->get();
        $setting = [];
        //print_r($settings->toArray());
        foreach ($settings as $key => $value) {
           $setting[$value['key']] = $value['value'];
        }

        
        return view('vendor/settings/index',compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'setting.*' => 'required',
        ]);

        foreach ($request->setting as $key => $value) {
            $setting = VendorSetting::where('vendor_id', Auth::user()->id)->where('key', $key)->first();
            if($setting){
                $data = array('value' => $value);
                VendorSetting::where('id',$setting->id)->update($data);
            }else{
                $data = array('vendor_id' => Auth::user()->id, 'key' => $key, 'value' => $value);
                VendorSetting::create($data);
            }
        }
        return redirect('/vendor/settings')->with('success',"Setting has been changed.");   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
