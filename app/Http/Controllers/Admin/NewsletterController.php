<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail;
use App\Newsletter;
use App\User;
use App\Vendor;
use App\UserNewsletter;
use App\Subscribe;
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
		$newsletters = Newsletter::all();

		return view('admin/newsletter/index',compact('newsletters'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin/newsletter/create');
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
		
		return redirect('/admin/newsletters')->with('success',"Newsletter has been saved.");
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
		$users = User::where('status','active')->get();
		$vendors = Vendor::where('status','active')->get();
		$subscribers = Subscribe::where('status','subscribed')->get();
		return view('admin/newsletter/newsletter_send', compact('newsletter','users','vendors','subscribers'));
	}

	/**
	* Show the form for editing the specified resource.
	* @param \App\Newsletter $newsletter
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Newsletter $newsletter)
	{
		return view('/admin/newsletter/edit',compact('newsletter'));
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

		$data=array('subject_name'=>$request->input('subject'),
					'description'=>$request->input('description'),
					'status'=>$request->input('status'),
					'updated_by'=>Auth::user()->id
				);
		Newsletter::where('id',$id)->update($data);

		return redirect('/admin/newsletters')->with('success',"Newsletter has been updated.");
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

		return redirect('/admin/newsletters')->with('success',"Newsletter has been deleted.");
	}

	public function send(Request $request, $id)
	{
		$request->validate([
			'notification_user' =>'required',
		]);

		$newsletter = Newsletter::findOrFail($id);

		if($request->vendor && $request->user && $request->subscribers)
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

			if($request->subscribers){
				foreach ($request->subscribers as $key => $value) {
					$subscribers_user = Subscribe::where('id', $value)->first();
		        	$email = $subscribers_user->email;
		        	Mail::to($email)->send(new NewsletterMail($newsletter));

		    			$user_newsletter = new UserNewsletter;
		    			$user_newsletter->user_id = $subscribers_user->id;
		    			$user_newsletter->newsletter_id = $newsletter->id;
		    			$user_newsletter->is_send = 1;
		    			$user_newsletter->type = 'subscribers';
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
		}else if($request->subscribers){
			foreach ($request->subscribers as $key => $value) {
				$subscribers_user = Subscribe::where('id', $value)->first();
	        	$email = $subscribers_user->email;
	        	Mail::to($email)->send(new NewsletterMail($newsletter));

	    			$user_newsletter = new UserNewsletter;
	    			$user_newsletter->user_id = $subscribers_user->id;
	    			$user_newsletter->newsletter_id = $newsletter->id;
	    			$user_newsletter->is_send = 1;
	    			$user_newsletter->type = 'subscribers';
	    			$user_newsletter->send_by = Auth::user()->id;
	    			$user_newsletter->save();
			}
		}	
		// die();
		return redirect('/admin/newsletters')->with('success',"Newsletter Send");
	}

	public function getUserNewsletters($id)
	{
		$user_newsletters = Newsletter::leftjoin('user_newsletters','user_newsletters.newsletter_id','newsletters.id')
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

		$vendor_newsletters = Newsletter::leftjoin('user_newsletters','user_newsletters.newsletter_id','newsletters.id')
							->join('vendors','vendors.id','user_newsletters.user_id')
							->select('newsletters.subject_name',
									'newsletters.description',
									'user_newsletters.created_at',
									'user_newsletters.is_send',
									'vendors.name')
							->where('newsletters.id',$id)
							->where('user_newsletters.type','vendor')
							->get();
		$newsletter = Newsletter::where('id',$id)->first();

		return view('admin/newsletter/view', compact('user_newsletters','vendor_newsletters','newsletter'));
	}
}
