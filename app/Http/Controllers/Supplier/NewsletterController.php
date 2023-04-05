<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail;
use App\Newsletter;
use App\User;
use App\Vendor;
use App\UserNewsletter;
use App\VendorPaidModule;
use Auth;
use App\Traits\Permission;

class NewsletterController extends Controller
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

	public function index()
	{
		$newsletters = Newsletter::all();
		$vendor_paid_module = VendorPaidModule::where('module_name','newsletter')
						->where('vendor_id',Auth::user()->id)
						->first();
		return view('supplier/newsletter/index',compact('newsletters','vendor_paid_module'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('supplier/newsletter/create');
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
			'subject'=>'required',
			'description'=>'required',
			'status'=>'required'
		]);
		$newsletter = new Newsletter;
		$newsletter->subject_name = $request->input('subject');
		$newsletter->description = $request->input('description');
		$newsletter->status = $request->input('status');
		$newsletter->created_by = Auth::user()->id;
		$newsletter->save();

		return redirect('/supplier/newsletters')->with('success',"Newsletter successfully saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$newsletter = Newsletter::findOrFail($id);
		$users = User::join('orders','orders.customer_id','users.id')
				->select('users.first_name','users.last_name','users.id')
				->where('orders.vendor_id',Auth::user()->id)
				->groupBy('orders.customer_id')
				->get();

		$vendors = Vendor::where('parent_id',Auth::user()->id)->get();

		return view('supplier/newsletter/newsletter_send', compact('newsletter','users','vendors'));
	}

	/**
	* Show the form for editing the specified resource.
	* @param \App\Newsletter $newsletter
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Newsletter $newsletter)
	{
		return view('/supplier/newsletter/edit',compact('newsletter'));
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
			'subject'=>'required',
			'description'=>'required',
			'status'=>'required'
		]);

		$data=array('subject_name' => $request->input('subject'),
					'description' => $request->input('description'),
					'status' => $request->input('status'),
					'updated_by' => Auth::user()->id
				);
		Newsletter::where('id',$id)->update($data);

		return redirect('/supplier/newsletters')->with('success',"Newsletter successfully updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param \App\Newsletter $newsletter
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Newsletter $newsletter)
	{
		$newsletter->delete();

		return redirect('/supplier/newsletters')->with('success',"Newsletter successfully deleted.");
	}

	public function send(Request $request, $id)
	{
		$request->validate([
			'notification_user'=>'required',
		]);

		$newsletter = Newsletter::findOrFail($id);

		if($request->vendor && $request->user)
		{
			if($request->user){
				foreach ($request->user as $key => $value) {
					$user = User::where('id', $value)->first();
		        	$email = $user->email;
		        	Mail::to($email)->send(new NewsletterMail($newsletter));

		    			$user_newsletter = new UserNewsletter;
		    			$user_newsletter->user_id = $user->id;
		    			$user_newsletter->newsletter_id = $newsletter->id;
		    			$user_newsletter->is_send = 1;
		    			$user_newsletter->type = 'user';
		    			$user_newsletter->send_by = Auth::user()->id;
		    			$user_newsletter->save();
				}
			}
			if($request->vendor){
				foreach ($request->vendor as $key => $value) {
					$user = Vendor::where('id', $value)->first();
		        	$email = $user->email;
		        	Mail::to($email)->send(new NewsletterMail($newsletter));

		    			$user_newsletter = new UserNewsletter;
		    			$user_newsletter->user_id = $user->id;
		    			$user_newsletter->newsletter_id = $newsletter->id;
		    			$user_newsletter->is_send = 1;
		    			$user_newsletter->type = 'vendor';
		    			$user_newsletter->send_by = Auth::user()->id;
		    			$user_newsletter->save();
				}
			}

		}elseif($request->user){
			foreach ($request->user as $key => $value) {
				$user = User::where('id', $value)->first();
	        	$email = $user->email;
	        	Mail::to($email)->send(new NewsletterMail($newsletter));

	    			$user_newsletter = new UserNewsletter;
	    			$user_newsletter->user_id = $user->id;
	    			$user_newsletter->newsletter_id = $newsletter->id;
	    			$user_newsletter->is_send = 1;
	    			$user_newsletter->type = 'user';
	    			$user_newsletter->send_by = Auth::user()->id;
	    			$user_newsletter->save();
			}

		}else if($request->vendor){

			foreach ($request->vendor as $key => $value) {
				$user = Vendor::where('id', $value)->first();
	        	$email = $user->email;
	        	Mail::to($email)->send(new NewsletterMail($newsletter));


	    			$user_newsletter = new UserNewsletter;
	    			$user_newsletter->user_id = $user->id;
	    			$user_newsletter->newsletter_id = $newsletter->id;
	    			$user_newsletter->is_send = 1;
	    			$user_newsletter->type = 'vendor';
	    			$user_newsletter->send_by = Auth::user()->id;
	    			$user_newsletter->save();
			}
		}


		// die();
		return redirect('/supplier/newsletters')->with('success',"Newsletter Send");
	}

	public function getUserNewsletters($id)
	{
		$newsletter = Newsletter::where('id',$id)->first();

		$user_newsletters = Newsletter::join('user_newsletters','user_newsletters.newsletter_id','newsletters.id')
							->join('users','users.id','user_newsletters.user_id')
							->select('newsletters.subject_name',
									'newsletters.description',
									'user_newsletters.created_at',
									'user_newsletters.is_send',
									'users.first_name',
									'users.last_name')
							->where('newsletters.id',$id)
							->where('user_newsletters.type','user')
							->get();

		$vendor_newsletters = Newsletter::join('user_newsletters','user_newsletters.newsletter_id','newsletters.id')
							->join('vendors','vendors.id','user_newsletters.user_id')
							->select('newsletters.subject_name',
									'newsletters.description',
									'user_newsletters.created_at',
									'user_newsletters.is_send',
									'vendors.name')
							->where('newsletters.id',$id)
							->where('user_newsletters.type','vendor')
							->get();

		return view('supplier/newsletter/view', compact('user_newsletters','vendor_newsletters','newsletter'));
	}
}
