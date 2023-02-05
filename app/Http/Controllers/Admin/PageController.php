<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\Page;
use App\Menu;
use Auth;
use Illuminate\Support\Str;

class PageController extends Controller
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
		$pages = Page::all();
		return view('admin/page/index',compact('pages'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$menus = Menu::all();
		return view('admin/page/create',compact('menus'));
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
			'title'=>'required|unique:pages',
			'content'=>'required',
			'image' => 'required|mimes:jpeg,png,jpg|max:2048',
			'status'=>'required'
		]);
		$slug = Str::slug($request->input('title'), '-');
		$page = new Page;
		$page->title = $request->input('title');
		$page->slug = $slug;
		$page->content = $request->input('content');
		$page->status = $request->input('status');
		$page->created_by = Auth::user()->id;

		if ($files = $request->file('image')){
			$path = 'public/images/page';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);   
			$page->image = $profileImage;
		}
		$page->save();
		return redirect('/admin/pages')->with('success',"Page has been saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$page = Page::find($id);
		if($page->status == 'active'){
			Page::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			Page::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param \App\Page $page
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Page $page)
	{
		$menus = Menu::all();
		return view('admin/page/edit',compact('page','menus'));
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
			'title'=>'required|unique:pages,title,' . $id,
			'content'=>'required',
			'status'=>'required',
			'image' => 'mimes:jpeg,png,jpg|max:2048'
		]);
		$slug = Str::slug($request->input('title'), '-');
		$data = array('title'=>$request->input('title'),
					'slug'=>$slug,
					'content'=>$request->input('content'),
					'status'=>$request->input('status'),
					'updated_by'=>Auth::user()->id
				);
		if ($files = $request->file('image')){
			$path = 'public/images/page';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);   
			$data['image'] = $profileImage;
		}
		Page::where('id',$id)->update($data);
		return redirect('/admin/pages')->with('success',"Page has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param \App\Page $page
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Page $page)
	{
		$page->delete();
		return redirect('/admin/pages')->with('success',"Page has been deleted.");
	}
}
