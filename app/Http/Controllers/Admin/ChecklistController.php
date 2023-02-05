<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Checklist;
use App\Traits\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChecklistController extends Controller
{
    use Permission;

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
    public function index($type)
    {
        $checklist  = Checklist::where('type', $type)->get();
        return view('admin/checklist/index',compact('type', 'checklist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        if($type == 'customer') {
            $checklist = customer_checklist();
        }elseif ($type == 'vendor') {
            $checklist = vendor_checklist();
        }
        return view('admin/checklist/create', compact('type', 'checklist'));
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
            'checklist_type' => 'required',
            'title' => 'required',
            'type' => 'required'
        ]);

        $checklist = new Checklist;
        $checklist->code = $request->checklist_type;
        $checklist->title = $request->title;
        $checklist->description = $request->description;
        $checklist->type = $request->type;
        $checklist->save();
        
        return redirect('/admin/checklist/'.$request->type)->with('success',"Item has been saved.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($id)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $checklist = Checklist::findOrFail($id);
        return view('/admin/checklist/edit',compact('checklist'));
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
            'title' => 'required',
            'type' => 'required'
        ]);

        $checklist = Checklist::findOrFail($id);
        $checklist->title = $request->title;
        $checklist->description = $request->description;
        $checklist->type = $request->type;
        $checklist->save();
        
        return redirect('/admin/checklist/'.$request->type)->with('success',"Item has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checklist = Checklist::findOrFail($id);
        $checklist->delete();
        return redirect('/admin/checklist/'.$request->type)->with('success',"Item has been deleted.");
    }

    public function changeStatus($id)
    {
        $checklist = Checklist::findOrFail($id);
        if($checklist->status == 'active'){
            $status = 'inactive';
        }else{
            $status = 'active';
        }
        Checklist::where('id',$id)->update(array('status' => $status));
        return response()->json($status);
    }
}
