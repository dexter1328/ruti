<?php

namespace App\Http\Controllers\Supplier;

use Auth;
use App\VendorSetting;
use App\Traits\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Vendor;

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
                return redirect('supplier/home');
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
        $settings = VendorSetting::where('vendor_id', Auth::user()->id)->where('seller_type', 'supplier')->get();
        $setting = [];
        //print_r($settings->toArray());
        foreach ($settings as $key => $value) {
           $setting[$value['key']] = $value['value'];
        }

        $fullfill_type = Vendor::where('id', Auth::user()->id)->first();
        //reminder to buyer

        return view('supplier/settings/index',compact('setting', 'fullfill_type'));
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
        return redirect('/supplier/settings')->with('success',"Setting has been changed.");
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

    //Setreminder for Buyer from supplier

    public function setReminderToBuyer(Request $request)
    {
        $checkDay = VendorSetting::where('vendor_id', Auth::user()->id)->where('key', 'remind_day_to_buyer')->where('seller_type','supplier')->first();
        $checkTime = VendorSetting::where('vendor_id', Auth::user()->id)->where('key', 'remind_time_to_buyer')->where('seller_type','supplier')->first();

        if($checkDay ){
            $checkDay->vendor_id =  Auth::user()->id;
            $checkDay->key = 'remind_day_to_buyer';
            $checkDay->value = $request->dayValue;
            $checkDay->seller_type = 'supplier';
            $checkDay->update();
        }else{
            $dayNew = new VendorSetting;
            $dayNew->vendor_id =  Auth::user()->id;
            $dayNew->key = 'remind_day_to_buyer';
            $dayNew->value = $request->dayValue;
            $dayNew->seller_type = 'supplier';
            $dayNew->save();  
        }
//create/update time
        if($checkTime ){
            $checkTime->vendor_id =  Auth::user()->id;
            $checkTime->key = 'remind_time_to_buyer';
            $checkTime->value = $request->timeValue;
            $checkTime->seller_type = 'supplier';
            $checkTime->update();
        }else{
            $dayNew = new VendorSetting;
            $dayNew->vendor_id =  Auth::user()->id;
            $dayNew->key = 'remind_time_to_buyer';
            $dayNew->value = $request->timeValue;
            $dayNew->seller_type = 'supplier';
            $dayNew->save();  
        }

        return back()->with('success', 'set successfully');
    }
}
