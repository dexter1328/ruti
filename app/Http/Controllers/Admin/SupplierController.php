<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Country;
use App\EmailTemplate;
use App\Mail\SupplierSuccess;
use App\Membership;
use App\Sales;
use App\Vendor;
use App\VendorRoles;
use App\Traits\Permission;
use App\VendorPaidModule;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\SupplierVerificationMail;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    use Permission;
    /**
     * Display a listing of the resource.
     *
     * @return Response
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
        // dd('12');
        $countries = Country::all();

        return view('admin.suppliers.index', compact('countries'));
    }

    public function view(Request $request)
    {

        $query = Vendor::supplier()->with(['supplierCountry'])
            ->when($request->country_id, function ($query, $countryId) {
                $query->whereHas('supplierCountry', function ($q) use ($countryId) {
                    $q->where('id', $countryId);
                });
            })
            ->newQuery();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('is_approved', function (Vendor $vendor) {
                $review = "Pending";
                if ($vendor->is_approved == 1) {
                    $review = "Approved";
                }
                if ($vendor->is_approved == 2) {
                    $review = "Rejected";
                }
                return $review;
            })
            ->addColumn('action', function (Vendor $vendor) {
                if ($vendor->status == 'active') {
                    $color = 'color:#009933;';
                } else {
                    $color = 'color:#ff0000;';
                }
                $cfm_msg = 'Are you sure?';

                $action = "";
                if ($vendor->is_approved == 0) {

                    $action = '<a href="' . url('admin/supplier/approve', $vendor->id) . '" class="edit" data-toggle="tooltip" data-placement="bottom" title="Approve" onclick="return confirm(`Are you sure?`)">
                            <i class="fa fa-check-circle-o"></i>
                        </a>
                        <a href="' . url('admin/supplier/reject', $vendor->id) . '" class="text-danger" data-toggle="tooltip" data-placement="bottom" title="Reject" onclick="return confirm(`Are you sure?`)">
                            <i class="fa fa-times-circle-o"></i>
                        </a>';
                }

                return '<form id="deletefrm_' . $vendor->id . '" action="' . route('supplier.destroy', $vendor->id) . '" method="POST" onsubmit="return confirm(\'' . $cfm_msg . '\');">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <a href="' . route('supplier.edit', $vendor->id) . '" data-toggle="tooltip" data-placement="bottom" title="Edit Supplier">
                        <i class="icon-note icons"></i>
                    </a>
                    <a href="javascript:void(0);" onclick="deleteRow(' . $vendor->id . ')" data-toggle="tooltip" data-placement="bottom" title="Delete Supplier">
                        <i class="icon-trash icons"></i>
                    </a>



                    <a href="javascript:void(0);" onclick="changeStatus(' . $vendor->id . ')" >
                        <i class="fa fa-circle status_' . $vendor->id . '" style="' . $color . '" id="active_' . $vendor->id . '" data-toggle="tooltip" data-placement="bottom" title="Change Status" ></i>
                    </a>

                    ' . $action . '
                </form>';
            })
            ->toJson();
    }

    public function reviewUpdate($review, Vendor $supplier)
    {
        $supplier->is_approved = $review == 'approve' ? 1 : 2;
        $supplier->save();

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $memberships = Membership::where('type', 'supplier')->get();
        $countries = Country::all();

        return view('admin.suppliers.create', compact('memberships', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = date('Y-m-d');
        $request->validate([
            'sales_person_name' => 'nullable',
            'sales_person_mobile_number' => 'nullable',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email|unique:vendors',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
            'name' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
            'status' => 'required',
            'business_name' => 'required',
            'tax_id' => 'required'
        ], [
            'email.unique' => 'The email has already been taken by you or some other supplier.'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        if ($request->sales_person_mobile_number || $request->sales_person_name) {
            $sales = Sales::updateOrCreate(
                ['mobile' => $request->sales_person_mobile_number],
                ['name' => $request->sales_person_name]
            );
        }

        $data = array(
            'sales_id' => $sales->id ?? null,
            'registered_date' => $date,
            'expired_date' => date("Y-m-d", strtotime($request->input('expired_date'))),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'website_link' => $request->input('website_link'),
            'status'    => $request->input('status'),
            'admin_commision'    => $request->input('admin_commision'),
            'created_by' => Auth::user()->id,
            'business_name' => $request->input('business_name'),
            'tax_id' => $request->input('tax_id'),
            'seller_type' => 'supplier'
        );
        //print_r($data);die();
        if ($files = $request->file('image')) {
            $path = 'public/images/suppliers';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $data['image'] = $profileImage;
        }

        $vendor = Vendor::create($data);

        foreach (main_vendor_roles() as $key => $value) {
            $vendor_roles = new VendorRoles();
            $vendor_roles->vendor_id = $vendor->id;
            $vendor_roles->role_name = $value;
            $vendor_roles->slug = $key;
            $vendor_roles->status = 'active';
            $vendor_roles->created_by = Auth::user()->id;
            $vendor_roles->updated_by = Auth::user()->id;
            $vendor_roles->save();
        }
        $vendor_name = $request->input('name');

        Mail::to($email)->send(new SupplierSuccess($email, $vendor_name));

        return redirect('admin/supplier')->with('success', "Supplier has been saved.");
    }

    //Approved mail to supplier
    public function approvedMailSupplier($id)
    {
        $supplier = Vendor::where('id', $id)->first();
        if($supplier->is_approved != 1){
            $supplier->is_approved = 1;
            $supplier->update();
            //get email Template
			$mailTemplate = EmailTemplate::where('template','supplier-approved')->first();

            Mail::to($supplier->email)->send(new SupplierVerificationMail($supplier->name,$supplier->email));

            return redirect('admin/supplier')->with('success', "Supplier has been approved.");
        }
        return redirect('admin/supplier')->with('success', "Supplier allready approved.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $vendor = Vendor::supplier()->find($id);
        if ($vendor->status == 'active') {
            Vendor::supplier()->where('id', $id)->update(array('status' => 'deactive'));
            echo json_encode('deactive');
        } else {
            /*if($vendor->verification == 'no'){
                $email = $vendor->email;
                $name = $vendor->name;
                Mail::to($email)->send(new SupplierVerificationMail($email,$name));
            }*/
            Vendor::supplier()->where('id', $id)->update(array('status' => 'active'));
            echo json_encode('active');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param Vendor $vendor
     * @param  int  $id
     * @return Response
     */
    public function edit(Vendor $supplier)
    {
        $sales = Sales::find($supplier->sales_id);
        $memberships = Membership::where('type', 'supplier')->get();
        $countries = Country::all();

        return view('admin.suppliers.edit', compact('memberships', 'supplier', 'countries', 'sales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sales_person_name' => 'required',
            'sales_person_mobile_number' => 'required',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'name' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
            'email' => 'required|unique:vendors,email,' . $id,
            'business_name' => 'required',
            'tax_id' => 'required'
        ], [
            'email.unique' => 'The email has already been taken by you or some other supplier.'
        ]);

        $sales = Sales::updateOrCreate(
            ['mobile' => $request->sales_person_mobile_number],
            ['name' => $request->sales_person_name]
        );

        $data = array(
            'sales_id' => $sales->id,
            'expired_date' => date("Y-m-d", strtotime($request->input('expired_date'))),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pincode' => $request->input('pincode'),
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'website_link' => $request->input('website_link'),
            'status'    => $request->input('status'),
            'admin_commision'    => $request->input('admin_commision'),
            'updated_by' => Auth::user()->id,
            'business_name' => $request->input('business_name'),
            'tax_id' => $request->input('tax_id')
        );
        if ($files = $request->file('image')) {
            $path = 'public/images/suppliers';
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($path, $profileImage);
            $data['image'] = $profileImage;
        }

        Vendor::supplier()->where('id', $id)->update($data);

        /*if($request->input('status') == 'active'){
            $vendor_data = Vendor::supplier()->where('id',$id)->first();
            if($vendor_data->verification == 'no'){
                $email = $vendor_data->email;
                $name = $vendor_data->name;
                Mail::to($email)->send(new SupplierVerificationMail($email,$name));
                Vendor::supplier()->where('id',$id)->update(array('verification' => 'yes'));
            }
        }*/

        return redirect('/admin/supplier')->with('success', "Supplier has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     * @param Vendor $supplier
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(Vendor $supplier)
    {
        $supplier->delete();
        return redirect('/admin/supplier')->with('success', "Supplier has been deleted.");
    }

    public function addRole(Request $request, $id)
    {
        $vendor_roles = VendorRoles::where('vendor_id', $id)->get();
        return view('admin.suppliers.add_role', compact('id', 'vendor_roles'));
    }

    public function supplierAddRole(Request $request, $id)
    {

        $slug = Str::slug($request->role_name);
        $request->validate([
            'role_name' => [
                'required',
                Rule::unique('vendor_roles')->where(function ($query) use ($slug, $id) {
                    return $query->where('slug', $slug)
                        ->where('vendor_id', $id);
                }),
            ],
        ], [
            'role_name.required' => 'The Role name is required.',
            'role_name.unique' => 'The Role name has already been taken.',
        ]);

        $vendor_role = new VendorRoles;
        $vendor_role->vendor_id = $id;
        $vendor_role->role_name = $request->role_name;
        $vendor_role->slug = $slug;
        $vendor_role->status = 'active';
        $vendor_role->seller_type = 'supplier';
        $vendor_role->created_by = Auth::user()->id;
        $vendor_role->updated_by = Auth::user()->id;
        $vendor_role->save();

        return redirect('/admin/supplier/add_role/' . $id)->with('success', "Supplier Role has been saved.");
    }

    public function paidModules(Request $request, $id)
    {
        if (empty($request->all())) {

            // $paid_modules = VendorPaidModule::where('vendor_id',$id)->where('status','yes')->get()->pluck('status', 'module_name');
            $paid_modules = VendorPaidModule::where('vendor_id', $id)->get();

            return view('admin.suppliers.paid_modules', compact('id', 'paid_modules'));
        } else {

            foreach ($request->except('_token') as $key => $value) {

                $vendor_paid = VendorPaidModule::where('vendor_id', $id)->where('module_name', $key)->exists();
                if ($vendor_paid) {
                    $vendor_paid_module = VendorPaidModule::where('vendor_id', $id)->where('module_name', $key)->first();
                } else {

                    $vendor_paid_module = new VendorPaidModule;
                }

                $vendor_paid_module->vendor_id = $id;
                $vendor_paid_module->module_name = $key;
                $vendor_paid_module->status = $value;
                $vendor_paid_module->save();
            }
            return redirect('/admin/supplier')->with('success', "Supplier Module has been saved.");
        }
    }

    public function paidModulesCreate(Request $request, $id)
    {
        if (empty($request->all())) {
            //$paid_modules = VendorPaidModule::where('supplier_id',$id)->where('status','no')->get();
            return view('admin.suppliers.paid_modules_create', compact('id'/*,'paid_modules'*/));
        } else {
            /*$supplier_module_id =  VendorPaidModule::where('supplier_id',$id)->where('module_name',$request->module_name)->first();

            if(!empty($supplier_module_id)){
                $request->validate([
                    'to_date'=>'required',
                    'from_date'=>'required',
                    'status'=>'required',
                    //'module_name'=>'required|unique:supplier_paid_modules,module_name,' . $supplier_module_id->id,
                ]);

            }else{*/
            $request->validate([
                'to_date' => 'required',
                'from_date' => 'required',
                'status' => 'required',
                //'module_name'=>'required',
                'module_name' => [
                    'required',
                    Rule::unique('supplier_paid_modules')->where(function ($query) use ($id) {
                        $query->where('supplier_id', $id);
                    })
                ]
            ]);
            //}
            $paid_module_arr = supplier_paid_modules();

            $supplier_paid_module = new VendorPaidModule;
            $supplier_paid_module->supplier_id = $id;
            $supplier_paid_module->module_code = array_search($request->module_name, $paid_module_arr);
            $supplier_paid_module->module_name = $request->module_name;
            $supplier_paid_module->status = $request->status;
            $supplier_paid_module->start_date = $request->to_date;
            $supplier_paid_module->end_date = $request->from_date;
            $supplier_paid_module->save();

            return redirect('/admin/supplier/paid_modules/' . $id)->with('success', "Supplier Module has been saved.");
        }
    }

    public function paidModulesEdit(Request $request, $id)
    {
        $paid_modules = VendorPaidModule::where('id', $id)->first();
        if (empty($request->all())) {
            $paid_modules = VendorPaidModule::where('id', $id)->first();
            return view('admin.suppliers.paid_modules_edit', compact('id', 'paid_modules'));
        } else {
            $request->validate([
                'to_date' => 'required',
                'from_date' => 'required',
            ]);

            $data = array(
                'status' => $request->status,
                'start_date' => $request->to_date,
                'end_date' => $request->from_date
            );

            VendorPaidModule::where('id', $id)->update($data);
            return redirect('/admin/supplier/paid_modules/' . $paid_modules->supplier_id)->with('success', "Supplier Module has been updated.");
        }
    }

    public function editRole($id)
    {
        $supplier_edit_role = VendorRoles::where('id', $id)->first();
        // return redirect('/admin/supplier/add_role/'.$id)->with('success',"Supplier Role has been saved.");
        echo json_encode($supplier_edit_role);
    }

    public function updateRole(Request $request)
    {
        $slug = str_slug($request->role_name);
        $supplier_id = $request->supplier_id;
        $role_id = $request->role_id;
        $request->validate([
            // 'role_name'=>'required',
            //'page'=>'required|unique:customer_pages,slug,customer_id,'.$this->customerID,
            'role_name' => [
                'required',
                Rule::unique('vendor_roles')->where(function ($query) use ($supplier_id, $slug, $role_id) {
                    return $query->where('slug', $slug)
                        ->where('supplier_id', $supplier_id)
                        ->where('id', '<>', $role_id);
                }),
            ],
        ], [
            'role_name.required' => 'The Role Name field is required.',
            'role_name.unique' => 'The Role Name has already been taken.',
        ]);
        VendorRoles::where('id', $role_id)->update(array('role_name' => $request->role_name, 'slug' => $slug));
        return redirect('/admin/supplier/add_role/' . $supplier_id)->with('success', "Supplier Role has been updated.");
    }

    public function deleteRole($id)
    {
        $supplier_id  = VendorRoles::where('id', $id)->first();
        VendorRoles::where('id', $id)->delete();
        $data = array('role_id' => NULL);
        Supplier::where('role_id', $id)->update($data);
        return redirect('/admin/supplier/add_role/' . $supplier_id->supplier_id)->with('success', "Supplier Role has been deleted.");
    }

    public function otpSupplier(Request $request)
    {
        print_r($request->all());
        die();
    }

    public function importSupplier(Request $request)
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

            while (!feof($fileD)) {
                $rowData = fgetcsv($fileD);
                // print_r($rowData);
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
                    $expired_date = $rowData[10];
                    $membership = $rowData[11];
                    $admin_commision = $rowData[12];
                    $website_link = $rowData[13];
                    $status = $rowData[14];
                    $role = $rowData[15];
                    $images = $rowData[16];

                    $email_exists = Supplier::where('email', $email)->exists();
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
                        $membership_id = DB::table('memberships')->where(strtolower('name'), strtolower($membership))->first();

                        $roleData = VendorRoles::where(strtolower('role_name'), strtolower($role))
                            ->where('supplier_id', Auth::user()->id)
                            ->first();
                        if (empty($roleData)) {
                            $supplier_role = new VendorRoles;
                            $supplier_role->supplier_id = Auth::user()->id;
                            $supplier_role->role_name = $role;
                            $supplier_role->slug = str_slug($role);
                            $supplier_role->status = 'active';
                            $supplier_role->save();
                            $supplier_role_id = $supplier_role->id;
                        } else {
                            $supplier_role_id = $roleData->id;
                        }

                        // echo $supplier_role_id;
                        // die();
                        $supplier = new Vendor;
                        $supplier->name = $name;
                        $supplier->email = $email;
                        $supplier->parent_id = 0;
                        $supplier->password = bcrypt($password);
                        $supplier->phone_number = $phone_number;
                        $supplier->mobile_number = $mobile_number;
                        $supplier->address = $address;
                        $supplier->country = $countryID;
                        $supplier->state = $stateID;
                        $supplier->city = $cityID;
                        $supplier->pincode = $pincode;
                        $supplier->expired_date = $expired_date;
                        $supplier->membership_id = $membership_id->id;
                        $supplier->admin_commision = $admin_commision;
                        $supplier->website_link = $website_link;
                        $supplier->status = $status;
                        $supplier->role_id = $supplier_role_id;

                        //print_r($supplier->toArray());die();
                        if (trim(strtolower($images)) != '') {
                            // $images_arr = explode(',', $images);
                            $i = 1;

                            // foreach ($images_arr as $key => $value) {
                            // $i++;
                            $file1 = public_path('images/suppliers') . '/' . $images;
                            $farry1 = explode("/", $file1);
                            $filename1 = end($farry1);
                            $extesion1 = explode('.', $filename1);
                            $extesion1 = end($extesion1);
                            $path1 = public_path('images/suppliers');
                            $image1 = date('YmdHis') . '.' . $extesion1;
                            $new_image1 = $path1 . '/' . $image1;

                            /*$supplier['image'] = $image1;
                            copy($images, $new_image1);*/
                            if (!@copy($images, $new_image1)) {
                            } else {
                                $supplier['image'] = $image1;
                            }
                            // }
                        }
                        $supplier->save();
                    }
                }
            }

            return redirect('/admin/supplier')->with('success-data', array('emails' => $exists_emails, 'message' => 'Supplier successfully imported.'));
        } else {
            return redirect('/admin/supplier')->with('error-data', 'The import file must be a file of type: csv.');
        }
    }

    public function getImportPreview(Request $request)
    {
        // print_r($request->all());die();
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $data = [];
        if (strtolower($extension) == 'csv') {
            $fileD = fopen($request->file('file'), "r");
            $column = fgetcsv($fileD);
            $j = 1;
            while (!feof($fileD)) {
                $rowData = fgetcsv($fileD);

                if (!empty($rowData)) {
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

    public function exportSupplier()
    {
        $filename = "suppliers.csv";
        $fp = fopen('php://output', 'w');

        $header = array('Name', 'Email', 'Phone Number', 'Mobile Number', 'Address', 'City', 'State', 'Country', 'Zip Code', 'Store', 'Role', 'Image');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, $header);

        /*if(Auth::user()->parent_id == 0){
            $supplierID = Auth::user()->id;
        }else{
            $supplierID = Auth::user()->parent_id;
        }*/

        $suppliers = Supplier::select(
            'suppliers.*',
            'countries.name as country_name',
            'states.name as state_name',
            'cities.name as city_name',
            'supplier_stores.name as store_name',
            'vendor_roles.role_name'
        )
            ->leftjoin('vendor_roles', 'vendor_roles.id', 'suppliers.role_id')
            ->leftjoin('stores_suppliers', 'stores_suppliers.supplier_id', 'suppliers.id')
            ->leftjoin('supplier_stores', 'supplier_stores.id', 'stores_suppliers.store_id')
            ->leftjoin('countries', 'countries.id', 'suppliers.country')
            ->leftjoin('states', 'states.id', 'suppliers.state')
            ->leftjoin('cities', 'cities.id', 'suppliers.city')
            // ->where('suppliers.parent_id', $supplierID)
            ->groupBy('suppliers.id')
            ->get();

        $image_url = url('/');

        foreach ($suppliers as $key => $supplier) {

            if (!empty($supplier->image)) {
                $image = $image_url . '/public/images/suppliers/' . $supplier->image;
            } else {
                $image = '';
            }

            $data = array(
                'Name' => $supplier->name,
                'Email' => $supplier->email,
                'Phone Number' => $supplier->phone_number,
                'Mobile Number' => $supplier->mobile_number,
                'Address' => $supplier->address,
                'City' => $supplier->city_name,
                'State' => $supplier->state_name,
                'Country' => $supplier->country_name,
                'Zip Code' => $supplier->pincode,
                'Store' => $supplier->store_name,
                'Role' => $supplier->role_name,
                'Image' => $image
            );

            fputcsv($fp, $data);
        }
        exit();
    }
}
