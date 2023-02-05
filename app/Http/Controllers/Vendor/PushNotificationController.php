<?php

namespace App\Http\Controllers\Vendor;

use Auth;
use App\User;
use App\Vendor;
use App\UserDevice;
use App\PushNotification;
use App\Traits\Permission;
use App\Traits\AppNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotificationController extends Controller
{
	use Permission;
	use AppNotification;

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
		$user_id = Auth::user()->id;
		$parent_id = Auth::user()->parent_id;
		$push_notifications = PushNotification::where('created_type', 'vendor')
			->where(function ($query) use($user_id, $parent_id) {
                $query->where('created_by', $user_id)
                      ->orWhere('created_by', $parent_id);
            })
			->get();
		return view('vendor/push_notifications/index',compact('push_notifications'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('vendor/push_notifications/create');
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
			'title'=>'required',
			'description'=>'required'
		]);
		$push_notifications = new PushNotification;
		$push_notifications->title = $request->input('title');
		$push_notifications->description = $request->input('description');
		$push_notifications->created_type = 'vendor';
		$push_notifications->created_by = Auth::user()->id;
		$push_notifications->save();

		return redirect('/vendor/push_notifications')->with('success',"Push notification successfully saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$push_notification = PushNotification::findOrFail($id);
		$customers = User::join('orders','orders.customer_id','users.id')
				->select('users.first_name','users.last_name','users.id')
				->where('orders.vendor_id',Auth::user()->id)
				->groupBy('orders.customer_id')
				->get();

		$vendors = Vendor::where('parent_id',Auth::user()->id)->get();

		return view('vendor/push_notifications/push_notification_send', compact('push_notification','customers','vendors'));
	}

	/**
	* Show the form for editing the specified resource.
	* @param  \App\PushNotification  $push_notification
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(PushNotification  $push_notification)
	{
		return view('vendor/push_notifications/edit',compact('push_notification'));
	}

	/**
	* Update the specified resource in storage.
	* @param  \App\PushNotification  $push_notification
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, PushNotification  $push_notification)
	{
		$request->validate([
			'title'=>'required',
			'description'=>'required'
		]);
		$push_notification->title = $request->input('title');
		$push_notification->description =$request->input('description');
		$push_notification->updated_by =Auth::user()->id;
		$push_notification->save();

		return redirect('/vendor/push_notifications')->with('success',"Push notification successfully updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param  \App\PushNotification  $push_notification
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(PushNotification  $push_notification)
	{
		$push_notification->delete();
		
		return redirect('/vendor/push_notifications')->with('success',"Push notification successfully deleted.");
	}

	public function send(Request $request,$id)
	{
		$request->validate([
			'user_type'=>'required',
			'customer'=>'required_if:user_type,both,customer',
			'vendor'=>'required_if:user_type,both,vendor',
		]);

        $push_notification = PushNotification::findOrFail($id);

        $id = null;
        $type = 'general';
        $title = $push_notification->title;
        $description = $push_notification->description;

        $customer_devices = [];
        $vendor_devices = [];
        if($request->user_type == 'both' || $request->user_type == 'customer'){
        	$customer_devices = UserDevice::where('user_type', 'customer')->whereIn('user_id',$request->customer)->get();
        }
  
  		if($request->user_type == 'both' || $request->user_type == 'vendor'){
        	$vendor_devices = UserDevice::where('user_type', 'vendor')->whereIn('user_id',$request->vendor)->get();
        }      
        
        if(!empty($customer_devices)) {
        	$this->sendNotification($title, $description, $customer_devices, $type, $id);
        }

        if(!empty($vendor_devices)) {
        	$this->sendVendorNotification($title, $description, $vendor_devices, $type, $id);
        }
        return redirect('vendor/push_notifications')->with('success', 'Notification has been sent.');
	}

    public function getUserNotification($id)
    {
    	$push_notifications = PushNotification::join('user_notifications','user_notifications.notification_id',
    						'push_notifications.id')
	    					->join('users','users.id','=','user_notifications.user_id')
	    					->select('push_notifications.title',
	    						'push_notifications.description',
	    						'user_notifications.created_at',
	    						'user_notifications.is_read',
	    						'user_notifications.is_send',
	    						'users.first_name',
	    						'users.last_name')
	    					->get();
		return view('vendor/push_notifications/view',compact('push_notifications'));	    
    }
}
