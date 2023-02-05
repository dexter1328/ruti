<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\SuggestedPlace;
use App\User;
use App\Traits\Permission;
use Auth;
use App\Mail\SuggestedPlaceMail;

class SuggestedPlaceController extends Controller
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
        $suggested_places = SuggestedPlace::join('users','users.id','=','suggested_places.user_id')
                                ->select('suggested_places.id','suggested_places.store','suggested_places.address','suggested_places.email','suggested_places.mobile_no','users.first_name','users.last_name')
                                ->get();
        return view('admin.suggested_place.index',compact('suggested_places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $suggested_place = SuggestedPlace::join('users','users.id','=','suggested_places.user_id')
                        ->select('suggested_places.id','suggested_places.store','suggested_places.email','suggested_places.mobile_no','suggested_places.address','users.first_name','users.last_name')
                        ->where('suggested_places.id', $id)
                        ->first();
        $users = User::where('status','active')->get();
        return view('admin.suggested_place.show',compact('suggested_place','users'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \App\SuggestedPlace  $suggested_place
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suggested_place = SuggestedPlace::join('users','users.id','=','suggested_places.user_id')
                        ->select('suggested_places.id','suggested_places.store','suggested_places.email','suggested_places.mobile_no','suggested_places.address','users.first_name','users.last_name')
                        ->where('suggested_places.id', $id)
                        ->first();
        // print_r($suggested_place);die();
        return view('admin.suggested_place.edit',compact('suggested_place'));
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
            'store' => 'required',
            'address' => 'required',
            'mobile_no'=>'required_without:email',
            'email'=>'required_without:mobile_no'
        ]);

        $data = array('store' => $request->store,
                    'address' => $request->address,
                    'mobile_no' => $request->mobile_no,
                    'email' => $request->email,
                );

        SuggestedPlace::where('id',$id)->update($data);
        return redirect('/admin/suggested-place')->with('success', 'Suggested Place has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\SuggestedPlace  $suggested_place
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuggestedPlace $suggested_place)
    {
        $suggested_place->delete();
        return redirect('/admin/suggested-place')->with('success', 'Suggested Place has been deleted.');
        // return view('admin.suggested_place.index',compact('suggested_places'));
    }

    public function send(Request $request, $id)
    {
        $request->validate([
            'user' =>'required',
        ]);

        $suggested_place = SuggestedPlace::findOrFail($id);

        foreach ($request->user as $key => $value) {
            $user = User::where('id', $value)->first();
            $email = $user->email;
            Mail::to($email)->send(new SuggestedPlaceMail($suggested_place));
        }
            
        return redirect('/admin/suggested-place')->with('success',"Email Send");
    }
}
