<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\OrderReason;
use Auth;

class OrderReasonController extends Controller
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

    public function index()
    {
        $order_reasons = OrderReason::all();
        return view('admin/order_reason/index',compact('order_reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/order_reason/create');
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
            'type'=>'required',
            'reason'=>'required'
        ]);
        
        $order_reason = new OrderReason;
        $order_reason->type = $request->input('type');
        $order_reason->reason = $request->input('reason');
        $order_reason->save();

        return redirect('/admin/order_reason')->with('success',"Order reason has been saved.");
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
       $order_reason = OrderReason::findOrFail($id);
       return view('admin/order_reason/edit',compact('order_reason'));
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
        $request->validate([
            'type'=>'required',
            'reason'=>'required'
        ]);
        
        $order_reason =  OrderReason::findOrFail($id);
        $order_reason->type = $request->input('type');
        $order_reason->reason = $request->input('reason');
        $order_reason->save();

        return redirect('/admin/order_reason')->with('success',"Order reason has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrderReason::where('id',$id)->delete();
        return redirect('/admin/order_reason')->with('success',"Order reason has been deleted.");
    }
}
