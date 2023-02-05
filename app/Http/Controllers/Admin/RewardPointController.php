<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RewardPoint;
use Auth;
use App\Traits\Permission;

class RewardPointController extends Controller
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
		$reward_points = RewardPoint::all();
		return view('admin.reward_points.index',compact('reward_points'));
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin/reward_points/create');
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
			'reward_type'=>'required|unique:reward_points',
			'reward_points'=>'required',
			'exchange_rate'=>'required',
			'status'=>'required'
		]);
		$reward_point = new RewardPoint;
		$reward_point->reward_type = $request->input('reward_type');
		$reward_point->reward_points = $request->input('reward_points');
		$reward_point->reward_point_exchange_rate = $request->input('exchange_rate');
		$reward_point->status = $request->input('status');
		// $reward_point->end_date = date("Y-m-d", strtotime($request->input('end_date')));
		$reward_point->created_by = Auth::user()->id;
		$reward_point->save();
		return redirect('/admin/reward_points')->with('success', 'Reward Point has been saved.');
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$reward_point = RewardPoint::find($id);
		if($reward_point->status == 'active'){
			RewardPoint::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			RewardPoint::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param \App\RewardPoint $reward_point
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(RewardPoint $reward_point)
	{
		return view('admin/reward_points/edit',compact('reward_point'));
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
			'reward_type'=>'required|unique:reward_points,reward_type,'. $id,
			'reward_points'=>'required',
			'exchange_rate'=>'required',
			'status'=>'required'
		]);

		$data = array('reward_type' => $request->input('reward_type'),
					'reward_points' => $request->input('reward_points'),
					'status' => $request->input('status'),
					'reward_point_exchange_rate' => $request->input('exchange_rate'),
					// 'end_date' => date("Y-m-d", strtotime($request->input('end_date'))),
					'updated_by' => Auth::user()->id
				);
		RewardPoint::where('id',$id)->update($data);
		return redirect('/admin/reward_points')->with('success', 'Reward Point has been updated.');
	}

	/**
	* Remove the specified resource from storage.
	* @param \App\RewardPoint $reward_point
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(RewardPoint $reward_point)
	{
		$reward_point->delete();
		return redirect('/admin/reward_points')->with('success', 'Reward Point has been deleted.');
	}
}
