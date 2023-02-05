<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\Traits\AppNotification;
use Auth;
use App\SupportTicket;
use App\UserDevice;
use App\User;

class SupportTicketController extends Controller
{
	use Permission,AppNotification;
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
		$support_tickets = SupportTicket::orderBy('updated_at', 'desc')->get();
        return view('admin/support_ticket/index',compact('support_tickets'));
	}
	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$users = User::all();
		return view('admin/support_ticket/create',compact('users'));
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
			'customer_id' => 'required',
			'subject' => 'required',
			'message' => 'required',
		]);

		$ticket_no =  rand(100000, 999999);

		$support_ticket = new SupportTicket;
		$support_ticket->customer_id = $request->input('customer_id');
		$support_ticket->subject = $request->input('subject');
		$support_ticket->message = $request->input('message');
		$support_ticket->ticket_no= $ticket_no;
		$support_ticket->save();

		return redirect('/admin/support_ticket')->with('success',"Ticket has been generated.");  
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$support_ticket = SupportTicket::findOrFail($id);
		if($support_ticket->user_type == 'customer'){

			$user = User::select(
					'users.first_name as name',
					'memberships.name as membership_name'
				)
				->join('user_subscriptions', 'user_subscriptions.user_id', 'users.id')
				->join('memberships', 'memberships.id', 'user_subscriptions.membership_id')
				->where('users.id', $support_ticket->user_id)
				->first();
		}else{

			$user = Vendor::select(
					'vendors.name'
				)
				->where('users.id', $support_ticket->user_id)
				->first();
		}

    	return view('admin/support_ticket/chat',compact('support_ticket', 'user'));
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

	 public function support_ticket_notification(Request $request)
    {
        $ticket = SupportTicket::where('ticket_no',$request->ticket_no)->first();

        // send notification to user
        $id = $request->ticket_no;
        $type = 'support_ticket';
        $title = 'New message in ticket #'.$request->ticket_no;
        $message = $request->message;
        $devices = UserDevice::where('user_id',$ticket->customer_id)->get();
        $this->sendNotification($title, $message, $devices, $type , $id);
    }
}
