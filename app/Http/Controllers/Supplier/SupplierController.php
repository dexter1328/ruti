<?php

namespace App\Http\Controllers\Supplier;

use App\User;
use Exception;
use App\Orders;
use App\Vendor;
use App\Country;
use App\Category;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use App\Membership;
use App\UserDevice;
use App\VendorRoles;
use App\VendorStore;
use Stripe\Customer;
use App\StoresVendor;
use App\ProductReview;
use App\CustomerWallet;
use App\ProductVariants;
use App\WithdrawRequest;
use Stripe\StripeClient;
use Stripe\Subscription;
use App\MembershipCoupon;
use Illuminate\View\View;
use App\StoreSubscription;
use App\Traits\Permission;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\StoreSubscriptionTemp;
use App\VendorStorePermission;
use App\SupplierSubscriptionTemp;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\CardException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Helpers\LogActivity as Helper;
use Illuminate\Contracts\View\Factory;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\RateLimitException;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\InvalidRequestException;
use Illuminate\Contracts\Foundation\Application;

class SupplierController extends Controller
{
    use Permission;

    private $stripe_secret;
    private $stripe_key;

    public function __construct()
    {
        $this->middleware('auth:vendor');
         $this->middleware(function ($request, $next) {
         	if(!$this->hasVendorPermission(Auth::user())){
         		return redirect('supplier/home');
         	}
         	return $next($request);
         });
        $this->stripe_secret = config('services.stripe.secret');
        $this->stripe_key = config('services.stripe.key');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $vendors = Vendor::whereNotIn('id',[1])->where('parent_id','=',Auth::user()->id)->get();
        return view('supplier.suppliers.index');
    }

    public function view(request $request)
    {
        $columns = array(
            0 => 'name',
            1 => 'phone_number',
            2 => 'email',
            3 => 'role',
            4 => 'action'
        );
        $totalData = Vendor::whereNotIn('id', [1])
            ->where('parent_id', '=', Auth::user()->id)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if (empty($request->input('search.value'))) {

            $vendors = Vendor::leftjoin('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
                ->select('vendors.name', 'vendors.pincode', 'vendors.mobile_number', 'vendors.email', 'vendors.id', 'vendors.status', 'vendors.parent_id', 'vendor_roles.role_name')
                ->whereNotIn('vendors.id', [1])
                ->where('vendors.parent_id', '=', Auth::user()->id)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {

            $search = $request->input('search.value');


            $vendors = Vendor::leftjoin('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
                ->select('vendors.name', 'vendors.pincode', 'vendors.mobile_number', 'vendors.email', 'vendors.id', 'vendors.status', 'vendors.parent_id', 'vendor_roles.role_name')
                ->whereNotIn('vendors.id', [1])
                ->where('vendors.parent_id', '=', Auth::user()->id);

            $vendors = $vendors->where(function ($query) use ($search) {
                $query->where('vendors.name', 'LIKE', "%{$search}%")
                    ->orWhere('vendors.pincode', 'LIKE', "%{$search}%")
                    ->orWhere('vendors.email', 'LIKE', "%{$search}%")
                    ->orWhere('vendors.mobile_number', 'LIKE', "%{$search}%")
                    ->orWhere('vendor_roles.role_name', 'LIKE', "%{$search}%");
                //->orWhereRaw("GROUP_CONCAT(attribute_values.name) LIKE ". "%{$search}%");
            });
            //$products = $products->orHavingRaw('Find_In_Set("'.$search.'", attribute_value_names) > 0');

            $totalFiltered = $vendors;
            $totalFiltered = $totalFiltered->get()->count();

            $vendors = $vendors->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        $data = array();
        if ($vendors->isNotEmpty()) {
            foreach ($vendors as $key => $vendor) {
                // @if($admin->status=='active')color:#009933;@else color: #ff0000;@endif
                if ($vendor->status == 'active') {
                    $color = 'color:#009933;';
                } else {
                    $color = 'color:#ff0000;';
                }
                $cfm_msg = 'Are you sure?';

                // $url = "{{ url('/supplier/suppliers/set-store-permission') }}/{{$vendor->id}}";
                $url = "suppliers/set-store-permission/" . $vendor->id;

                $nestedData['name'] = $vendor->name;
                $nestedData['pincode'] = $vendor->pincode;
                $nestedData['phone_no'] = $vendor->mobile_number;
                $nestedData['email'] = $vendor->email;
                $nestedData['role'] = ($vendor->role_name ? $vendor->role_name : '-');
                $nestedData['action'] = '<form id="deletefrm_' . $vendor->id . '" action="' . route('supplier.destroy', $vendor->id) . '" method="POST" onsubmit="return confirm(\'' . $cfm_msg . '\');">
											<input type="hidden" name="_token" value="' . csrf_token() . '">
											<input type="hidden" name="_method" value="DELETE">
											<a href="' . route('suppliers.edit', $vendor->id) . '" data-toggle="tooltip" data-placement="bottom" title="Edit Supplier">
											<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow(' . $vendor->id . ')" data-toggle="tooltip" data-placement="bottom" title="Delete Supplier">
												<i class="icon-trash icons"></i>
											</a>

											<a href="javascript:void(0);" onclick="changeStatus(' . $vendor->id . ')" >
										 		<i class="fa fa-circle status_' . $vendor->id . '" style="' . $color . '" id="active_' . $vendor->id . '" data-toggle="tooltip" data-placement="bottom" title="Change Status" ></i>
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

        echo json_encode($json_data);
        exit();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();

        $vendor_roles = VendorRoles::where('vendor_id', Auth::user()->id)->get();

        return view('supplier.suppliers.create', compact('countries', 'vendor_roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $date = date('Y-m-d');
        $request->validate([
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email|unique:vendors',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
            'name' => 'required',
            'status' => 'required',
            'role_id' => 'required'
        ], [
            'email.unique' => 'The email has already been taken by you or some other supplier.'
        ]);

        $vendor_parent = Vendor::where('id', Auth::user()->id)->first();

        if ($vendor_parent->parent_id == 0) {
            $parent_id = $vendor_parent->id;
        } else {
            $parent_id = $vendor_parent->parent_id;
        }

        $vendor = new Vendor;
        $vendor->registered_date = $date;
        $vendor->address = $request->input('address');
        $vendor->country = $request->input('country');
        $vendor->state = $request->input('state');
        $vendor->city = $request->input('city');
        $vendor->pincode = $request->input('pincode');
        $vendor->name = $request->input('name');
        $vendor->phone_number = $request->input('phone_number');
        $vendor->mobile_number = $request->input('mobile_number');
        $vendor->email = $request->input('email');
        $vendor->password = bcrypt($request->input('password'));
        $vendor->role_id = $request->input('role_id');
        $vendor->parent_id = $parent_id;
        $vendor->status = $request->input('status');
        $vendor->created_by = Auth::user()->id;

        if ($files = $request->file('image')) {
            $path = 'public/images/suppliers';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $vendor->image = $profileImage;
        }

        $vendor->save();

//        if ($request->has('store_id') && $request->store_id != '') {
//
//            StoresVendor::updateOrCreate(
//                ['vendor_id' => $vendor->id],
//                ['store_id' => $request->store_id]
//            );
//        }

        return redirect('/supplier/suppliers')->with('success', "Employee has been created.");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vendor = Vendor::find($id);
        if ($vendor->status == 'active') {
            Vendor::where('id', $id)->update(array('status' => 'deactive'));
            echo json_encode('deactive');
        } else {
            Vendor::where('id', $id)->update(array('status' => 'active'));
            echo json_encode('active');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $supplier)
    {
        $vendor = $supplier;
        $countries = Country::all();
        $vendor_roles = VendorRoles::where('vendor_id', Auth::user()->id)->get();

        return view('supplier/suppliers/edit', compact('vendor', 'countries', 'vendor_roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'name' => 'required',
            'email' => 'required|unique:vendors,email,' . $id,
            'status' => 'required',
            'role_id' => 'required'
        ], [
            'email.unique' => 'The email has already been taken by you or some other supplier.'
        ]);

        $data = [
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
            'status'    => $request->input('status'),
            'updated_by' => Auth::user()->id
        ];

        if ($files = $request->file('image')) {
            $path = 'public/images/suppliers';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $data['image'] = $profileImage;
        }

        Vendor::where('id', $id)->update($data);

        return redirect('/supplier/suppliers')->with('success', "Employee has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect('/supplier/suppliers')->with('success', "Employee has been deleted.");
    }

    public function profile()
    {
        $vendor = Auth::user();
        if ($vendor->role_id) {
            $vendor_role = VendorRoles::findOrFail($vendor->role_id);
            if (!empty($vendor_role)) {
                $vendor->role_name = $vendor_role->role_name;
            } else {
                $vendor->role_name = 'Unknown';
            }
        } else {
            $vendor->role_name = 'Super Admin';
        }
        $countries = Country::all();
        //$data = $this->getChecklist();
        $cards = $this->retriveVendorCards();
        $stripe_key = $this->stripe_key;


        return view('supplier.suppliers.profile', compact('vendor', 'countries'/*,'data'*/, 'cards','stripe_key'));
    }

    public function editprofile(Request $request)
    {
        $vaildation_array = array(
            'name' => 'required',
            'email' => 'required|unique:vendors,email,' . Auth::user()->id,
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/'
        );
        if (Auth::user()->parent_id == 0) {
            $vaildation_array['business_name'] = 'required';
            $vaildation_array['tax_id'] = 'required';
            $vaildation_array['bank_name'] = 'required';
            $vaildation_array['bank_account_number'] = 'required';
            $vaildation_array['bank_routing_number'] = 'required';
        }
        $vaildation_message_array = array(
            'pincode.required' => 'The zip code field is required.'
        );
        $request->validate($vaildation_array, $vaildation_message_array);

        $vendor = Vendor::find(Auth::user()->id);
        $vendor->name = $request->input('name');
        $vendor->email = $request->input('email');
        $vendor->phone_number = $request->input('phone_number');
        $vendor->mobile_number = $request->input('mobile_number');
        $vendor->address = $request->input('address');
        $vendor->country = $request->input('country');
        $vendor->state = $request->input('state');
        $vendor->city = $request->input('city');
        $vendor->pincode = $request->input('pincode');
        $vendor->business_name = $request->input('business_name');
        $vendor->tax_id = $request->input('tax_id');
        $vendor->bank_name = $request->input('bank_name');
        $vendor->bank_account_number = $request->input('bank_account_number');
        $vendor->bank_routing_number = $request->input('bank_routing_number');

        if ($files = $request->file('image')) {
            $path = 'public/images/suppliers/';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $vendor->image = $profileImage;
        }

        $vendor->save();

        if ($vendor->image != NULL || $vendor->image != '') {
            $this->__completeVendorChecklist(Auth::user()->id, 'signup_image_upload');
        }
        $this->__completeVendorChecklist(Auth::user()->id, 'add_vendor');

        return redirect('supplier/profile')->with('success', "Profile successfully updated.");
    }

    protected function getCategoriesDropDown($prefix, $items)
    {
        $str = '';
        $span = '<span>—</span>';
        foreach ($items as $key => $value) {
            $str .= '<option value="' . $value['id'] . '">' . $prefix . $value['name'] . '</option>';
            if (array_key_exists('child', $value)) {
                $str .= $this->getCategoriesDropDown($prefix . $span, $value['child'], 'child');
            }
        }
        return $str;
    }

    public function importVendor(Request $request)
    {
        $exists_emails = [];
        $this->validate($request, [
            'import_file'  => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('import_file');
        $extension = $file->getClientOriginalExtension();

        if (strtolower($extension) == 'csv') {

            $fileD = fopen($request->file('import_file'), "r");
            $column = fgetcsv($fileD);
            $parentID = (Auth::user()->parent_id == 0) ? Auth::user()->id : Auth::user()->parent_id;

            while (!feof($fileD)) {

                $rowData = fgetcsv($fileD);
                if (!empty($rowData)) {

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
                    $pincode = ($pincode == 0) ? NULL : $pincode;
                    $image = $rowData[10];

                    $email_exists = Vendor::where('email', $email)->exists();
                    if ($email_exists) {
                        $exists_emails[] = 'The ' . $email . ' has already been taken by you or some other supplier. ';
                    } else {

                        $country = DB::table('countries')->where('name', 'like', '%' . $country . '%')->first();
                        $countryID = (empty($country)) ? NULL : $country->id;

                        $state = DB::table('states')->where('name', 'like', '%' . $state . '%')->where('country_id', $countryID)->first();
                        $stateID = (empty($state)) ? NULL : $state->id;

                        $city = DB::table('cities')->where('name', 'like', '%' . $city . '%')->where('state_id', $stateID)->first();
                        $cityID = (empty($city)) ? NULL : $city->id;

                        $vendor = new Vendor;
                        $vendor->name = $name;
                        $vendor->email = $email;
                        $vendor->parent_id = $parentID;
                        $vendor->password = bcrypt($password);
                        $vendor->phone_number = $phone_number;
                        $vendor->mobile_number = $mobile_number;
                        $vendor->address = $address;
                        $vendor->country = $countryID;
                        $vendor->state = $stateID;
                        $vendor->city = $cityID;
                        $vendor->pincode = $pincode;
                        $vendor->status = 'active';

                        if (trim($image) != '') {

                            if (!filter_var($image, FILTER_VALIDATE_URL) === false) {

                                $ext = pathinfo($image, PATHINFO_EXTENSION);
                                $path = public_path('images/vendors');
                                $image_name = date('YmdHis') . '.' . $ext;
                                $new_image = $path . '/' . $image_name;

                                if (!@copy($image, $new_image)) {
                                } else {
                                    $vendor['image'] = $image_name;
                                }

                                /*if(!@file_put_contents($new_image, file_get_contents($image))) {

                                }else{
                                    $vendor['image'] = $image_name;
                                }*/
                            }
                        }
                        $vendor->save();
                    }
                }
            }
            Helper::addToLog('Import Supplier', Auth::user()->id);
            return redirect('/supplier/suppliers')->with('success-data', array('emails' => $exists_emails, 'message' => 'Supplier successfully imported.'));
        } else {
            return redirect('/supplier/suppliers')->with('error-data', 'The import file must be a file of type: csv.');
        }
    }

    public function getImportPreview(Request $request)
    {
        // print_r($request->all());die();
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $data = [];
        if (strtolower($extension) == 'csv') {

            $fileOpen = fopen($request->file('file'), "r");
            $column = fgetcsv($fileOpen);
            if (count($column) == 11) {

                while (!feof($fileOpen)) {

                    $rowData = fgetcsv($fileOpen);
                    if (!empty($rowData) && count($column) == count($rowData)) {

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
                            'image' => $rowData[10]
                        );
                    }
                }
                echo json_encode(array('error' => '', 'data' => $data));
                exit();
            } else {
                echo json_encode(array('error' => "Your uploaded CSV column does not match with the sample CSV", 'data' => null));
                exit();
            }
        } else {
            echo json_encode(array('error' => "Please upload comma seprated CSV file", 'data' => null));
            exit();
        }
    }

    public function setStorePermission(Request $request, $id)
    {
        if (empty($request->all())) {
            $store = StoresVendor::select('vendor_stores.id', 'vendor_stores.name')
                ->join('vendor_stores', 'vendor_stores.id', 'stores_vendors.store_id')
                ->where('stores_vendors.vendor_id', $id)
                ->first();
            $store_permission = VendorStorePermission::where('vendor_id', $id)->where('store_id', $store->id)->first();
            $vendor_name  = Vendor::where('id', $id)->first();
            return view('supplier/suppliers/set_store_permission', compact('id', 'store', 'store_permission', 'vendor_name'));
        } else {

            $request->validate([
                'to_date' => 'required',
                'from_date' => 'required',
            ]);
            $store_permission = VendorStorePermission::where('vendor_id', $id)->where('store_id', $request->store_id)->first();

            if (!empty($store_permission)) {
                if ($request->btn == 'btnDelete') {
                    VendorStorePermission::where('vendor_id', $id)->where('store_id', $request->store_id)->delete();
                    return redirect('/supplier/suppliers')->with('success', "Supplier Permission deleted.");
                } else {
                    $store_permission->to = $request->to_date;
                    $store_permission->from = $request->from_date;
                    $store_permission->status = 'active';
                    $store_permission->save();
                    return redirect('/supplier/suppliers')->with('success', "Supplier Permission updated.");
                }
            } else {
                $vendor_store_permission = new VendorStorePermission;
                $vendor_store_permission->vendor_id = $id;
                $vendor_store_permission->store_id = $request->store_id;
                $vendor_store_permission->to = $request->to_date;
                $vendor_store_permission->from = $request->from_date;
                $vendor_store_permission->status = 'active';
                $vendor_store_permission->save();
                return redirect('/supplier/suppliers')->with('success', "Supplier Permission saved.");
            }
        }
    }

    public function exportVendor()
    {
        $filename = "employees.csv";
        $fp = fopen('php://output', 'w');

        $header = array('Name', 'Email', 'Phone Number', 'Mobile Number', 'Address', 'City', 'State', 'Country', 'Zip Code', 'Store', 'Role', 'Image');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);

        if (Auth::user()->parent_id == 0) {
            $vendorID = Auth::user()->id;
        } else {
            $vendorID = Auth::user()->parent_id;
        }

        $vendors = Vendor::select([
            'vendors.*',
            'countries.name as country_name',
            'states.name as state_name',
            'cities.name as city_name',
            'vendor_stores.name as store_name',
            'vendor_roles.role_name'
        ])
            ->leftjoin('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
            ->leftjoin('stores_vendors', 'stores_vendors.vendor_id', 'vendors.id')
            ->leftjoin('vendor_stores', 'vendor_stores.id', 'stores_vendors.store_id')
            ->leftjoin('countries', 'countries.id', 'vendors.country')
            ->leftjoin('states', 'states.id', 'vendors.state')
            ->leftjoin('cities', 'cities.id', 'vendors.city')
            ->where('vendors.parent_id', $vendorID)
            ->groupBy('vendors.id')
            ->get();

        $image_url = url('/');

        foreach ($vendors as $key => $vendor) {

            if (!empty($vendor->image)) {
                $image = $image_url . '/public/images/suppliers/' . $vendor->image;
            } else {
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
        Helper::addToLog('Export Supplier', Auth::user()->id);
        exit();
    }

    public function loginVendorHistory()
    {
        $login_history = DB::table('log_activities')
            ->select(
                'vendors.name',
                'log_activities.created_at',
                'log_activities.ip',
                'log_activities.subject',
                'vendor_roles.role_name',
                'log_activities.type'
            )
            ->join('vendors', 'vendors.id', 'log_activities.user_id')
            ->leftjoin('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
            ->orderBy('log_activities.id', 'DESC')
            ->where('log_activities.subject', '!=', 'Supplier Login')
            ->get();

        return view('supplier.suppliers.login_history_vendor', compact('login_history'));
    }

    public function addBankDetail(Request $request)
    {
        $detail = array(
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_no,
            'bank_routing_number' => $request->bank_routing_no
        );

        Vendor::where('id', Auth::user()->id)->update($detail);

        echo json_encode(array('success' => 'Bank Detail has been added.'));
        exit();
        // return redirect('supplier/home')->with('success','Bank Detail has been added.');
    }

    public function activePlan()
    {
        $plans = SupplierSubscriptionTemp::with('membership')->where('vendor_id', Auth::user()->id)
            ->get();
            // dd($plans);
        return view('supplier.suppliers.active_plan', compact('plans'));
    }

    public function choosePlan()
    {
        $checkEmpty = Vendor::where('id', Auth::user()->id)->first();

        if($checkEmpty->stripe_customer_id == null){

            $stripe = new StripeClient(config('stripe.secret_key'));
            $newCustomer =  $stripe->customers->create([
                'description' => $checkEmpty->name,
              ]);
              $checkEmpty->stripe_customer_id = $newCustomer->id;
              $checkEmpty->update();
        }

        $memberships = Membership::where('type', 'supplier')
            ->with('membershipItems')
            ->whereHas('membershipItems',  function ($query) {
                $query->whereNotNull('billing_period');
            })
            ->get();

        return view('supplier.suppliers.choose_plan', compact('memberships'));
    }

    public function getSubscription()
    {
        $current_subscription = [];


        $current_subscription = SupplierSubscriptionTemp::select('supplier_subscription_temps.*', 'memberships.name', 'membership_items.billing_period', 'membership_items.price')
            ->join('memberships', 'memberships.id', 'supplier_subscription_temps.membership_id')
            ->join('membership_items', 'membership_items.id', 'supplier_subscription_temps.membership_item_id')
            ->where('vendor_id', Auth::user()->id)
            ->first();

        if (!empty($current_subscription)) {
            $current_subscription->end_date = date('d M, Y h:i A', strtotime($current_subscription->end_date));
        }

        return response()->json(array(
            'current_subscription' => $current_subscription,
        ));
    }

    // get payment page

    public function paymentPage($id)
    {

        $checkEmpty = Vendor::where('id', Auth::user()->id)->first();

        if($checkEmpty->stripe_customer_id == null){

            $stripe = new StripeClient(config('stripe.secret_key'));
            $newCustomer =  $stripe->customers->create([
                'description' => $checkEmpty->name,
              ]);
              $checkEmpty->stripe_customer_id = $newCustomer->id;
              $checkEmpty->update();
        }


      $plan = Membership::with('monthMembershipItem','yearMembershipItem')->where('id',$id)->first();

      $stripe = new StripeClient(config('stripe.secret_key'));

      $cards =  $stripe->customers->allSources(
        Auth::user()->stripe_customer_id,
        ['object' => 'card', 'limit' => 3]
    );
      return view('supplier.suppliers.subscription', compact('plan','cards')) ;
    }


    public function createSubscription(Request $request)
    {

        $status = '';
        $message = '';

        $checkEmpty = Vendor::where('id', Auth::user()->id)->first();

        if($checkEmpty->stripe_customer_id == null){

            $stripe = new StripeClient(config('stripe.secret_key'));
            $newCustomer =  $stripe->customers->create([
                'description' => $checkEmpty->name,
              ]);
              $checkEmpty->stripe_customer_id = $newCustomer->id;
              $checkEmpty->update();
        }

        \Stripe\Stripe::setApiKey($this->stripe_secret);

        $stripe_customer_id = Auth::user()->stripe_customer_id;
        $data = array(
            "customer" => $stripe_customer_id,
            "items" => array(
                array(
                    "plan" => $request->stripe_price_id,
                ),
            ),
            "default_payment_method" => $request->stripe_card_id
        );



        try {

            $subscription = \Stripe\Subscription::create($data);

            $store_subscription = new SupplierSubscriptionTemp();
            $store_subscription->vendor_id = Auth::user()->id;
            $store_subscription->card_id = $request->stripe_card_id;
            $store_subscription->subscription_id = $subscription->id;
            $store_subscription->subscription_item_id = $subscription->items->data[0]->id;
            $store_subscription->membership_id = $request->membership_id;
            // $store_subscription->membership_item_id = $request->membership_item_id;
            // $store_subscription->membership_code = $request->membership_code;

            $store_subscription->start_date = date('Y-m-d H:i:s', $subscription->current_period_start);
            $store_subscription->end_date = date('Y-m-d H:i:s', $subscription->current_period_end);
            $store_subscription->status = $subscription->status;
            // $store_subscription->plan_type = 'create';
            $store_subscription->save();


            return back()->with('success','Thank you for your subscription. We will update you shortly.');
            $status = 'success';
            $message = 'Thank you for your subscription. We will update you shortly.';
        } catch (CardException $e) {

            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (RateLimitException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (InvalidRequestException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (AuthenticationException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (ApiConnectionException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (ApiErrorException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        }
        // }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function changeSubscription(Request $request)
    {
        $status = '';
        $message = '';
        $validator = Validator::make($request->all(), [
            'store_id' => 'required',
            'membership_id' => 'required',
            'stripe_price_id' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
        // echo '<pre>'; print_r($request->all()); exit();

        $store_subscription = SupplierSubscriptionTemp::where('vendor_id', Auth::user()->id)->first();
        if (!empty($supplier_subscription)) {

            if ($store_subscription->is_cancelled == 'yes') {

                $status = 'error';
                $message = 'You have already cancelled the plan and you cannot upgrade / downgrade your plan.';
            } else {

                $price_id = $request->stripe_price_id;
                $subscription_id = $store_subscription->subscription_id;
                $subscription_item_id = $store_subscription->subscription_item_id;

                \Stripe\Stripe::setApiKey($this->stripe_secret);

                try {

                    $data = array(
                        /*'cancel_at_period_end' => false,
                        'proration_behavior' => 'create_prorations',*/

                        'payment_behavior' => 'pending_if_incomplete',
                        'proration_behavior' => 'always_invoice',
                        'items' => [
                            [
                                'id' => $subscription_item_id,
                                'price' => $price_id,
                            ],
                        ],
                    );

                    if ($request->has('stripe_coupon_id') &&  $request->get('stripe_coupon_id') != '') {

                        $data['coupon'] = $request->get('stripe_coupon_id');
                    }

                    $subscription = \Stripe\Subscription::update($subscription_id, $data);

                    $store_subscription_temp = new StoreSubscriptionTemp;
                    $store_subscription_temp->vendor_id = Auth::user()->id;
                    $store_subscription_temp->card_id = $store_subscription->card_id;
                    $store_subscription_temp->subscription_id = $subscription->id;
                    $store_subscription_temp->subscription_item_id = $subscription->items->data[0]->id;
                    $store_subscription_temp->membership_id = $request->membership_id;
                    // $store_subscription_temp->membership_item_id = $request->membership_item_id;
                    // $store_subscription_temp->membership_code = $request->membership_code;
                    // if ($request->has('stripe_coupon_id') &&  $request->get('stripe_coupon_id') != '') {
                    //     $store_subscription_temp->membership_coupon_id = $request->membership_coupon_id;
                    // }
                    // if ($request->has('extra_license') &&  $request->get('extra_license') != '') {
                    //     $store_subscription_temp->extra_license = $request->extra_license;
                    // }
                    $store_subscription_temp->start_date = date('Y-m-d H:i:s', $subscription->current_period_start);
                    $store_subscription_temp->end_date = date('Y-m-d H:i:s', $subscription->current_period_end);
                    $store_subscription_temp->status = $subscription->status;
                    // $store_subscription_temp->plan_type = 'change';
                    $store_subscription_temp->save();

                    // if ($request->has('stripe_coupon_id') &&  $request->get('stripe_coupon_id') != '') {
                    //     DB::table('membership_coupons')
                    //         ->where('id', $request->membership_coupon_id)
                    //         ->update(['is_used' => 'yes', 'updated_at' => Carbon::now()]);
                    // }

                    $status = 'success';
                    $message = 'Your subscription has been changed. We will update you shortly.';
                } catch (CardException $e) {

                    $status = 'error';
                    $message = $e->getMessage();
                } catch (RateLimitException $e) {

                    $status = 'error';
                    $message = $e->getMessage();
                } catch (InvalidRequestException $e) {

                    $status = 'error';
                    $message = $e->getMessage();
                } catch (AuthenticationException $e) {

                    $status = 'error';
                    $message = $e->getMessage();
                } catch (ApiConnectionException $e) {

                    $status = 'error';
                    $message = $e->getMessage();
                } catch (ApiErrorException $e) {

                    $status = 'error';
                    $message = $e->getMessage();
                } catch (Exception $e) {

                    $status = 'error';
                    $message = $e->getMessage();
                }
            }
        } else {

            $status = 'error';
            $message = 'Store subscription not found.';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function cancelSubscription($id)
    {
        $plan = SupplierSubscriptionTemp::findOrFail($id);
        if ($plan) {

            Stripe::setApiKey($this->stripe_secret);
            try {

                /*$subscription = Stripe\Subscription::retrieve($plan->subscription_id);
                $subscription->cancel();*/

                Subscription::update(
                    $plan->subscription_id,
                    [
                        'cancel_at_period_end' => true,
                    ]
                );

                $plan->is_cancelled = 'yes';
                $plan->save();

                return redirect('/supplier/active-plans')->with('success', "Your plan is valid till " . date('d M, Y h:i A', strtotime($plan->end_date)));
            } catch (CardException | RateLimitException | InvalidRequestException | AuthenticationException | ApiConnectionException | ApiErrorException | Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            $message = "Plan not found.";
        }

        return back()->with("error", $message);
    }

    public function checklist()
    {
        //$data = $this->getChecklist();
        return view('supplier.suppliers.checklist'/*,compact('data')*/);
    }

    private function retriveVendorCards()
    {
        $cards = [];
        $stripe_customer_id = Auth::user()->stripe_customer_id;
        if ($stripe_customer_id != NULL && $stripe_customer_id != '') {
            Stripe::setApiKey($this->stripe_secret);
            try {
                $response = \Stripe\Customer::retrieve($stripe_customer_id);
                if (isset($response->sources->data)) {
                    $stripe_cards = $response->sources->data;
                    foreach ($stripe_cards as $key => $value) {
                        $cards[] = array(
                            'id' => $value->id,
                            'object' => $value->object,
                            'brand' => $value->brand,
                            'country' => $value->country,
                            'exp_month' => $value->exp_month,
                            'exp_year' => $value->exp_year,
                            'funding' => $value->funding,
                            'last4' => $value->last4,
                            'default' => ($response->default_source == $value->id ? true : false)
                        );
                    }
                }
            } catch (CardException | RateLimitException | InvalidRequestException | AuthenticationException | ApiConnectionException | ApiErrorException | Exception $e) {
            }
        }
        return $cards;
    }

    /*public function manageVendorCard()
    {
        $manageCard = view('supplier/suppliers/card')->render();
        $data = array('manageCard' => $manageCard);
        return response()->json(['status' => 'success', 'data' => $data]);
    }*/

    public function getSupplierCard()
    {
        $cards = $this->retriveVendorCards();
        $cardlist = view('supplier/suppliers/card-list', compact('cards'))->render();
        $data = array('cardlist' => $cardlist);
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function saveSupplierCard(Request $request)
    {
        $status = '';
        $data = '';
        $message = '';
        $stripe_customer_id = Auth::user()->stripe_customer_id;
        $name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $email = Auth::user()->email;

        if ($request->has('stripeToken') && $request->get('stripeToken') != '') {
            if ($stripe_customer_id != NULL && $stripe_customer_id != '') {
                $customer_id = $stripe_customer_id;

            } else {
                try {
                    Stripe::setApiKey($this->stripe_secret);

                    $customer = \Stripe\Customer::create([
                        "name" => $name,
                        "email" => $email
                    ]);
                    $customer_id = $customer->id;
                    DB::table('vendors')->where('id', Auth::user()->id)->update(['stripe_customer_id' => $customer_id]);
                } catch (CardException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (RateLimitException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (InvalidRequestException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (AuthenticationException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (ApiConnectionException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (ApiErrorException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (Exception $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                }
            }

            if ($status == 'error') {

                return response()->json([
                    'status' => 'error',
                    'data' => [],
                    'message' => $message
                ]);
            }

            try {
                \Stripe\Stripe::setApiKey($this->stripe_secret);
                $card = \Stripe\Customer::createSource(
                    $customer_id,
                    ['source' => $request->get('stripeToken')]
                );

                $data = array(
                    'id' => $card->id,
                    'object' => $card->object,
                    'brand' => $card->brand,
                    'country' => $card->country,
                    'exp_month' => $card->exp_month,
                    'exp_year' => $card->exp_year,
                    'funding' => $card->funding,
                    'last4' => $card->last4
                );

                $status = 'success';
                $message = 'Your card has been saved.';
            } catch (CardException $e) {
                $status = 'error';
                $message = $e->getMessage();
            } catch (RateLimitException $e) {
                $status = 'error';
                $message = $e->getMessage();
            } catch (InvalidRequestException $e) {
                $status = 'error';
                $message = $e->getMessage();
            } catch (AuthenticationException $e) {
                $status = 'error';
                $message = $e->getMessage();
            } catch (ApiConnectionException $e) {
                $status = 'error';
                $message = $e->getMessage();
            } catch (ApiErrorException $e) {
                $status = 'error';
                $message = $e->getMessage();
            } catch (Exception $e) {
                $status = 'error';
                $message = $e->getMessage();
            }
        } else {
            $status = 'error';
            $message = 'Stripe token field is required.';
        }

        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' => $message
        ]);
    }

    public function editSupplierCard(Request $request)
    {
        $status = '';
        $data = '';
        $message = '';
        $vendor = Vendor::findOrFail(Auth::user()->id);

        if ($request->get('month') != '' && $request->get('year') != '') {

            if ($request->has('card_id') && $request->get('card_id') != '') {

                if ($vendor->stripe_customer_id != NULL) {

                    try {

                        \Stripe\Stripe::setApiKey($this->stripe_secret);
                        $response = \Stripe\Customer::updateSource(
                            $vendor->stripe_customer_id,
                            $request->get('card_id'),
                            ['exp_month' => $request->get('month'), 'exp_year' => $request->get('year')]
                        );
                        $status = 'success';
                        $message = 'Your card has been updated.';
                    } catch (CardException $e) {

                        $status = 'error';
                        $message = $e->getMessage();
                    } catch (RateLimitException $e) {

                        $status = 'error';
                        $message = $e->getMessage();
                    } catch (InvalidRequestException $e) {

                        $status = 'error';
                        $message = $e->getMessage();
                    } catch (AuthenticationException $e) {

                        $status = 'error';
                        $message = $e->getMessage();
                    } catch (ApiConnectionException $e) {

                        $status = 'error';
                        $message = $e->getMessage();
                    } catch (ApiErrorException $e) {

                        $status = 'error';
                        $message = $e->getMessage();
                    } catch (Exception $e) {

                        $status = 'error';
                        $message = $e->getMessage();
                    }
                } else {

                    $status = 'error';
                    $message = 'Your are not our vendor client.';
                }
            } else {

                $status = 'error';
                $message = 'Card not found.';
            }
        } else {

            $status = 'error';
            $message = 'All fields are required.';
        }

        $result = array(
            'status' => $status,
            'data' => $data,
            'message' => $message
        );

        return response()->json($result);
    }

    public function deleteSupplierCard(Request $request)
    {
        $status = '';
        $message = '';
        $vendor = Vendor::findOrFail(Auth::user()->id);

        if ($request->has('card_id') && $request->get('card_id') != '') {

            if ($vendor->stripe_customer_id != NULL) {

                try {

                    \Stripe\Stripe::setApiKey($this->stripe_secret);
                    $response = \Stripe\Customer::deleteSource(
                        $vendor->stripe_customer_id,
                        $request->get('card_id')
                    );
                    $status = 'success';
                    $message = 'Your selected card has been deleted.';
                } catch (CardException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (RateLimitException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (InvalidRequestException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (AuthenticationException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (ApiConnectionException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (ApiErrorException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (Exception $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                }
            } else {
                $status = 'error';
                $message = 'Customer not found.';
            }
        } else {
            $status = 'error';
            $message = 'Card not found.';
        }

        $result = array(
            'status' => $status,
            'message' => $message
        );

        return response()->json($result);
    }

    public function setVendorDefaultCard(Request $request)
    {
        $status = '';
        $message = '';
        $vendor = Vendor::findOrFail(Auth::user()->id);

        if ($request->has('card_id') && $request->get('card_id') != '') {

            if ($vendor->stripe_customer_id != NULL) {

                try {

                    \Stripe\Stripe::setApiKey($this->stripe_secret);
                    $response = \Stripe\Customer::update(
                        $vendor->stripe_customer_id,
                        ['default_source' => $request->get('card_id')]
                    );
                    $status = 'success';
                    $message = 'Your selected card has been save as defualt.';
                } catch (CardException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (RateLimitException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (InvalidRequestException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (AuthenticationException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (ApiConnectionException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (ApiErrorException $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                } catch (Exception $e) {
                    $status = 'error';
                    $message = $e->getMessage();
                }
            } else {
                $status = 'error';
                $message = 'You did not save any card.';
            }
        } else {
            $status = 'error';
            $message = 'Card not found.';
        }

        $result = array(
            'status' => $status,
            'message' => $message
        );
        return response()->json($result);
    }

    public function getAssignedCoupon($store_id)
    {
        $data = DB::table('membership_coupons')
            ->where('store_id', $store_id)
            ->where('vendor_id', Auth::user()->id)
            ->where('is_used', 'no')
            ->first();
        return response()->json($data);
    }

    public function getStoreRoles($store_id)
    {
        $limit = 2;
        $current_subscription = StoreSubscription::where('store_id', $store_id)->first();
        if (!empty($current_subscription)) {
            $limit = empty($current_subscription->extra_license) ? $limit : $current_subscription->extra_license + $limit;
            $vendor_roles = VendorRoles::where('vendor_id', Auth::user()->id)->limit($limit)->get();
        } else {
            $vendor_roles = [];
        }
        echo json_encode($vendor_roles);
        exit();
    }

    public function completeUserGuide(Request $request, $id)
    {
        Vendor::where('id', $id)->update(array('is_user_guide_completed' => $request->status));
        return response()->json([
            'status' => 'success',
            'message' => 'User guide has been completed.'
        ]);
    }

    /*public function inventoryUpdateReminderCheck($id)
    {
        $day = date('l');
        $time = date('H:i');
        $date = date('Y-m-d', strtotime('-7 days'));
        $user = DB::table('vendors')
            ->select(
                'vendors.id',
                'vendors.name',
                'vendors.email',
                'stores_vendors.store_id',
                'vendor_stores.name as store_name'
            )
            ->join('vendor_roles', 'vendor_roles.id', 'vendors.role_id')
            ->join('stores_vendors', 'stores_vendors.vendor_id', 'vendors.id')
            ->join('vendor_stores', 'vendor_stores.id', 'stores_vendors.store_id')
            ->join('vendor_settings as setting_day', 'setting_day.vendor_id', 'vendors.parent_id')
            ->join('vendor_settings as setting_time', 'setting_time.vendor_id', 'vendors.parent_id')
            ->join('products', 'products.store_id', 'stores_vendors.store_id')
            ->where(function ($query) {
                $query->where('vendor_roles.slug', 'store-manager')
                    ->orWhere('vendor_roles.slug', 'store-supervisor');
            })
            ->where('setting_day.key', 'inventory_update_reminder_day')
            ->where('setting_day.value', $day)
            ->where('setting_time.key', 'inventory_update_reminder_time')
            ->where('setting_time.value', $time)
            ->where('vendors.id', $id)
            ->whereDate('products.updated_at', '<', $date)
            ->groupBy('stores_vendors.store_id')
            ->first();

        return response()->json($user);
    }*/

    //Update Fullfill type

    public function fullfill_type_change($id)
    {

        $rutiFullfill = Membership::where('code','ruti_fullfill')->select('id')->pluck('id')->first();

		$check_rutiFullfill = SupplierSubscriptionTemp::where('vendor_id', Auth::user()->id)->where('membership_id',$rutiFullfill)->first();


        if($check_rutiFullfill == null && request('fullfill_type') == 'ruti_fullfill' ){
          $id = $id;
          return redirect()->route('supplier.choose-ruti-fullfill')->with([ 'ruti_plan' => 'ruti_plan', 'error' => ' Please pay first for ruti fullfill plan' ]);
        }

            $find = Vendor::where('id',$id)->first();
            $find->fullfill_type = request('fullfill_type');
            $find->update();
            return back()->with('success', "update Seller fullfill type");

    }
    public function chooseRutiFullfillPage()
    {
        $supplier = Vendor::where('id', Auth::user()->id)->first();
        $stripe_key = $this->stripe_key;
        return view('supplier.settings.ruti_fulfill_page', compact('stripe_key','supplier'));
    }
    public function rutiFulfillSubmit(Request $request)
    {
        $uid = Auth::user()->id;
        $supplier = Vendor::where('id', $uid)->first();
		Stripe::setApiKey($this->stripe_secret);
		 try {
            if ($supplier->stripe_customer_id) {
                $customer = $supplier->stripe_customer_id;
                // dd(122);
            }
            else {
                # code...
                // dd(123);
                $customer = Customer::create(array(

                    "email" => $supplier->email,

                    "name" => $supplier->first_name,

                    "source" => $supplier->stripeToken

                 ));
                //   dd($customer->id);
                 $supplier->update([
                    'stripe_customer_id' => $customer->id
                 ]);
                //  dd($wallet);
            }

            //  dd($customer->id);

                Charge::create ([
	                "amount" => 25 * 100,
	                "currency" => "usd",
	                "customer" => $supplier->stripe_customer_id,
	                "description" => "Nature checkout fulfillment done"
        		]);
                $debit = $supplier->wallet_amount - 25;
                $supplier->update([
                    'wallet_amount' => $debit,
                    'fulfill_type' => 'nature'
                 ]);


			    return redirect()->back()->with('success', 'Your Fulfillments will now be done by Nature checkout');

            } catch(CardException $e) {
                $errors = $e->getMessage();
            } catch (RateLimitException $e) {
                $errors = $e->getMessage();
            } catch (InvalidRequestException $e) {
                $errors = $e->getMessage();
            } catch (AuthenticationException $e) {
                $errors = $e->getMessage();
            } catch (ApiConnectionException $e) {
                $errors = $e->getMessage();
            } catch (ApiErrorException $e) {
               $errors = $e->getMessage();
            } catch (Exception $e) {
                $errors = $e->getMessage();
            }

			return $this->sendError($errors);
    }
    public function fulfillWithWallet(Request $request)
    {
        $input = $request->amount;

        $uid = Auth::user()->id;
        //  dd($input);
        $user = Vendor::where('id', $uid)->first();
        // dd($user);
        if ($user->wallet_amount < $input) {
            return redirect()->back()->with('error', 'Your balance is not enough');
        }
        else {
            $debit = $user->wallet_amount - $input;
            $user->update([
                'wallet_amount' => $debit,
                'fulfill_type' => 'nature'
            ]);
            return redirect()->back()->with('success', 'Your Fulfillments will now be done by Nature checkout');
        }
    }
    public function supplierFulfill(Request $request)
    {
        # code...
        $uid = Auth::user()->id;
        $supplier = Vendor::where('id', $uid)->first();
        $supplier->update([
            'fulfill_type' => $request->fulfill_type
         ]);
         return redirect()->back()->with('success', 'Your Fulfillments will now be done by Yourself');
    }
    public function supplierWallet()
    {
        # code...
        $supplier = Vendor::where('id', Auth::user()->id)->first();
        $stripe_key = $this->stripe_key;

        return view('supplier.settings.supplier_wallet', compact('supplier','stripe_key'));
    }
    public function receiveWallet()
    {
        # code...
        $supplier = Vendor::where('id', Auth::user()->id)->first();

        return view('supplier.settings.receive_funds', compact('supplier'));
    }
    public function withdrawWallet()
    {
        # code...

        $supplier = Auth::user();

        return view('supplier.settings.withdraw_funds', compact('supplier'));
    }
    public function withdrawToBank(Request $request)
    {
        // dd($request->all());
        $uid = Auth::user()->id;
        $supplier = Vendor::where('id', $uid)->first();
        if ($supplier->wallet_amount < $request->amount) {
            return redirect()->back()->with('error', 'Your balance is not enough');
        }
        else {

            $debit = $supplier->wallet_amount - $request->amount;
            $supplier->update([
                'wallet_amount' => $debit
            ]);
        }

        WithdrawRequest::create([
            'user_id' => $uid,
            'bank_name' => $request->bank_name,
            'routing_number' => $request->routing_number,
            'account_title' => $request->account_title,
            'account_no' => $request->account_no,
            'amount' => $request->amount
        ]);
        $contact_data = [
            'fullname' => $request->account_title,
            'account_no' => $request->account_no,
            'amount' => $request->amount
        ];
        Mail::to('ahmad.nab331@gmail.com')->send(new WithdrawMail($contact_data));

        return redirect()->back()->with('success', 'You will get payment soon');

    }

    public function supplierWalletPayment(Request $request, $amount)
    {
        $uid = Auth::user()->id;
        $supplier = Vendor::where('id', $uid)->first();
        if ($supplier->wallet_amount < $amount) {
            return redirect()->back()->with('error', 'Your balance is not enough');
        }
        else {

            $debit = $supplier->wallet_amount - $amount;
            $supplier->update([
                'wallet_amount' => $debit,
            ]);

        }
        return redirect()->back()->with('success', 'Your Fulfillments will now be done by Nature checkout');
    }
    public function addToWallet(Request $request)
    {
        # code...
        // dd($request->all());
        $uid = Auth::user()->id;
        $wallet = Vendor::where('id', $uid)->first();
        // dd($wallet);
		Stripe::setApiKey($this->stripe_secret);
		 try {
            if ($wallet->stripe_customer_id) {
                $customer = $wallet->stripe_customer_id;
                // dd(122);
            }
            else {
                # code...
                // dd(123);
                $customer = Customer::create(array(

                    "email" => $wallet->email,

                    "name" => $wallet->first_name,

                    "source" => $request->stripeToken

                 ));
                //   dd($customer->id);
                 $wallet->update([
                    'stripe_customer_id' => $customer->id
                 ]);
                //   dd($wallet);
            }

            //  dd($customer->id);

                Charge::create ([
	                "amount" => $request->amount * 100,
	                "currency" => "usd",
	                "customer" => $wallet->stripe_customer_id,
	                "description" => "Money added in your wallet."
        		]);

        		$closing_amount = $wallet->wallet_amount+$request->amount;

				$customer_wallet = new CustomerWallet;
				$customer_wallet->customer_id = $uid;
				$customer_wallet->amount = $request->amount;
				$customer_wallet->closing_amount = $closing_amount;
				$customer_wallet->type = 'credit';
				$customer_wallet->save();

				if(empty($wallet->wallet_amount)){
					Vendor::where('id',$uid)->update(array('wallet_amount'=>$request->amount));
				}else{
					$amount = $wallet->wallet_amount+$request->amount;
					Vendor::where('id',$uid)->update(array('wallet_amount'=>$amount));
				}

				// notification
				$id = $customer_wallet->id;
				$type = 'wallet_transaction';
			    $title = 'Wallet';
			    $message = 'Money has been added to your wallet';
			    $devices = UserDevice::where('user_id',$wallet->id)->where('user_type','customer')->get();

			    return redirect()->back()->with('success', 'Money added to wallet');

            } catch(CardException $e) {
                $errors = $e->getMessage();
            } catch (RateLimitException $e) {
                $errors = $e->getMessage();
            } catch (InvalidRequestException $e) {
                $errors = $e->getMessage();
            } catch (AuthenticationException $e) {
                $errors = $e->getMessage();
            } catch (ApiConnectionException $e) {
                $errors = $e->getMessage();
            } catch (ApiErrorException $e) {
               $errors = $e->getMessage();
            } catch (Exception $e) {
                $errors = $e->getMessage();
            }

			return $this->sendError($errors);
    }
    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'data' => null,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
    // go to ruti fullfill plan page
    public function chooseRutiFullfill()
    {
        $checkEmpty = Vendor::where('id', Auth::user()->id)->first();

        if($checkEmpty->stripe_customer_id == null){

            $stripe = new StripeClient(config('stripe.secret_key'));
            $newCustomer =  $stripe->customers->create([
                'description' => $checkEmpty->name,
              ]);
              $checkEmpty->stripe_customer_id = $newCustomer->id;
              $checkEmpty->update();
        }

        // $memberships = Membership::where('type', 'supplier_ruti_full')
        //     ->with('membershipItems')
        //     ->whereHas('membershipItems',  function ($query) {
        //         $query->whereNotNull('billing_period');
        //     })
        //     ->get();

            $plan = Membership::with('monthMembershipItem','yearMembershipItem')->where('type','supplier_ruti_fullfill')->first();
            $stripe = new StripeClient(config('stripe.secret_key'));
            $cards =  $stripe->customers->allSources(
        Auth::user()->stripe_customer_id,
        ['object' => 'card', 'limit' => 3]
    );

        return view('supplier.settings.ruti_fullfill_pay', compact('plan','cards'));
    }

    //Make rutifullfill payment

    public function rutiPayment(Request $request)
    {

        $status = '';
        $message = '';

        $checkEmpty = Vendor::where('id', Auth::user()->id)->first();

        if($checkEmpty->stripe_customer_id == null){

            $stripe = new StripeClient(config('stripe.secret_key'));
            $newCustomer =  $stripe->customers->create([
                'description' => $checkEmpty->name,
              ]);
              $checkEmpty->stripe_customer_id = $newCustomer->id;
              $checkEmpty->update();
        }

        \Stripe\Stripe::setApiKey($this->stripe_secret);

        $stripe_customer_id = Auth::user()->stripe_customer_id;
        $data = array(
            "customer" => $stripe_customer_id,
            "items" => array(
                array(
                    "plan" => $request->stripe_price_id,
                ),
            ),
            "default_payment_method" => $request->stripe_card_id
        );



        try {

            $subscription = \Stripe\Subscription::create($data);

            $store_subscription = new SupplierSubscriptionTemp();
            $store_subscription->vendor_id = Auth::user()->id;
            $store_subscription->card_id = $request->stripe_card_id;
            $store_subscription->subscription_id = $subscription->id;
            $store_subscription->subscription_item_id = $subscription->items->data[0]->id;
            $store_subscription->membership_id = $request->membership_id;
            // $store_subscription->membership_item_id = $request->membership_item_id;
            // $store_subscription->membership_code = $request->membership_code;

            $store_subscription->start_date = date('Y-m-d H:i:s', $subscription->current_period_start);
            $store_subscription->end_date = date('Y-m-d H:i:s', $subscription->current_period_end);
            $store_subscription->status = $subscription->status;
            // $store_subscription->plan_type = 'create';
            $store_subscription->save();

            //also change the type

            $find = Vendor::where('id',Auth::user()->id)->first();
            $find->fullfill_type = 'ruti_fullfill';
            $find->update();

            return redirect()->route('supplier.settings.index')->with('success','payment for Ruti fullfill was successfull.');
            $status = 'success';
            $message = 'Thank you for your payment. We will update you shortly.';
        } catch (CardException $e) {

            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (RateLimitException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (InvalidRequestException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (AuthenticationException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (ApiConnectionException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (ApiErrorException $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        } catch (Exception $e) {
            return back()->with('error',$e->getMessage());
            $status = 'error';
            $message = $e->getMessage();
        }
        // }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

}
