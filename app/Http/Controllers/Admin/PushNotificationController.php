<?php

namespace App\Http\Controllers\Admin;

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
		$admin_push_notifications = PushNotification::select(
				'push_notifications.*',
				'admins.name as user_name'
			)
			->leftjoin('admins', 'admins.id', 'push_notifications.created_by')
			->where('push_notifications.created_type', 'admin')
			->get();

		$vendor_push_notifications = PushNotification::select(
				'push_notifications.*',
				'vendors.name as user_name'
			)
			->leftjoin('vendors', 'vendors.id', 'push_notifications.created_by')
			->where('push_notifications.created_type', 'vendor')
			->get();

		$push_notifications = $admin_push_notifications->merge($vendor_push_notifications);
		$push_notifications->all();

		return view('admin/push_notifications/index',compact('push_notifications'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin/push_notifications/create');
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
		$push_notifications->description =$request->input('description');
		$push_notifications->created_type = 'admin';
		$push_notifications->created_by =Auth::user()->id;
		$push_notifications->save();

		return redirect('/admin/push_notifications')->with('success',"Push notification has been saved.");
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
		$customers = User::all();
		$vendors = Vendor::all();

		return view('admin/push_notifications/push_notification_send', compact('push_notification','customers','vendors'));
	}

	/**
	* Show the form for editing the specified resource.
	* @param  \App\PushNotification  $push_notification
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(PushNotification  $push_notification)
	{
		return view('admin/push_notifications/edit',compact('push_notification'));
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

		return redirect('/admin/push_notifications')->with('success',"Push notification has been updated.");
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
		
		return redirect('/admin/push_notifications')->with('success',"Push notification has been deleted.");
	}

	public function send(Request $request,$id)
	{
		$request->validate([
            'notification_user'=>'required'
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
              
        return redirect('admin/push_notifications')->with('success', 'Notification has been sent.');
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

		return view('admin/push_notifications/view',compact('push_notifications'));	    
    }

}
