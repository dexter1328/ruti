<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorSuccess;
use App\Mail\VendorVerificationMail;
use App\Traits\Permission;
use App\Membership;
use App\Vendor;
use App\Country;
use App\State;
use App\City;
use App\VendorRoles;
use App\VendorPaidModule;
use App\Sales;
use Auth;
use DB;
use Schema;

class VendorController extends Controller
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
		// $vendors = Vendor::vendor()->get();
		return view('admin/vendors/index');
	}

	public function view(request $request)
    {
    	$columns = array(
			0 => 'name',
			1 => 'pincode',
			2 => 'mobile_number',
			3 => 'email',
			4 => 'action'
		);
		$totalData = Vendor::vendor()->count();

        $totalFiltered = $totalData;

		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');


		if(empty($request->input('search.value'))){

			$vendors = Vendor::vendor()->select('vendors.name', 'vendors.pincode', 'vendors.mobile_number', 'vendors.email', 'vendors.id','vendors.status')
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

		}else{

			$search = $request->input('search.value');


			$vendors = Vendor::vendor()->select('vendors.name', 'vendors.pincode', 'vendors.mobile_number', 'vendors.email', 'vendors.id','vendors.status');

	        	$vendors = $vendors->where(function($query) use ($search){
				$query->where('vendors.name', 'LIKE',"%{$search}%")
					->orWhere('vendors.pincode', 'LIKE',"%{$search}%")
					->orWhere('vendors.email', 'LIKE',"%{$search}%")
					->orWhere('vendors.mobile_number', 'LIKE',"%{$search}%");
					//->orWhereRaw("GROUP_CONCAT(attribute_values.name) LIKE ". "%{$search}%");
			});
			//$products = $products->orHavingRaw('Find_In_Set("'.$search.'", attribute_value_names) > 0');

			$totalFiltered = $vendors;
			$totalFiltered = $totalFiltered->get()->count();

			$vendors = $vendors->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();
		}

        $data = array();
		if($vendors->isNotEmpty())
		{
			foreach ($vendors as $key => $vendor)
			{
				// @if($admin->status=='active')color:#009933;@else color: #ff0000;@endif
				if($vendor->status == 'active')
				{
					$color = 'color:#009933;';
				}else{
					$color ='color:#ff0000;';
				}
				$cfm_msg = 'Are you sure?';

				$nestedData['name'] = $vendor->name;
				$nestedData['pincode'] = $vendor->pincode;
				$nestedData['mobile_number'] = $vendor->mobile_number;
				$nestedData['email'] = $vendor->email;
				$nestedData['action'] = '<form id="deletefrm_'.$vendor->id.'" action="'.route('vendor.destroy', $vendor->id).'" method="POST" onsubmit="return confirm(\''.$cfm_msg.'\');">
											<input type="hidden" name="_token" value="'.csrf_token().'">
											<input type="hidden" name="_method" value="DELETE">
											<a href="'.route('vendor.edit', $vendor->id).'" data-toggle="tooltip" data-placement="bottom" title="Edit Vendor">
											<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('.$vendor->id.')" data-toggle="tooltip" data-placement="bottom" title="Delete Vendor">
												<i class="icon-trash icons"></i>
											</a>

											<a href="'.url('admin/vendor/add_role', $vendor->id).'" class="edit" data-toggle="tooltip" data-placement="bottom" title="Add Role">
												<i class="icon-plus icons"></i>
											</a>

											<a href="'.url('admin/vendor/paid_modules', $vendor->id).'" class="edit" data-toggle="tooltip" data-placement="bottom" title="Paid Modules">
												<i class="icon-wallet icons"></i>
											</a>

											<a href="javascript:void(0);" onclick="changeStatus('.$vendor->id.')" >
										 		<i class="fa fa-circle status_'.$vendor->id.'" style="'.$color.'" id="active_'.$vendor->id.'" data-toggle="tooltip" data-placement="bottom" title="Change Status" ></i>
											</a>


										</form>';
				$data[] = $nestedData;
			}

		}

		$json_data = array(
			"draw"            => intval($request->input('draw')),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);exit();
    }
	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$memberships = Membership::where('type', 'vendor')->get();
		$countries = Country::all();
		return view('admin/vendors/create',compact('memberships','countries'));
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		$date = date('Y-m-d');
		$request->validate([
			'sales_person_name'=>'required',
			'sales_person_mobile_number'=>'required',
			'phone_number'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'mobile_number' =>'required|regex:/^([0-9\s\-\+\(\)]*)$/',
			'email'=>'required|email|unique:vendors',
			'password' => 'required|min:6',
    		'confirm_password' => 'required|min:6|same:password',
			'name'=>'required',
			'image' => 'mimes:jpeg,png,jpg|max:2048',
			'status' => 'required',
			'business_name' => 'required',
			'tax_id' => 'required'
		],[
        	'email.unique' => 'The email has already been taken by you or some other vendor.'
        ]);

		$email = $request->input('email');
		$password = $request->input('password');

		$sales = Sales::updateOrCreate(
			['mobile' => $request->sales_person_mobile_number],
			['name' => $request->sales_person_name]
		);

		$data = array(
			'sales_id' => $sales->id,
			'registered_date'=>$date,
			'expired_date'=> date("Y-m-d", strtotime($request->input('expired_date'))),
			'address' => $request->input('address'),
			'country' => $request->input('country'),
			'state' => $request->input('state'),
			'city' => $request->input('city'),
			'pincode' => $request->input('pincode'),
			'name' => $request->input('name'),
			'phone_number'=> $request->input('phone_number'),
			'mobile_number' => $request->input('mobile_number'),
			'email' => $request->input('email'),
			'password' => bcrypt($request->input('password')),
			'website_link'=> $request->input('website_link'),
			'status'    =>$request->input('status'),
			'admin_commision'    => $request->input('admin_commision'),
			'created_by' => Auth::user()->id,
			'business_name' => $request->input('business_name'),
			'tax_id' => $request->input('tax_id')
		);
		//print_r($data);die();
		if ($files = $request->file('image')){
			$path = 'public/images/vendors';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}

		$vendor = Vendor::create($data);

		foreach (main_vendor_roles() as $key => $value) {
			$vendor_roles = new VendorRoles;
			$vendor_roles->vendor_id = $vendor->id;
			$vendor_roles->role_name = $value;
			$vendor_roles->slug = $key;
			$vendor_roles->status = 'active';
			$vendor_roles->created_by = Auth::user()->id;
			$vendor_roles->updated_by = Auth::user()->id;
			$vendor_roles->save();
		}
		$vendor_name = $request->input('name');
		Mail::to($email)->send(new VendorSuccess($email,$password,$vendor_name));
		return redirect('/admin/vendor')->with('success',"Vendor has been saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$vendor = Vendor::vendor()->find($id);
		if($vendor->status == 'active'){
			Vendor::vendor()->where('id',$id)->update(array('status' => 'deactive'));
			echo json_encode('deactive');
		}else{
			/*if($vendor->verification == 'no'){
				$email = $vendor->email;
				$name = $vendor->name;
				Mail::to($email)->send(new VendorVerificationMail($email,$name));
			}*/
			Vendor::vendor()->where('id',$id)->update(array('status' => 'active'));
			echo json_encode('active');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param App\Vendor $vendor
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(Vendor $vendor)
	{
		$sales = Sales::find($vendor->sales_id);
		$memberships = Membership::where('type', 'vendor')->get();
		$countries = Country::all();
		return view('admin/vendors/edit',compact('memberships','vendor','countries', 'sales'));
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
			'sales_person_name'=>'required',
			'sales_person_mobile_number'=>'required',
			'phone_number'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'mobile_number' =>'required|regex:/^([0-9\s\-\+\(\)]*)$/',
			'name'=>'required',
			'image' => 'mimes:jpeg,png,jpg|max:2048',
			'email'=>'required|unique:vendors,email,' . $id,
			'business_name' => 'required',
			'tax_id' => 'required'
		],[
        	'email.unique' => 'The email has already been taken by you or some other vendor.'
        ]);

		$sales = Sales::updateOrCreate(
			['mobile' => $request->sales_person_mobile_number],
			['name' => $request->sales_person_name]
		);

		$data = array(
			'sales_id' => $sales->id,
			'expired_date'=> date("Y-m-d", strtotime($request->input('expired_date'))),
			'address' => $request->input('address'),
			'country' => $request->input('country'),
			'state' => $request->input('state'),
			'city' => $request->input('city'),
			'pincode' => $request->input('pincode'),
			'name' => $request->input('name'),
			'phone_number'=> $request->input('phone_number'),
			'mobile_number' => $request->input('mobile_number'),
			'email' => $request->input('email'),
			'website_link'=> $request->input('website_link'),
			'status'    =>$request->input('status'),
			'admin_commision'    => $request->input('admin_commision'),
			'updated_by' => Auth::user()->id,
			'business_name' => $request->input('business_name'),
			'tax_id' => $request->input('tax_id')
		);
		if ($files = $request->file('image')){
			$path = 'public/images/vendors';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}

		Vendor::vendor()->where('id',$id)->update($data);

		/*if($request->input('status') == 'active'){
			$vendor_data = Vendor::vendor()->where('id',$id)->first();
			if($vendor_data->verification == 'no'){
				$email = $vendor_data->email;
				$name = $vendor_data->name;
				Mail::to($email)->send(new VendorVerificationMail($email,$name));
				Vendor::vendor()->where('id',$id)->update(array('verification' => 'yes'));
			}
		}*/

		return redirect('/admin/vendor')->with('success',"Vendor has been updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\Vendor $vendor
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Vendor $vendor)
	{
		$vendor->delete();
		return redirect('/admin/vendor')->with('success',"Vendor has been deleted.");
	}

	public function addRole(Request $request, $id)
	{
		$vendor_roles = VendorRoles::where('vendor_id',$id)->get();
		return view('admin.vendors.add_role',compact('id','vendor_roles'));
	}

	public function vendorAddRole(Request $request, $id)
	{
			// print_r($request->all());
			$slug = str_slug($request->role_name);
			$request->validate([
            'role_name'=> [
                'required',
                Rule::unique('vendor_roles')->where(function ($query) use($slug,$id) {
                    return $query->where('slug', $slug)
                    ->where('vendor_id',$id);
                }),
            ],
	        ],[
	            'role_name.required' => 'The Role name is required.',
	            'role_name.unique' => 'The Role name has already been taken.',
	        ]);

	        $vendor_role = new VendorRoles;
	        $vendor_role->vendor_id = $id;
	        $vendor_role->role_name = $request->role_name;
	        $vendor_role->slug = $slug;
	        $vendor_role->status = 'active';
	        $vendor_role->created_by = Auth::user()->id;
	        $vendor_role->updated_by = Auth::user()->id;
	        $vendor_role->save();

	        return redirect('/admin/vendor/add_role/'.$id)->with('success',"Vendor Role has been saved.");
	}

	public function paidModules(Request $request, $id)
	{
		if(empty($request->all())){

			// $paid_modules = VendorPaidModule::where('vendor_id',$id)->where('status','yes')->get()->pluck('status', 'module_name');
			$paid_modules = VendorPaidModule::where('vendor_id',$id)->get();

			return view('admin.vendors.paid_modules',compact('id','paid_modules'));
		}else{

			foreach ($request->except('_token') as $key => $value) {

				$vendor_paid = VendorPaidModule::where('vendor_id',$id)->where('module_name',$key)->exists();
				if($vendor_paid){
					$vendor_paid_module = VendorPaidModule::where('vendor_id',$id)->where('module_name',$key)->first();
				}else{

					$vendor_paid_module = new VendorPaidModule;
				}

				$vendor_paid_module->vendor_id = $id;
				$vendor_paid_module->module_name = $key;
				$vendor_paid_module->status = $value;
				$vendor_paid_module->save();
			}
			return redirect('/admin/vendor')->with('success',"Vendor Module has been saved.");
		}
	}

	public function paidModulesCreate(Request $request, $id)
	{
		if(empty($request->all())){
			//$paid_modules = VendorPaidModule::where('vendor_id',$id)->where('status','no')->get();
			return view('admin.vendors.paid_modules_create',compact('id'/*,'paid_modules'*/));
		}else{
			/*$vendor_module_id =  VendorPaidModule::where('vendor_id',$id)->where('module_name',$request->module_name)->first();

			if(!empty($vendor_module_id)){
				$request->validate([
					'to_date'=>'required',
					'from_date'=>'required',
					'status'=>'required',
					//'module_name'=>'required|unique:vendor_paid_modules,module_name,' . $vendor_module_id->id,
				]);

			}else{*/
				$request->validate([
					'to_date'=>'required',
					'from_date'=>'required',
					'status'=>'required',
					//'module_name'=>'required',
					'module_name'=>[
						'required',
						Rule::unique('vendor_paid_modules')->where(function($query) use ($id) {
							$query->where('vendor_id', $id);
						})
					]
				]);
			//}
			$paid_module_arr = vendor_paid_modules();

			$vendor_paid_module = new VendorPaidModule;
			$vendor_paid_module->vendor_id = $id;
			$vendor_paid_module->module_code = array_search($request->module_name,$paid_module_arr);
			$vendor_paid_module->module_name = $request->module_name;
			$vendor_paid_module->status = $request->status;
			$vendor_paid_module->start_date = $request->to_date;
			$vendor_paid_module->end_date = $request->from_date;
			$vendor_paid_module->save();

			return redirect('/admin/vendor/paid_modules/'.$id)->with('success',"Vendor Module has been saved.");
		}

	}

	public function paidModulesEdit(Request $request, $id)
	{
		$paid_modules = VendorPaidModule::where('id',$id)->first();
		if(empty($request->all())){
			$paid_modules = VendorPaidModule::where('id',$id)->first();
			return view('admin.vendors.paid_modules_edit',compact('id','paid_modules'));
		}else{
			$request->validate([
				'to_date'=>'required',
				'from_date'=>'required',
			]);

			$data = array('status' => $request->status,
				'start_date' => $request->to_date,
				'end_date' => $request->from_date);

			VendorPaidModule::where('id',$id)->update($data);
			return redirect('/admin/vendor/paid_modules/'.$paid_modules->vendor_id)->with('success',"Vendor Module has been updated.");
		}
	}

	public function editRole($id)
	{
		$vendor_edit_role = VendorRoles::where('id',$id)->first();
		// return redirect('/admin/vendor/add_role/'.$id)->with('success',"Vendor Role has been saved.");
		echo json_encode($vendor_edit_role);
	}

	public function updateRole(Request $request)
	{
		$slug = str_slug($request->role_name);
		$vendor_id = $request->vendor_id;
		$role_id = $request->role_id;
		 $request->validate([
            // 'role_name'=>'required',
            //'page'=>'required|unique:customer_pages,slug,customer_id,'.$this->customerID,
            'role_name'=> [
                'required',
                Rule::unique('vendor_roles')->where(function ($query) use($vendor_id, $slug,$role_id) {
                    return $query->where('slug', $slug)
                    ->where('vendor_id', $vendor_id)
                    ->where('id', '<>', $role_id);
                }),
            ],
        ],[
            'role_name.required' => 'The Role Name field is required.',
            'role_name.unique' => 'The Role Name has already been taken.',
        ]);
		VendorRoles::where('id',$role_id)->update(array('role_name'=>$request->role_name,'slug'=>$slug));
		return redirect('/admin/vendor/add_role/'.$vendor_id)->with('success',"Vendor Role has been updated.");
	}

	public function deleteRole($id)
	{
		$vendor_id  = VendorRoles::where('id',$id)->first();
		VendorRoles::where('id',$id)->delete();
		$data = array('role_id'=>NULL);
		Vendor::vendor()->where('role_id',$id)->update($data);
		return redirect('/admin/vendor/add_role/'.$vendor_id->vendor_id)->with('success',"Vendor Role has been deleted.");
	}

	public function otpVendor(Request $request)
	{
		print_r($request->all());die();
	}

	public function importVendor(Request $request)
	{
		$exists_emails = [];
		$this->validate($request, [
			'import_file'  => 'required|mimes:csv,txt'
        ]);

		$file = $request->file('import_file');
		$extension = $file->getClientOriginalExtension();

		if(strtolower($extension) == 'csv'){
	        $fileD = fopen($request->file('import_file'),"r");
	        $column=fgetcsv($fileD);

	        while(!feof($fileD)){
	            $rowData=fgetcsv($fileD);
	            // print_r($rowData);
	            if(!empty($rowData))
	            {
					$name = $rowData[0];
					$email = $rowData[1];
					$password = $rowData[2];
					$phone_number = $rowData[3];
					$mobile_number = $rowData[4];
	             	$address = $rowData[5];
	                $country = $rowData[6];
	                $state = $rowData[7];
	                $city = $rowData[8];
	                $pincode = (int)$rowData[9];
	                $expired_date = $rowData[10];
	                $membership = $rowData[11];
	                $admin_commision = $rowData[12];
	                $website_link = $rowData[13];
	                $status = $rowData[14];
	                $role = $rowData[15];
	                $images = $rowData[16];

	                $email_exists = Vendor::vendor()->where('email',$email)->exists();
					// $barcode_exists = ProductVariants::where('barcode',$barcode)->exists();

					if($email_exists){
						$exists_emails[] = $email;
					}else{

						$country_id = DB::table('countries')->where('name','like','%'.$country.'%')->first();
						if(empty($country_id)){
		                	$countryID = NULL;
		                }else{
		                	$countryID = $country_id->id;
		                }
		                $state_id = DB::table('states')->where('name','like','%'.$state.'%')
		                					->where('country_id',$countryID)
		                					->first();
		                if(empty($state_id)){
		                	$stateID = NULL;
		                }else{
		                	$stateID = $state_id->id;
		                }
		                $city_id = DB::table('cities')->where('name', 'like', '%' . $city . '%')
		                			->where('state_id',$stateID)
		                			->first();
		                if(empty($city_id)){
		                	$cityID = NULL;
		                }else{
		                	$cityID = $city_id->id;
		                }
		                $membership_id = DB::table('memberships')->where(strtolower('name'),strtolower($membership))->first();

		                $roleData = VendorRoles::where(strtolower('role_name'),strtolower($role))
					                ->where('vendor_id',Auth::user()->id)
					               	->first();
						if(empty($roleData)){
							$vendor_role = new VendorRoles;
							$vendor_role->vendor_id = Auth::user()->id;
							$vendor_role->role_name = $role;
							$vendor_role->slug = str_slug($role);
							$vendor_role->status = 'active';
							$vendor_role->save();
							$vendor_role_id = $vendor_role->id;
						}else{
							$vendor_role_id = $roleData->id;
						}

						// echo $vendor_role_id;
						// die();
						$vendor = new Vendor;
						$vendor->name = $name;
						$vendor->email= $email;
						$vendor->parent_id = 0;
						$vendor->password = bcrypt($password);
						$vendor->phone_number = $phone_number;
						$vendor->mobile_number = $mobile_number;
						$vendor->address = $address;
						$vendor->country = $countryID;
						$vendor->state = $stateID;
						$vendor->city = $cityID;
						$vendor->pincode = $pincode;
						$vendor->expired_date = $expired_date;
						$vendor->membership_id = $membership_id->id;
						$vendor->admin_commision = $admin_commision;
						$vendor->website_link = $website_link;
						$vendor->status = $status;
						$vendor->role_id = $vendor_role_id;

						//print_r($vendor->toArray());die();
						if(trim(strtolower($images))!='')
						{
							// $images_arr = explode(',', $images);
							$i = 1;

							// foreach ($images_arr as $key => $value) {
								// $i++;
								$file1 = public_path('images/vendors').'/'.$images;
								$farry1 = explode("/",$file1);
								$filename1 = end($farry1);
								$extesion1 = explode('.', $filename1);
								$extesion1 = end($extesion1);
								$path1 = public_path('images/vendors');
								$image1 = date('YmdHis') . '.'.$extesion1;
								$new_image1 = $path1.'/'.$image1;

								/*$vendor['image'] = $image1;
								copy($images, $new_image1);*/
								if (!@copy($images, $new_image1)) {

								}else{
									$vendor['image'] = $image1;
								}
							// }
						}
						$vendor->save();
					}
	            }
	        }

	       return redirect('/admin/vendor')->with('success-data', array('emails'=>$exists_emails, 'message' => 'Vendor successfully imported.') );
	    }else{
	    	return redirect('/admin/vendor')->with('error-data','The import file must be a file of type: csv.');

	    }
	}

	public function getImportPreview(Request $request)
	{
		// print_r($request->all());die();
		$file = $request->file('file');
		$extension = $file->getClientOriginalExtension();
		$data = [];
		if(strtolower($extension) == 'csv'){
	        $fileD = fopen($request->file('file'),"r");
	        $column = fgetcsv($fileD);
	        $j = 1;
	        while(!feof($fileD)){
	            $rowData = fgetcsv($fileD);

	            if(!empty($rowData))
	            {
	            	$images = $rowData[10];

	            	$data[] = array(
	            		'name' => $rowData[0],
						'email' => $rowData[1],
						'phone_number' => $rowData[3],
						'mobile_number' => $rowData[4],
		             	'address' => $rowData[5],
		                'country' => $rowData[6],
		                'state' => $rowData[7],
		                'city' => $rowData[8],
		                'pincode' => $rowData[9],
		                'expiry_date' => $rowData[10],
		                'membership' => $rowData[11],
		                'admin_commision' => $rowData[12],
		                'website_link' => $rowData[13],
		                'status' => $rowData[14],
		                'role' => $rowData[15],
		                'image' => $rowData[16]
	            	);

				}
			}
			echo json_encode($data);
		}
	}

	public function exportVendor()
	{
		$filename = "vendors.csv";
		$fp = fopen('php://output', 'w');

		$header = array('Name', 'Email', 'Phone Number', 'Mobile Number', 'Address', 'City', 'State', 'Country', 'Zip Code', 'Store', 'Role', 'Image');

		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		fputcsv($fp, $header);

		/*if(Auth::user()->parent_id == 0){
        	$vendorID = Auth::user()->id;
        }else{
        	$vendorID = Auth::user()->parent_id;
        }*/

		$vendors = Vendor::vendor()->select(
				'vendors.*',
				'countries.name as country_name',
				'states.name as state_name',
				'cities.name as city_name',
				'vendor_stores.name as store_name',
				'vendor_roles.role_name'
			)
			->leftjoin('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
			->leftjoin('stores_vendors', 'stores_vendors.vendor_id', 'vendors.id')
			->leftjoin('vendor_stores', 'vendor_stores.id', 'stores_vendors.store_id')
			->leftjoin('countries', 'countries.id', 'vendors.country')
			->leftjoin('states', 'states.id', 'vendors.state')
			->leftjoin('cities', 'cities.id', 'vendors.city')
			// ->where('vendors.parent_id', $vendorID)
			->groupBy('vendors.id')
			->get();

		$image_url = url('/');

		foreach ($vendors as $key => $vendor) {

			if(!empty($vendor->image)){
				$image = $image_url.'/public/images/vendors/'.$vendor->image;
			}else{
				$image = '';
			}

			$data = array(
				'Name' => $vendor->name,
				'Email' => $vendor->email,
				'Phone Number' => $vendor->phone_number,
				'Mobile Number' => $vendor->mobile_number,
				'Address' => $vendor->address,
				'City' => $vendor->city_name,
				'State' => $vendor->state_name,
				'Country' => $vendor->country_name,
				'Zip Code' => $vendor->pincode,
				'Store' => $vendor->store_name,
				'Role' => $vendor->role_name,
				'Image' => $image
			);

		 	fputcsv($fp, $data);
		}
		exit();
	}
}
