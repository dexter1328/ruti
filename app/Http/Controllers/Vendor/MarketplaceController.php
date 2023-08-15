<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketplaceController extends Controller
{
    private $stripe_secret;
    private $stripe_key;

	public function __construct()
	{
		$this->middleware('auth:vendor');
		// $this->middleware(function ($request, $next) {
		// 	if(!$this->hasVendorPermission(Auth::user())){
		// 		return redirect('vendor/home');
		// 	}
		// 	return $next($request);
		// });
        $this->stripe_secret = config('services.stripe.secret');
        $this->stripe_key = config('services.stripe.key');
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
		$totalData = Vendor::whereNotIn('id',[1])
				->where('parent_id','=',Auth::user()->id)->count();

        $totalFiltered = $totalData;

		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');


		if(empty($request->input('search.value'))){

			$vendors = Vendor::leftjoin('vendor_roles','vendor_roles.id','vendors.role_id')
				->select('vendors.name', 'vendors.pincode', 'vendors.mobile_number', 'vendors.email', 'vendors.id','vendors.status','vendors.parent_id','vendor_roles.role_name')
				->whereNotIn('vendors.id',[1])
				->where('vendors.parent_id','=',Auth::user()->id)
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

		}else{

			$search = $request->input('search.value');


			$vendors = Vendor::leftjoin('vendor_roles','vendor_roles.id','vendors.role_id')
				->select('vendors.name', 'vendors.pincode', 'vendors.mobile_number', 'vendors.email', 'vendors.id','vendors.status','vendors.parent_id','vendor_roles.role_name')
				->whereNotIn('vendors.id',[1])
				->where('vendors.parent_id','=',Auth::user()->id);

	        	$vendors = $vendors->where(function($query) use ($search){
				$query->where('vendors.name', 'LIKE',"%{$search}%")
					->orWhere('vendors.pincode', 'LIKE',"%{$search}%")
					->orWhere('vendors.email', 'LIKE',"%{$search}%")
					->orWhere('vendors.mobile_number', 'LIKE',"%{$search}%")
					->orWhere('vendor_roles.role_name', 'LIKE',"%{$search}%");
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

				// $url = "{{ url('/vendor/vendors/set-store-permission') }}/{{$vendor->id}}";
				$url = "vendors/set-store-permission/".$vendor->id;

				$nestedData['name'] = $vendor->name;
				$nestedData['pincode'] = $vendor->pincode;
				$nestedData['phone_no'] = $vendor->mobile_number;
				$nestedData['email'] = $vendor->email;
				$nestedData['role'] = ($vendor->role_name ? $vendor->role_name: '-');
				$nestedData['action'] = '<form id="deletefrm_'.$vendor->id.'" action="'.route('vendors.destroy', $vendor->id).'" method="POST" onsubmit="return confirm(\''.$cfm_msg.'\');">
											<input type="hidden" name="_token" value="'.csrf_token().'">
											<input type="hidden" name="_method" value="DELETE">
											<a href="'.route('vendors.edit', $vendor->id).'" data-toggle="tooltip" data-placement="bottom" title="Edit Vendor">
											<i class="icon-note icons"></i>
											</a>
											<a href="javascript:void(0);" onclick="deleteRow('.$vendor->id.')" data-toggle="tooltip" data-placement="bottom" title="Delete Vendor">
												<i class="icon-trash icons"></i>
											</a>

											<a href="'.$url.'">
									 			<i class="icon-basket-loaded icons" data-toggle="tooltip" data-placement="bottom" title="Set Store Permission"></i>
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



    public function marketplacePage()
    {
        // dd('123');
        return view('vendor.marketplace.index');
    }
}
