<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PushNotification;
use App\User;
use App\Vendor;
use App\UserDevice;
use App\UserNotification;
use Auth;
use App\Traits\Permission;

class UserNotificationController extends Controller
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
	public function index()
    {
    	return view('admin.push_notifications.view');
    }
	public function view(request $request)
    {
    	$columns = array( 
			0 => 'title',
			1 => 'user',
			2 => 'is_send',
			3 => 'is_read',
			4 => 'date'
		);
		$totalData = UserNotification::select('users.first_name', 'users.last_name', 'user_notifications.title', 'user_notifications.is_send', 'user_notifications.is_read', 'user_notifications.created_at')
        	->join('users','users.id','user_notifications.user_id')
        	->orderBy('user_notifications.id', 'desc')
            ->get()
            ->count();

        $totalFiltered = $totalData; 

		$limit = $request->input('length');
		$start = $request->input('start');
		$order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');


		if(empty($request->input('search.value'))){
			
			$products = UserNotification::select('users.first_name', 'users.last_name', 'user_notifications.title', 'user_notifications.is_send', 'user_notifications.is_read', 'user_notifications.created_at')
	        	->join('users','users.id','user_notifications.user_id')
	        	->orderBy('user_notifications.id', 'desc')
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

		}else{

			$search = $request->input('search.value'); 

           
			$products = UserNotification::select('users.first_name', 'users.last_name', 'user_notifications.title', 'user_notifications.is_send', 'user_notifications.is_read', 'user_notifications.created_at')
	        	->join('users','users.id','user_notifications.user_id')
	        	->orderBy('user_notifications.id', 'desc');

	        	$products = $products->where(function($query) use ($search){
				$query->where('user_notifications.title', 'LIKE',"%{$search}%")
					->orWhere('users.first_name', 'LIKE',"%{$search}%")
					->orWhere('users.last_name', 'LIKE',"%{$search}%");
					//->orWhereRaw("GROUP_CONCAT(attribute_values.name) LIKE ". "%{$search}%");
			});
			//$products = $products->orHavingRaw('Find_In_Set("'.$search.'", attribute_value_names) > 0');

			$totalFiltered = $products; 
			$totalFiltered = $totalFiltered->get()->count(); 

			$products = $products->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();
		}
      
        $data = array();
		if($products->isNotEmpty())
		{	
			foreach ($products as $key => $product)
			{

				$nestedData['title'] = $product->title;
				$nestedData['user'] = $product->first_name;
				$nestedData['is_send'] = ($product->is_send ==0 ? 'no' : 'yes');
				$nestedData['is_read'] = ($product->is_read ==0 ? 'no' : 'yes');
				$nestedData['date'] = date('d-m-Y H:i:s:a',strtotime($product->created_at));
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
}