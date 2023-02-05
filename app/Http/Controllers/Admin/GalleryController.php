<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gallery;
use Auth;
use DB;
use App\Traits\Permission;

class GalleryController extends Controller
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
		$galleries = Gallery::all();
		return view('admin/galleries/index',compact('galleries'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		return view('admin/galleries/create');
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
			'status'=>'required',
			'image' => 'required|max:2048',
		]);
		$i=0;
		// $profileImage = [];
		foreach($request->file('image') as $images){
			$i++;
			$path = 'public/images/galleries';
			$profileImage[] = date('YmdHis') . $i."." . $images->getClientOriginalExtension();
			$profileImage1 = date('YmdHis') . $i."." . $images->getClientOriginalExtension();
			$images->move($path, $profileImage1); 
		}
		$gallery = new Gallery;
		$gallery->gallery_title = $request->input('title');
		$gallery->status = $request->input('status');
		$gallery->created_by =Auth::user()->id;
		$gallery->file = implode(",",$profileImage);
		$gallery->save();
		return redirect('/admin/galleries')->with('success',"Gallery has been saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$gallery = Gallery::find($id);
		if($gallery->status == 'active'){
			Gallery::where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			Gallery::where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param App\Gallery $gallery
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Gallery $gallery)
	{
		return view('admin/galleries/edit',compact('gallery'));
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
		// echo 'hello';die();
		$request->validate([
			'title' => 'required',
			'status' => 'required',
			'image' => 'mimes:jpeg,png,jpg|max:2048',
		]);
		$data = array('gallery_title' => $request->input('title'),
					'status' => $request->input('status'),
					'updated_by' => Auth::user()->id
				);
		$i=0;
		if ($request->file('image')){
			foreach($request->file('image') as $images){
				$i++;
				$path = 'public/images/galleries';
				$profileImage[] = date('YmdHis') . $i."." . $images->getClientOriginalExtension();
				$profileImage1 = date('YmdHis') . $i."." . $images->getClientOriginalExtension();
				$images->move($path, $profileImage1); 
			}

			$doc_data= Gallery::where('id',$id)->first();
			$arr = array($doc_data->file,implode(",",$profileImage));
			$data['file'] = implode(",",$arr);
		}
		
		Gallery::where('id',$id)->update($data);
		return redirect('/admin/galleries')->with('success',"Gallery has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param \App\Gallery $gallery
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Gallery $gallery)
	{
		$gallery->delete();
		return redirect('/admin/galleries')->with('success',"Gallery has been deleted.");
	}
	
	public function RemoveImage(Request $request, $id)
	{
		$gallery_data = Gallery::where('id',$request->galleryID)->first();
		$old_gallery = explode(',' ,$gallery_data->file);
		$pos = array_search($id, $old_gallery);
		unset($old_gallery[$pos]);
		Gallery::where('id',$request->galleryID)->update(array('file' =>implode(",",$old_gallery)));
	}
}
