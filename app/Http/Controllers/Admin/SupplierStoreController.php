<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\State;
use App\Vendor;
use App\Country;
use App\VendorStore;
use App\StoresVendor;
use App\ProductVariants;
use App\VendorStoreHours;
use App\Traits\Permission;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\AppNotification;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (!$this->hasPermission(Auth::user())) {
                return redirect('admin/home');
            }
            return $next($request);
        });
    }

    public function index()
    {

        $vendors = Vendor::supplier()->where('status', 'active')->get();
        $vendor_stores = VendorStore::join('vendors', 'vendors.id', '=', 'vendor_stores.vendor_id')
            ->select(
                'vendor_stores.id',
                'vendor_stores.branch_admin',
                'vendor_stores.name',
                'vendor_stores.phone_number',
                'vendor_stores.status',
                'vendors.name as vendor_name',
                'vendor_stores.email'
            )
            ->orderBy('vendor_stores.id', 'desc')
            ->where('vendor_stores.seller_type', 'supplier')
            ->get();
        // $vendor_stores = VendorStore::all();
        // print_r($vendor_stores->toArray());die();
        return view('admin/supplier_store/index', compact('vendor_stores', 'vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::supplier()->where('parent_id', 0)->where('status', 'active')->get();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('admin/supplier_store/create', compact('vendors', 'countries', 'states', 'cities'));
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
            'vendor_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            //'pincode'=>'required|numeric',
            'pincode' => 'required',
            'email' => 'required|email|unique:vendor_stores',
            'status' => 'required',
            'branch_admin' => 'required',
            'current_status' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'mobile_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'return_policy' => 'required',
            'pickup_time_limit' => 'required',
            'manager_name' => 'required',
            'no_of_staff' => 'required',
            'lat' => 'required',
            'long' => 'required'
        ], [
            'pincode.required' => 'The zip code field is required.'
        ]);

        $vendor_store = new VendorStore;
        $vendor_store->vendor_id = $request->input('vendor_id');
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
        $vendor_store->return_policy    = $request->input('return_policy');
        $vendor_store->open_status    = $request->input('current_status');
        $vendor_store->manager_name    = $request->input('manager_name');
        $vendor_store->no_of_staff    = $request->input('no_of_staff');
        $vendor_store->created_by = Auth::user()->id;
        $vendor_store->pickup_time_limit = $request->input('pickup_time_limit');
        $vendor_store->setup_fee_required = 'no';
        $vendor_store->seller_type = SUPPLIER;
        if ($files = $request->file('image')) {
            $path = 'public/images/stores';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $vendor_store->image = $profileImage;
        }

        $vendor_store->save();

        StoresVendor::updateOrCreate(
            ['vendor_id' => $request->input('vendor_id')],
            ['store_id' => $vendor_store->id]
        );

        $this->__newStoreCustomerNotification($vendor_store->id, $vendor_store->name, $vendor_store->lat, $vendor_store->long);

        return redirect('/admin/supplier_store')->with('success', "Store has been saved.");
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
        if ($vendor_store->status == 'enable') {
            VendorStore::where('id', $id)->update(array('status' => 'disable'));
            echo json_encode('disable');
        } else {
            VendorStore::where('id', $id)->update(array('status' => 'enable'));
            echo json_encode('enable');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param App\VendorStore $supplier_store
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorStore $supplier_store)
    {
        $vendor_store = $supplier_store;
        $vendors = Vendor::supplier()->where('parent_id', 0)->get();
        $countries = Country::all();

        return view('admin.supplier_store.edit', compact('vendor_store', 'vendors', 'countries'));
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
            'vendor_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            //'pincode'=>'required|numeric',
            'pincode' => 'required',
            'branch_admin' => 'required',
            'email' => 'required|unique:vendor_stores,email,' . $id,
            'status' => 'required',
            'current_status' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'mobile_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'return_policy' => 'required',
            'pickup_time_limit' => 'required',
            'manager_name' => 'required',
            'no_of_staff' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'setup_fee_required' => 'required'
        ], [
            'pincode.required' => 'The zip code field is required.'
        ]);

        $data = array(
            'vendor_id' => $request->input('vendor_id'),
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
            'return_policy'    => $request->input('return_policy'),
            'open_status'    => $request->input('current_status'),
            'updated_by' => Auth::user()->id,
            'pickup_time_limit' => $request->input('pickup_time_limit'),
            'manager_name'    => $request->input('manager_name'),
            'no_of_staff'    => $request->input('no_of_staff'),
            'setup_fee_required' => $request->input('setup_fee_required')
        );
        if ($files = $request->file('image')) {
            $path = 'public/images/stores';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $data['image'] = $profileImage;
        }
        VendorStore::where('id', $id)->update($data);

        return redirect('/admin/supplier_store')->with('success', "Store has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     * @param VendorStore $supplier_store
     * @return Application|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(VendorStore $supplier_store)
    {
        $supplier_store->delete();
        return redirect('/admin/supplier_store')->with('success', "Store has been deleted.");
    }

    public function importStore(Request $request)
    {
        $exists_emails = [];
        $this->validate($request, [
            'vendor' => 'required',
            'import_file'  => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('import_file');
        $extension = $file->getClientOriginalExtension();

        if (strtolower($extension) == 'csv') {
            $fileD = fopen($request->file('import_file'), "r");
            $column = fgetcsv($fileD);

            while (!feof($fileD)) {
                $rowData = fgetcsv($fileD);
                // print_r($rowData);
                if (!empty($rowData)) {
                    $name = $rowData[0];
                    $email = $rowData[1];
                    $phone_number = $rowData[2];
                    $mobile_number = $rowData[3];
                    $manager_name = $rowData[4];
                    $no_of_staff = $rowData[5];
                    $branch_admin = $rowData[6];
                    $images = $rowData[7];
                    $address = $rowData[8];
                    $country = $rowData[9];
                    $state = $rowData[10];
                    $city = $rowData[11];
                    $lat = $rowData[12];
                    $long = $rowData[13];
                    $pincode = (int)$rowData[14];
                    $website_link = $rowData[15];
                    $status = $rowData[16];
                    $current_status = $rowData[17];
                    $pickup_time_limit = $rowData[18];
                    $sunday = explode('-', $rowData[19]);
                    $monday = explode('-', $rowData[20]);
                    $tuesday = explode('-', $rowData[21]);
                    $wednesday = explode('-', $rowData[22]);
                    $thursday = explode('-', $rowData[23]);
                    $friday = explode('-', $rowData[24]);
                    $saturday = explode('-', $rowData[25]);

                    $email_exists = VendorStore::where('email', $email)->exists();
                    // $barcode_exists = ProductVariants::where('barcode',$barcode)->exists();

                    if ($email_exists) {
                        $exists_emails[] = $email;
                    } else {
                        $country_id = DB::table('countries')->where('name', 'like', '%' . $country . '%')->first();
                        if (empty($country_id)) {
                            $countryID = NULL;
                        } else {
                            $countryID = $country_id->id;
                        }
                        $state_id = DB::table('states')->where('name', 'like', '%' . $state . '%')
                            ->where('country_id', $countryID)
                            ->first();
                        if (empty($state_id)) {
                            $stateID = NULL;
                        } else {
                            $stateID = $state_id->id;
                        }
                        $city_id = DB::table('cities')->where('name', 'like', '%' . $city . '%')
                            ->where('state_id', $stateID)
                            ->first();
                        if (empty($city_id)) {
                            $cityID = NULL;
                        } else {
                            $cityID = $city_id->id;
                        }


                        $vendor_store = new VendorStore;
                        $vendor_store->vendor_id = $request->vendor;
                        $vendor_store->name = $name;
                        $vendor_store->email = $email;
                        $vendor_store->phone_number = $phone_number;
                        $vendor_store->mobile_number = $mobile_number;
                        $vendor_store->manager_name = $manager_name;
                        $vendor_store->no_of_staff = $manager_name;
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
                        $vendor_store->seller_type = SUPPLIER;


                        //print_r($vendor->toArray());die();
                        if (trim(strtolower($images)) != '') {
                            // $images_arr = explode(',', $images);
                            $i = 1;

                            // foreach ($images_arr as $key => $value) {
                            // $i++;
                            $file1 = public_path('images/stores') . '/' . $images;
                            $farry1 = explode("/", $file1);
                            $filename1 = end($farry1);
                            $extesion1 = explode('.', $filename1);
                            $extesion1 = end($extesion1);
                            $path1 = public_path('images/stores');
                            $image1 = date('YmdHis') . '.' . $extesion1;
                            $new_image1 = $path1 . '/' . $image1;

                            if (!@copy($images, $new_image1)) {
                            } else {
                                $vendor_store['image'] = $image1;
                            }
                            // }
                        }
                        $vendor_store->save();

                        $this->__newStoreCustomerNotification($vendor_store->id, $vendor_store->name, $vendor_store->lat, $vendor_store->long);

                        // store hours
                        $sunday_data = array(
                            'store_id' => $vendor_store->id,
                            'week_day' => 'sunday',
                            'daystart_time' => ($rowData[19] == 'closed' ? NULL : $sunday[0]),
                            'dayend_time' => ($rowData[19] == 'closed' ? NULL : $sunday[1])
                        );

                        VendorStoreHours::insert($sunday_data);

                        $monday_data = array(
                            'store_id' => $vendor_store->id,
                            'week_day' => 'monday',
                            'daystart_time' => ($rowData[20] == 'closed' ? NULL : $monday[0]),
                            'dayend_time' => ($rowData[20] == 'closed' ? NULL : $monday[1])
                        );

                        VendorStoreHours::insert($monday_data);

                        $tuesday_data = array(
                            'store_id' => $vendor_store->id,
                            'week_day' => 'tuesday',
                            'daystart_time' => ($rowData[21] == 'closed' ? NULL : $tuesday[0]),
                            'dayend_time' => ($rowData[21] == 'closed' ? NULL : $tuesday[1])
                        );

                        VendorStoreHours::insert($tuesday_data);

                        $wednesday_data = array(
                            'store_id' => $vendor_store->id,
                            'week_day' => 'wednesday',
                            'daystart_time' => ($rowData[22] == 'closed' ? NULL : $wednesday[0]),
                            'dayend_time' => ($rowData[22] == 'closed' ? NULL : $wednesday[1])
                        );

                        VendorStoreHours::insert($wednesday_data);

                        $thursday_data = array(
                            'store_id' => $vendor_store->id,
                            'week_day' => 'thursday',
                            'daystart_time' => ($rowData[23] == 'closed' ? NULL : $thursday[0]),
                            'dayend_time' => ($rowData[23] == 'closed' ? NULL : $thursday[1])
                        );

                        VendorStoreHours::insert($thursday_data);

                        $friday_data = array(
                            'store_id' => $vendor_store->id,
                            'week_day' => 'friday',
                            'daystart_time' => ($rowData[24] == 'closed' ? NULL : $friday[0]),
                            'dayend_time' => ($rowData[24] == 'closed' ? NULL : $friday[1])
                        );

                        VendorStoreHours::insert($friday_data);

                        $saturday_data = array(
                            'store_id' => $vendor_store->id,
                            'week_day' => 'saturday',
                            'daystart_time' => ($rowData[25] == 'closed' ? NULL : $saturday[0]),
                            'dayend_time' => ($rowData[25] == 'closed' ? NULL : $saturday[1])
                        );

                        VendorStoreHours::insert($saturday_data);
                    }
                }
            }

            return redirect('/admin/supplier_store')->with('success-data', array('emails' => $exists_emails, 'message' => 'Store successfully imported.'));
        } else {
            return redirect('/admin/supplier_store')->with('error-data', 'The import file must be a file of type: csv.');
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
            //'Pincode',
            'Zip Code',
            'Website Link',
            'Status',
            'Current Status',
            'Pickup Time Limit',
        );

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);


        $vendors_store_data = VendorStore::select(
            'vendor_stores.*',
            'countries.name as country_name',
            'states.name as state_name',
            'cities.name as city_name'
        )
            ->leftjoin('countries', 'countries.id', 'vendor_stores.country')
            ->leftjoin('states', 'states.id', 'vendor_stores.state')
            ->leftjoin('cities', 'cities.id', 'vendor_stores.city')
            ->get();

        $image_url = url('/');
        foreach ($vendors_store_data as $key => $value) {

            if (!empty($value->image)) {
                $image = $image_url . '/public/images/stores/' . $value->image;
            } else {
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
                'Long' => $value->long,
                'Zip Code' => $value->pincode,
                'Website Link' => $value->website_link,
                'Status' => $value->status,
                'Current Status' => $value->open_status,
                'Pickup Time Limit' => $value->pickup_time_limit
            );

            fputcsv($fp, $data);
        }

        exit();
    }
}
