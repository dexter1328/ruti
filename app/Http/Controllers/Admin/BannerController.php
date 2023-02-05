<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banner;
use Auth;
use App\Traits\Permission;

class BannerController extends Controller
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
		$banners = Banner::all();
		return view('admin/banner/index',compact('banners'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin/banner/create');
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
			'position'=>'required',
			'status'=>'required',
			'image'=>'required|mimes:jpeg,png,jpg|max:2048'
		]);
		$banners = new Banner;
		$banners->banner_title = $request->input('title');
		$banners->position = $request->input('position');
		$banners->status = $request->input('status');
		$banners->created_by =Auth::user()->id;

		if ($files = $request->file('image')){
			$destinationPath = 'public/images/banners';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($destinationPath, $profileImage);   
			$banners->image = $profileImage;
		}
		$banners->save();
		return redirect('/admin/banners')->with('success',"Banner has been saved.");
	}

	/**
	* Display the specified resource.
	* 
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$banners = Banner::find($id);
		if($banners->status == 'active'){
			Banner::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			Banner::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param \App\Banner $banner
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Banner $banner)
	{
		return view('/admin/banner/edit',compact('banner'));
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
			'title'=>'required',
			'position'=>'required',
			'status'=>'required',
			'image' => 'mimes:jpeg,png,jpg|max:2048',
		]);

		$data = array('banner_title' =>$request->input('title'),
					'position'=>$request->input('position'),
					'status'=>$request->input('status'),
					'updated_by'=>Auth::user()->id
				);

		if ($files = $request->file('image')){
			$destinationPath = 'public/images/banners';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($destinationPath, $profileImage);   
			$data['image'] = $profileImage;
		}
		Banner::where('id',$id)->update($data);
		return redirect('/admin/banners')->with('success',"Banner has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param \App\Banner $banner
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Banner $banner)
	{
		$banner->delete();
		return redirect('/admin/banners')->with('success',"Banner has been deleted.");
	}
}
