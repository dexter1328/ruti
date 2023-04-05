<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Permission;
use App\Traits\AppNotification;
use App\Helpers\LogActivity as Helper;
use App\Vendor;
use App\VendorStore;
use App\Country;
use App\State;
use App\City;
use App\VendorStoreHours;
use App\User;
use App\UserDevice;
use Auth;
use DB;
use Schema;

class SupplierStoreController extends Controller
{
	use Permission;
	use AppNotification;
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
		$store_ids = getSupplierStore();


		$vendor_stores = VendorStore::join('vendors','vendors.id','=','vendor_stores.vendor_id')
								->select('vendor_stores.branch_admin','vendors.name','vendor_stores.id','vendor_stores.name','vendor_stores.phone_number','vendor_stores.status','vendor_stores.email');
		if(Auth::user()->parent_id == 0){
			$vendor_stores =$vendor_stores->where('vendor_stores.vendor_id', Auth::user()->id);
		}else{
			$vendor_stores =$vendor_stores->whereIn('vendor_stores.id',[$store_ids]);
		}

		$vendor_stores =$vendor_stores->orderBy('vendor_stores.id','desc')->get();

		return view('supplier/supplier_store/index',compact('vendor_stores'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$countries = Country::all();
		$states = State::all();
		$cities = City::all();
		return view('supplier/supplier_store/create',compact('countries','states','cities'));
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
			'name'=>'required',
			'address'=>'required',
			'country'=>'required',
			'state'=>'required',
			'city'=>'required',
			'pincode'=>'required',
			'phone_number'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'mobile_number' =>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'email'=>'required|email|unique:vendor_stores',
			'status'=>'required',
			'current_status'=>'required',
			'pickup_time_limit' => 'required',
			'manager_name' => 'required',
			'no_of_staff' => 'required',
			'lat' => 'required',
			'long' => 'required'
		], [
			'pincode.required' => 'The zip code field is required.'
		]);

		$vendor_store = new VendorStore;
		$vendor_store->vendor_id = Auth::user()->id;
		$vendor_store->name = $request->input('name');
		$vendor_store->address1 = $request->input('address');
		$vendor_store->country = $request->input('country');
		$vendor_store->state = $request->input('state');
		$vendor_store->city = $request->input('city');
		$vendor_store->lat = $request->input('lat');
		$vendor_store->long = $request->input('long');
		$vendor_store->pincode = $request->input('pincode');
		$vendor_store->branch_admin = $request->input('branch_admin');
		$vendor_store->phone_number    = $request->input('phone_number');
		$vendor_store->mobile_number = $request->input('mobile_number');
		$vendor_store->email = $request->input('email');
		$vendor_store->website_link = $request->input('website_link');
		$vendor_store->status    = $request->input('status');
		$vendor_store->open_status    = $request->input('current_status');
		$vendor_store->created_by = Auth::user()->id;
		$vendor_store->pickup_time_limit = $request->input('pickup_time_limit');
		$vendor_store->manager_name    = $request->input('manager_name');
		$vendor_store->no_of_staff    = $request->input('no_of_staff');
		$vendor_store->setup_fee_required = 'no';
        $vendor_store->seller_type = SUPPLIER;

		if ($files = $request->file('image')){
			$path = 'public/images/stores';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$vendor_store->image = $profileImage;
		}

		$vendor_store->save();

		$this->__completeVendorChecklist(Auth::user()->id, 'add_store');

		$sunday_data = array(
			'store_id' => $vendor_store->id,
			'week_day' => 'sunday',
			'daystart_time' => ($request->sun_status =='open' ? $request->sunday_open_time : NULL),
			'dayend_time'=> ($request->sun_status =='open' ? $request->sunday_close_time : NULL)
		);

		VendorStoreHours::insert($sunday_data);

		$monday_data = array(
			'store_id' => $vendor_store->id,
			'week_day' => 'monday',
			'daystart_time' => ($request->mon_status =='open' ? $request->monday_open_time : NULL),
			'dayend_time'=> ($request->mon_status =='open' ? $request->monday_close_time : NULL)
		);

		VendorStoreHours::insert($monday_data);

		$tuesday_data = array(
			'store_id' => $vendor_store->id,
			'week_day' => 'tuesday',
			'daystart_time' => ($request->tue_status =='open' ? $request->tuesday_open_time : NULL),
			'dayend_time'=> ($request->tue_status =='open' ? $request->tuesday_close_time : NULL)
		);

		VendorStoreHours::insert($tuesday_data);

		$wednesday_data = array(
			'store_id' => $vendor_store->id,
			'week_day' => 'wednesday',
			'daystart_time' => ($request->wed_status =='open' ? $request->wednesday_open_time : NULL),
			'dayend_time'=> ($request->wed_status =='open' ? $request->wednesday_close_time : NULL)
		);

		VendorStoreHours::insert($wednesday_data);

		$thursday_data = array(
			'store_id' => $vendor_store->id,
			'week_day' => 'thursday',
			'daystart_time' => ($request->thu_status =='open' ? $request->thursday_open_time : NULL),
			'dayend_time'=> ($request->thu_status =='open' ? $request->thursday_close_time : NULL)
		);

		VendorStoreHours::insert($thursday_data);

		$friday_data = array(
			'store_id' => $vendor_store->id,
			'week_day' => 'friday',
			'daystart_time' => ($request->fri_status =='open' ? $request->friday_open_time : NULL),
			'dayend_time'=> ($request->fri_status =='open' ? $request->friday_close_time : NULL)
		);

		VendorStoreHours::insert($friday_data);

		$saturday_data = array(
			'store_id' => $vendor_store->id,
			'week_day' => 'saturday',
			'daystart_time' => ($request->sat_status =='open' ? $request->saturday_open_time : NULL),
			'dayend_time'=> ($request->sat_status =='open' ? $request->saturday_close_time : NULL)
		);

		VendorStoreHours::insert($saturday_data);

		$this->__completeVendorChecklist(Auth::user()->id, 'store_hours');
		$this->__newStoreCustomerNotification($vendor_store->id, $vendor_store->name, $vendor_store->lat, $vendor_store->long);

		return redirect('/supplier/stores')->with('success',"Store successfully saved.");
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		$vendor_store = VendorStore::find($id);
		if($vendor_store->status == 'enable'){
			VendorStore::where('id',$id)->update(array('status' => 'disable'));
			echo json_encode('disable');
		}else{
			VendorStore::where('id',$id)->update(array('status' => 'enable'));
			echo json_encode('enable');
		}
	}

	/**
	* Show the form for editing the specified resource.
	* @param App\VendorStore $vendor_store
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
		$vendor_store = VendorStore::findOrFail($id);
		$monday  = VendorStoreHours::where('week_day','monday')->where('store_id',$id)->first();
		$tuesday  = VendorStoreHours::where('week_day','tuesday')->where('store_id',$id)->first();
		$wednesday  = VendorStoreHours::where('week_day','wednesday')->where('store_id',$id)->first();
		$thursday  = VendorStoreHours::where('week_day','thursday')->where('store_id',$id)->first();
		$friday  = VendorStoreHours::where('week_day','friday')->where('store_id',$id)->first();
		$saturday  = VendorStoreHours::where('week_day','saturday')->where('store_id',$id)->first();
		$sunday  = VendorStoreHours::select('daystart_time','dayend_time')->where('week_day','sunday')->where('store_id',$id)->first();
		$day  = VendorStoreHours::select('week_day')->where('store_id',$id)->get()->toArray();

		$countries = Country::all();
		return view('supplier/supplier_store/edit',compact('vendor_store','countries','monday','tuesday','wednesday','thursday','friday','saturday','sunday','day'));
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

		// print_r($request->all());die();
		$request->validate([
			'name'=>'required',
			'address'=>'required',
			'country'=>'required',
			'state'=>'required',
			'city'=>'required',
			'pincode'=>'required',
			'phone_number'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'mobile_number' =>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
			'email'=>'required',
			'status'=>'required',
			'current_status'=>'required',
			'pickup_time_limit' => 'required',
			'manager_name' => 'required',
			'no_of_staff' => 'required',
			'lat' => 'required',
			'long' => 'required'
		], [
			'pincode.required' => 'The zip code field is required.'
		]);

		$data = array('vendor_id' => Auth::user()->id,
					'name' => $request->input('name'),
					'address1' => $request->input('address'),
					'country' => $request->input('country'),
					'state' => $request->input('state'),
					'city' => $request->input('city'),
					'lat' => $request->input('lat'),
					'long' => $request->input('long'),
					'pincode' => $request->input('pincode'),
					'branch_admin' => $request->input('branch_admin'),
					'phone_number'    => $request->input('phone_number'),
					'mobile_number' => $request->input('mobile_number'),
					'email' => $request->input('email'),
					'website_link' => $request->input('website_link'),
					'status'    => $request->input('status'),
					'open_status'    => $request->input('current_status'),
					'updated_by' => Auth::user()->id,
					'pickup_time_limit' => $request->input('pickup_time_limit'),
					'manager_name'    => $request->input('manager_name'),
					'no_of_staff'    => $request->input('no_of_staff')
				);
		if ($files = $request->file('image')){
			$path = 'public/images/stores';
			$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
			$files->move($path, $profileImage);
			$data['image'] = $profileImage;
		}
		VendorStore::where('id',$id)->update($data);

		$store_vendor = VendorStoreHours::where('store_id',$id)->get()->toArray();

		if(!empty($store_vendor))
		{
			$sunday_data = array(
				'week_day' => 'sunday',
				'daystart_time' => ($request->sun_status =='open' ? $request->sunday_open_time : NULL),
				'dayend_time'=> ($request->sun_status =='open' ? $request->sunday_close_time : NULL)
			);

			VendorStoreHours::where('store_id',$id)->where('week_day','sunday')->update($sunday_data);

			$monday_data = array(
				'week_day' => 'monday',
				'daystart_time' => ($request->mon_status =='open' ? $request->monday_open_time : NULL),
				'dayend_time'=> ($request->mon_status =='open' ? $request->monday_close_time : NULL)
			);

			VendorStoreHours::where('store_id',$id)->where('week_day','monday')->update($monday_data);

			$tuesday_data = array(
				'week_day' => 'tuesday',
				'daystart_time' => ($request->tue_status =='open' ? $request->tuesday_open_time : NULL),
				'dayend_time'=> ($request->tue_status =='open' ? $request->tuesday_close_time : NULL)
			);

			VendorStoreHours::where('store_id',$id)->where('week_day','tuesday')->update($tuesday_data);

			$wednesday_data = array(
				'week_day' => 'wednesday',
				'daystart_time' => ($request->wed_status =='open' ? $request->wednesday_open_time : NULL),
				'dayend_time'=> ($request->wed_status =='open' ? $request->wednesday_close_time : NULL)
			);

			VendorStoreHours::where('store_id',$id)->where('week_day','wednesday')->update($wednesday_data);

			$thursday_data = array(
				'week_day' => 'thursday',
				'daystart_time' => ($request->thu_status =='open' ? $request->thursday_open_time : NULL),
				'dayend_time'=> ($request->thu_status =='open' ? $request->thursday_close_time : NULL)
			);

			VendorStoreHours::where('store_id',$id)->where('week_day','thursday')->update($thursday_data);

			$friday_data = array(
				'week_day' => 'friday',
				'daystart_time' => ($request->fri_status =='open' ? $request->friday_open_time : NULL),
				'dayend_time'=> ($request->fri_status =='open' ? $request->friday_close_time : NULL)
			);

			VendorStoreHours::where('store_id',$id)->where('week_day','friday')->update($friday_data);

			$saturday_data = array(
				'week_day' => 'saturday',
				'daystart_time' => ($request->sat_status =='open' ? $request->saturday_open_time : NULL),
				'dayend_time'=> ($request->sat_status =='open' ? $request->saturday_close_time : NULL)
			);

			VendorStoreHours::where('store_id',$id)->where('week_day','saturday')->update($saturday_data);
		}else{
			$sunday_data = array(
				'store_id' => $id,
				'week_day' => 'sunday',
				'daystart_time' => ($request->sun_status =='open' ? $request->sunday_open_time : NULL),
				'dayend_time'=> ($request->sun_status =='open' ? $request->sunday_close_time : NULL)
			);

			VendorStoreHours::insert($sunday_data);

			$monday_data = array(
				'store_id' => $id,
				'week_day' => 'monday',
				'daystart_time' => ($request->mon_status =='open' ? $request->monday_open_time : NULL),
				'dayend_time'=> ($request->mon_status =='open' ? $request->monday_close_time : NULL)
			);

			VendorStoreHours::insert($monday_data);

			$tuesday_data = array(
				'store_id' => $id,
				'week_day' => 'tuesday',
				'daystart_time' => ($request->tue_status =='open' ? $request->tuesday_open_time : NULL),
				'dayend_time'=> ($request->tue_status =='open' ? $request->tuesday_close_time : NULL)
			);

			VendorStoreHours::insert($tuesday_data);

			$wednesday_data = array(
				'store_id' => $id,
				'week_day' => 'wednesday',
				'daystart_time' => ($request->wed_status =='open' ? $request->wednesday_open_time : NULL),
				'dayend_time'=> ($request->wed_status =='open' ? $request->wednesday_close_time : NULL)
			);

			VendorStoreHours::insert($wednesday_data);

			$thursday_data = array(
				'store_id' => $id,
				'week_day' => 'thursday',
				'daystart_time' => ($request->thu_status =='open' ? $request->thursday_open_time : NULL),
				'dayend_time'=> ($request->thu_status =='open' ? $request->thursday_close_time : NULL)
			);

			VendorStoreHours::insert($thursday_data);

			$friday_data = array(
				'store_id' => $id,
				'week_day' => 'friday',
				'daystart_time' => ($request->fri_status =='open' ? $request->friday_open_time : NULL),
				'dayend_time'=> ($request->fri_status =='open' ? $request->friday_close_time : NULL)
			);

			VendorStoreHours::insert($friday_data);

			$saturday_data = array(
				'store_id' => $id,
				'week_day' => 'saturday',
				'daystart_time' => ($request->sat_status =='open' ? $request->saturday_open_time : NULL),
				'dayend_time'=> ($request->sat_status =='open' ? $request->saturday_close_time : NULL)
			);

			VendorStoreHours::insert($saturday_data);
		}

		$this->__completeVendorChecklist(Auth::user()->id, 'store_hours');

		return redirect('/supplier/stores')->with('success',"Store successfully updated.");
	}

	/**
	* Remove the specified resource from storage.
	* @param App\VendorStore $vendor_store
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
		$vendor_store = VendorStore::findOrFail($id);
		$vendor_store->delete();
		return redirect('/supplier/stores')->with('success',"Store successfully deleted.");
	}

	public function importStore(Request $request)
	{
		$exists_emails = [];
		$this->validate($request, [
			'import_file'  => 'required|mimes:csv,txt'
        ]);

		$file = $request->file('import_file');
		$extension = $file->getClientOriginalExtension();

		if(strtolower($extension) == 'csv') {

	        $fileD = fopen($request->file('import_file'),"r");
	        $column = fgetcsv($fileD);
	        $parentID = (Auth::user()->parent_id == 0) ? Auth::user()->id : Auth::user()->parent_id;

	        while(!feof($fileD)) {

	            $rowData=fgetcsv($fileD);
	            if(!empty($rowData)) {

					$name = $rowData[0];
					$email = $rowData[1];
					$phone_number = $rowData[2];
					$mobile_number = $rowData[3];
					$manager_name = $rowData[4];
					$no_of_staff = $rowData[5];
					$branch_admin = $rowData[6];
					$image = $rowData[7];
	             	$address = $rowData[8];
	                $country = $rowData[9];
	                $state = $rowData[10];
	                $city = $rowData[11];
	                $lat = $rowData[12];
	                $long = $rowData[13];
	                $pincode = (int)$rowData[14];
	                $website_link = $rowData[15];
	                $status = 'enable';
	                $current_status = $rowData[16];
	                $pickup_time_limit = $rowData[17];
	                $sunday = explode('-',$rowData[18]);
	                $monday = explode('-',$rowData[19]);
	                $tuesday = explode('-',$rowData[20]);
	                $wednesday = explode('-',$rowData[21]);
	                $thursday = explode('-',$rowData[22]);
	                $friday = explode('-',$rowData[23]);
	                $saturday = explode('-',$rowData[24]);

	                $email_exists = VendorStore::where('email', $email)->exists();

					if($email_exists) {
						$exists_emails[] = $email;
					} else {

						$country = DB::table('countries')->where('name','like','%'.$country.'%')->first();
						$countryID = (empty($country)) ? NULL : $country->id;

						$state = DB::table('states')->where('name','like','%'.$state.'%')->where('country_id',$countryID)->first();
						$stateID = (empty($state)) ? NULL : $state->id;

						$city = DB::table('cities')->where('name', 'like', '%' . $city . '%')->where('state_id',$stateID)->first();
						$cityID = (empty($city)) ? NULL : $city->id;

						$vendor_store = new VendorStore;
						$vendor_store->vendor_id = $parentID;
						$vendor_store->name = $name;
						$vendor_store->email= $email;
						$vendor_store->phone_number = $phone_number;
						$vendor_store->mobile_number = $mobile_number;
						$vendor_store->manager_name = $manager_name;
						$vendor_store->no_of_staff = $no_of_staff;
						$vendor_store->branch_admin = $branch_admin;
						$vendor_store->address1 = $address;
						$vendor_store->country = $countryID;
						$vendor_store->state = $stateID;
						$vendor_store->city = $cityID;
						$vendor_store->lat = $lat;
						$vendor_store->long = $long;
						$vendor_store->pincode = $pincode;
						$vendor_store->website_link = $website_link;
						$vendor_store->status = $status;
						$vendor_store->open_status = $current_status;
						$vendor_store->pickup_time_limit = $pickup_time_limit;

						if(trim($image)!='') {

							if (!filter_var($image, FILTER_VALIDATE_URL) === false) {

								$ext = pathinfo($image, PATHINFO_EXTENSION);
								$path = public_path('images/stores');
								$image_name = date('YmdHis') . '.' . $ext;
								$new_image = $path . '/' . $image_name;

								if (!@copy($image, $new_image)) {

								}else{
									$vendor_store['image'] = $image_name;
								}
							}
						}
						$vendor_store->save();

						$this->__newStoreCustomerNotification($vendor_store->id, $vendor_store->name, $vendor_store->lat, $vendor_store->long);

						// store hours
						$sunday_data = array(
							'store_id' => $vendor_store->id,
							'week_day' => 'sunday',
							'daystart_time' => ($rowData[18] == 'closed' ? NULL : $sunday[0]),
							'dayend_time'=> ($rowData[18] == 'closed' ? NULL : $sunday[1])
						);

						$monday_data = array(
							'store_id' => $vendor_store->id,
							'week_day' => 'monday',
							'daystart_time' => ($rowData[19] == 'closed' ? NULL : $monday[0]),
							'dayend_time'=> ($rowData[19] == 'closed' ? NULL : $monday[1])
						);

						$tuesday_data = array(
							'store_id' => $vendor_store->id,
							'week_day' => 'tuesday',
							'daystart_time' => ($rowData[20] == 'closed' ? NULL : $tuesday[0]),
							'dayend_time'=> ($rowData[20] == 'closed' ? NULL : $tuesday[1])
						);

						$wednesday_data = array(
							'store_id' => $vendor_store->id,
							'week_day' => 'wednesday',
							'daystart_time' => ($rowData[21] == 'closed' ? NULL : $wednesday[0]),
							'dayend_time'=> ($rowData[21] == 'closed' ? NULL : $wednesday[1])
						);

						$thursday_data = array(
							'store_id' => $vendor_store->id,
							'week_day' => 'thursday',
							'daystart_time' => ($rowData[22] == 'closed' ? NULL : $thursday[0]),
							'dayend_time'=> ($rowData[22] == 'closed' ? NULL : $thursday[1])
						);

						$friday_data = array(
							'store_id' => $vendor_store->id,
							'week_day' => 'friday',
							'daystart_time' => ($rowData[23] == 'closed' ? NULL : $friday[0]),
							'dayend_time'=> ($rowData[23] == 'closed' ? NULL : $friday[1])
						);

						$saturday_data = array(
							'store_id' => $vendor_store->id,
							'week_day' => 'saturday',
							'daystart_time' => ($rowData[24] == 'closed' ? NULL : $saturday[0]),
							'dayend_time'=> ($rowData[24] == 'closed' ? NULL : $saturday[1])
						);

						$store_hours_data = array($sunday_data, $monday_data, $tuesday_data, $wednesday_data, $thursday_data, $friday_data, $saturday_data);

						VendorStoreHours::insert($store_hours_data);
					}
	            }
	        }
	        Helper::addToLog('Import Store',Auth::user()->id);
	       	return redirect('/supplier/stores')->with('success-data', array('emails' => $exists_emails, 'message' => 'Store successfully imported.') );
	    }else{
	    	return redirect('/supplier/stores')->with('error-data','The import file must be a file of type: csv.');

	    }
	}

	public function exportStore()
	{
		$filename = "stores.csv";
		$fp = fopen('php://output', 'w');

		$header = array(
			'Name',
			'Email',
			'Phone No',
			'Mobile No',
			'Manager Name',
			'Branch Admin',
			'No Of Staff',
			'Image',
			'Address',
			'Country',
			'State',
			'City',
			'Lat',
			'Long',
			'Zip Code',
			'Website Link',
			'Status',
			'Current Status',
			'Pickup Time Limit',
		);

		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		fputcsv($fp, $header);

		$store_ids = getSupplierStore();
		$vendors_store_data = VendorStore::select(
				'vendor_stores.*',
				'countries.name as country_name',
				'states.name as state_name',
				'cities.name as city_name'
			)
			->leftjoin('countries','countries.id','vendor_stores.country')
			->leftjoin('states','states.id','vendor_stores.state')
			->leftjoin('cities','cities.id','vendor_stores.city')
			->whereIn('vendor_stores.id', $store_ids)
			->get();

		$image_url = url('/');
		foreach ($vendors_store_data as $key => $value) {

			if(!empty($value->image)){
				$image = $image_url.'/public/images/stores/'.$value->image;
			}else{
				$image = '';
			}

			$data = array(
				'Name' => $value->name,
				'Email' => $value->email,
				'Phone Number' => $value->phone_number,
				'Mobile Number' => $value->mobile_number,
				'Manager Name' => $value->manager_name,
				'Branch Admin' => $value->branch_admin,
				'No of staff' => $value->no_of_staff,
				'Image' => $image,
				'Address' => $value->address1,
				'Country' => $value->country_name,
				'State' => $value->state_name,
				'City' => $value->city_name,
				'Lat' => $value->lat,
				'Long' =>$value->long,
				'Zip Code' => $value->pincode,
				'Website Link' => $value->website_link,
				'Status' => $value->status,
				'Current Status' => $value->open_status,
				'Pickup Time Limit' => $value->pickup_time_limit
			);

		 	fputcsv($fp, $data);
		}
		Helper::addToLog('Export Store',Auth::user()->id);
		exit();
	}
}
