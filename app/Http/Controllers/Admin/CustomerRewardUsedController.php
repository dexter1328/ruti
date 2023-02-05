<?php

namespace App\Http\Controllers\Admin;

use Auth; 
use App\User; 
use App\Orders; 
use App\RewardPoint; 
use App\CustomerRewardUsed; 
use App\Traits\Permission; 
use Illuminate\Http\Request; 
use Illuminate\Validation\Rule; 
use App\Http\Controllers\Controller;

class CustomerRewardUsedController extends Controller
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
		$used_reward_points = CustomerRewardUsed::select(
				'customer_reward_useds.*',
				'users.first_name',
				'users.last_name',
				'orders.order_no'
			)
			->join('users', 'users.id', 'customer_reward_useds.user_id')
			->join('orders', 'orders.id', 'customer_reward_useds.order_id')
			->get();
		return view('admin.customer_used_reward_point.index', compact('used_reward_points'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$orders = Orders::select(
				'orders.*',
				'users.first_name',
				'users.last_name',
			)
			->join('users', 'users.id', 'orders.customer_id')
			->get();
		return view('admin.customer_used_reward_point.create', compact('orders'));
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
			'order'=>'required',
			'reward_points'=> [
				'required',
				Rule::notIn([0])
			],
		]);

		$order = explode('||', $request->order);

		$user = User::where('id', $order[1])->where('reward_points', '<', $request->reward_points)->exists();
		if($user){
			return redirect()->back()->withErrors(['reward_points' => ['The enter reward points is greater than the user balance reward points.']])->withInput(); 
		}
	
		$customer_used_reward_point = new CustomerRewardUsed;
		$customer_used_reward_point->order_id = $order[0];
		$customer_used_reward_point->user_id = $order[1];
		$customer_used_reward_point->reward_point = $request->reward_points;
		$customer_used_reward_point->created_by = Auth::user()->id;
		$customer_used_reward_point->save();

		$user = User::findOrFail($order[1]);
		$total_reward_points = $user->reward_points - (int)$request->reward_points;
		$user->reward_points = $total_reward_points;
		$user->save();

		return redirect('/admin/customer_used_reward_points')->with('success',"Customer used reward point has been added.");
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
