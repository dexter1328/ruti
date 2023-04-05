<?php

namespace App\Http\Controllers\Supplier;

use Auth;
use App\User;
use App\RewardPoint;
use App\CustomerRewardPoint;
use App\Traits\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerRewardPointController extends Controller
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
		$reward_points = CustomerRewardPoint::select(
				'customer_reward_points.*',
				'users.first_name',
				'users.last_name',
			)
			->join('users', 'users.id', 'customer_reward_points.user_id')
			->get();
		return view('supplier.customer_reward_point.index', compact('reward_points'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$users = User::all();
		$reward_types = RewardPoint::all();
		return view('supplier.customer_reward_point.create', compact('users', 'reward_types'));
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
			'user'=>'required',
			'reward_type'=>'required',
		]);

		$reward_type_point = explode('||', $request->reward_type);

		$customer_reward_point = new CustomerRewardPoint;
		$customer_reward_point->user_id = $request->user;
		$customer_reward_point->reward_type = $reward_type_point[0];
		$customer_reward_point->reward_point = $reward_type_point[1];
		$customer_reward_point->information = $request->information;
		$customer_reward_point->created_by = Auth::user()->id;
		$customer_reward_point->save();

		$user = User::findOrFail($request->user);
		$total_reward_points = $user->reward_points + $reward_type_point[1];
		$user->reward_points = $total_reward_points;
		$user->save();

		return redirect('/supplier/customer_reward_points')->with('success',"Customer reward point has been added.");
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
	* @param  \App\CustomerRewardPoint  $customer_reward_point
	* @return \Illuminate\Http\Response
	*/
	public function edit(CustomerRewardPoint $customer_reward_point)
	{
		$users = User::all();
		$reward_types = RewardPoint::all();
		return view('supplier.customer_reward_point.edit', compact('customer_reward_point', 'users', 'reward_types'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\CustomerRewardPoint  $customer_reward_point
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, CustomerRewardPoint $customer_reward_point)
	{
		$request->validate([
			'user'=>'required',
			'reward_type'=>'required',
		]);

		$reward_type_point = explode('||', $request->reward_type);

		$customer_reward_point->user_id = $request->user;
		$customer_reward_point->reward_type = $reward_type_point[0];
		$customer_reward_point->reward_point = $reward_type_point[1];
		$customer_reward_point->information = $request->information;
		$customer_reward_point->created_by = Auth::user()->id;
		$customer_reward_point->save();

		return redirect('/supplier/customer_reward_points')->with('success',"Customer reward point has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\CustomerRewardPoint  $customer_reward_point
	* @return \Illuminate\Http\Response
	*/
	public function destroy(CustomerRewardPoint $customer_reward_point)
	{
		$customer_reward_point->delete();
		return redirect('/supplier/customer_reward_points')->with('success',"Customer reward point has been deleted.");
	}
}
