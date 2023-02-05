<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use App\Traits\Permission;
use Auth;

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
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if(!$this->hasPermission(Auth::user())){
                return redirect('admin/home');
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
        $settings = Setting::all();
        $setting = [];
        //print_r($settings->toArray());
        foreach ($settings as $key => $value) {
           $setting[$value['key']] = $value['value'];
        }

        
        return view('admin/settings/index',compact('setting'));
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
        ],[
            'setting.reward_point_max_per_order.required' => 'The reward point max % per order field is required',
            'setting.cancel_return_order_limit.required' => 'The cancel/return order limit field is required',
            'setting.price_drop_alert.required' => 'The price drop alert % field is required',
        ]);

        foreach ($request->setting as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if($setting){
                $data = array('key' => $key, 'value' => $value);
                Setting::where('id',$setting->id)->update($data);
            }else{
                $data = array('key' => $key, 'value' => $value);
                Setting::create($data);
            }
        }
        return redirect('/admin/settings')->with('success',"Setting has been changed.");
        // print_r($setting);die();
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
