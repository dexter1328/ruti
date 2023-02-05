<?php

namespace App\Http\Controllers\API\Vendor;

use DB;
use Validator;
use App\User;
use App\VendorStore;
use App\StoresVendor;
use App\Orders;
use App\OrderItems;
use App\SupportTicket;
use App\Vendor;
use App\ProductImages;
use App\VendorCoupons;
use App\VendorRoles;
use App\UserNotification;
use App\ActiveUser;
use App\UserDevice;
use App\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\AppNotification;
use App\Http\Controllers\API\BaseController as BaseController;

class ShopController extends BaseController
{
    use AppNotification;

    public function getStore(Request $request, $id)
    {
        $store = [];

        $storeData = StoresVendor::select('vendor_stores.id',
                            'vendor_stores.name',
                            'vendor_stores.email',
                            'vendor_stores.branch_admin',
                            'vendor_stores.phone_number',
                            'vendor_stores.open_status',
                            'vendor_stores.image'
                        )
                        ->join('vendor_stores','vendor_stores.id','stores_vendors.store_id')
                        ->where('stores_vendors.vendor_id',$id)
                        ->get();

        if($storeData->isNotEmpty()){
            foreach ($storeData as $key => $value) {
                $store[] = array('store_id' =>  $value->id,
                            'name' =>  $value->name,
                            'branch_admin' =>$value->branch_admin,
                            'phone_number' =>$value->phone_number,
                            'email' =>$value->email,
                            'current_status' =>$value->open_status,
                            'image' => ($value->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$value->image))
                        );
            }
        }
        
        return $this->sendResponse($store,'Data retrieved successfully');
    }

    public function dashboard(Request $request, $id)
    {
        $start_timestamp = $request->start_date;
        $start_date = date('Y-m-d H:i:s', $start_timestamp);
            // $end_date = date('Y-m-d H:i:s',$request->end_date);


        $end_timestamp = $request->end_date;
        $end_date = date('Y-m-d H:i:s', $end_timestamp);

        

        // $start_date = date('Y-m-d H:i:s', $request->start_date);

        // $end_date = date('Y-m-d H:i:s',$request->end_date);

        $earnings = Orders::where('store_id',$id)->where('order_status','completed');

        if($request->start_date && $request->end_date)
        {
            $earnings = $earnings->whereRaw('DATE(created_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(created_at) <= "'.$end_date.'"');
        }

        $earnings = $earnings->sum('total_price');

        $checkout = Orders::where('store_id',$id)
                                ->where('order_status','completed');
                                

        if($request->start_date && $request->end_date)
        {
            $checkout = $checkout->whereRaw('DATE(updated_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(updated_at) <= "'.$end_date.'"');
        }

        $checkout = $checkout->count();

        $take_away_list_count = Orders::where('store_id',$id)
                                    ->where('type','pickup')
                                    ->where('order_status','!=','completed')
                                    ->where('order_status','!=','on_hold')
                                    ->where('order_status','!=','cancelled');
                                   
        if($request->start_date && $request->end_date)
        {
           
            $take_away_list_count = $take_away_list_count->whereRaw('DATE(created_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(created_at) <= "'.$end_date.'"');
        }

        $take_away_list_count = $take_away_list_count->count();

        $activeUser = ActiveUser::where('store_id',$id);


        if($request->start_date && $request->end_date)
        {
            $activeUser = $activeUser->whereRaw('DATE(created_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(created_at) <= "'.$end_date.'"');
        }

        $activeUser = $activeUser->count();

        $return_order = OrderItems::join('orders','orders.id','order_items.order_id')
                            ->where('order_items.status','return')
                            ->where('orders.store_id',$id);
                          
        if($request->start_date && $request->end_date)
        {
            $return_order = $return_order->whereRaw('DATE(orders.created_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(orders.created_at) <= "'.$end_date.'"');
        }

        $return_order = $return_order->count();

        $cancel_order = Orders::where('store_id',$id)->where('order_status','cancelled');
        if($request->start_date && $request->end_date)
        {
            $cancel_order = $cancel_order->whereRaw('DATE(created_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(created_at) <= "'.$end_date.'"');
        }

        $cancel_order = $cancel_order->count();

        $total_earnings = array("key" => 'earnings', "value" => $earnings);
        $successfully_checkout = array("key" => 'checkout', "value" => $checkout);
        $total_return_order = array("key" => 'return_order', "value" => $return_order);
        $total_cancel_order = array("key" => 'cancel_order', "value" => $cancel_order);
        $take_away_list = array("key" => 'take_away_list', "value" => $take_away_list_count);
        $active_user = array("key" => 'active_user', "value" => $activeUser);

        $data = array($total_earnings,$successfully_checkout,$total_return_order,$total_cancel_order,$take_away_list,$active_user);

        return $this->sendResponse($data,'Data retrieved successfully');
    }

    public function takeAwayList($id, Request $request)
    {
        $data = [];
        $orders = Orders::select('orders.id',
                            'orders.order_no',
                            'orders.type',
                            'orders.total_price',
                            'orders.pickup_date',
                            'orders.pickup_time',
                            'orders.created_at',
                            'orders.order_status',
                            'users.first_name',
                            'users.last_name',
                            'users.email',
                            'users.image',
                            'orders.customer_id'
                        )
                    ->join('users','users.id','orders.customer_id')
                    ->where('store_id',$id)
                    ->where('type','pickup')
                    ->where('order_status','!=','completed')
                    ->where('order_status','!=','on_hold')
                    ->where('order_status','!=','cancelled');

        if($request->start_date && $request->end_date){
            // $start_date = date('Y-m-d H:i:s', $request->start_date);
            $start_timestamp = $request->start_date;
            $start_date = date('Y-m-d H:i:s', $start_timestamp);
                // $end_date = date('Y-m-d H:i:s',$request->end_date);
            

            $end_timestamp = $request->end_date;
            $end_date = date('Y-m-d H:i:s', $end_timestamp);
       
            $orders = $orders->whereRaw('DATE(orders.created_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(orders.created_at) <= "'.$end_date.'"');
        }
        $orders = $orders->orderBy('id','DESC')->paginate(10);

        if($orders->isNotEmpty()){
            $current_page = $orders->currentPage();
            $total_pages  = $orders->lastPage();    
            foreach ($orders as $key => $order) {

                $customer = array('id'=>$order->customer_id,
                    'first_name' => $order->first_name,
                    'last_name'=> $order->last_name,
                    'email' => $order->email,
                    'image' => ($order->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$order->image))
                    );

                $order_item_count = OrderItems::where('order_id',$order->id)->count();

                $data[] = array('id' => $order->id,
                        'order_no' => $order->order_no,
                        'order_place_on' => 1000 * strtotime($order->created_at),
                        'total' => (float)$order->total_price,
                        'status' =>$order->order_status,
                        'type' => $order->type,
                        'items_count' =>$order_item_count,
                        'pickup' => 1000 * strtotime($order->pickup_date.' '.$order->pickup_time),
                        'customer' => $customer
                    ); 

            }
            return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'take_away_list'=>$data),'Data retrieved successfully');
        }
        else{
            return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'take_away_list'=>$data),'Data retrieved successfully');
        }
    }

    public function takeAwayDetail($id)
    {
        $order = Orders::find($id);

        if($order == null)
        {
            $success = [];
            return $this->sendResponse($success,'Not Found');

        }else{
            $users = User::where('id',$order->customer_id)->first();

            $user  = array('name' => $users->first_name.' '.$users->last_name,
                    'email' => $users->email,
                    'mobile' => $users->mobile,
                    'image' => ($users->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$users->image))
                );
            $order_items = OrderItems::select('order_items.*',
                                        'products.title',
                                        'products.store_id as store',
                                        'product_variants.attribute_value_id'
                                    )
                            ->join('product_variants', 'order_items.product_variant_id', 'product_variants.id')
                            ->join('products', 'product_variants.product_id', 'products.id')
                            ->where('order_items.order_id', $order->id)
                            ->get();

            $products = [];

            foreach ($order_items as $order_item) {
                
                $title = $order_item->title;

                $image = [];
                $product_images = ProductImages::where('variant_id',$order_item->product_variant_id)->get();

                foreach ($product_images as $product_image) {
                    $image[] = asset('public/images/product_images/'.$product_image->image);
                }

                $products[] = array('id' => $order_item->product_variant_id,
                    'title' => $title,
                    'price' => (float)$order_item->price,
                    'quantity' => $order_item->quantity,
                    'image' => $image
                );
            }

            if($order->type == 'pickup'){
                $pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);
            }else{
                $pickup = null;
            }

            $vendor_store = VendorStore::where('id',$order_item->store)->first();
            
            $store = array('store_id' => $vendor_store['id'],
                    'name' => $vendor_store['name'],
                    'branch_admin' => $vendor_store['branch_admin'],
                    'phone_number' => $vendor_store['phone_number'],
                    'email' => $vendor_store['email'],
                    'current_status' => $vendor_store['open_status'],
                    'image' => ($vendor_store['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store['image']))
                );

            $coupon = [];

            if($order->coupan_id!='' && $order->coupan_id!=Null){

                $coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();

                $coupon = array('id' => $coupon_data->id,
                        'coupon_code' => $coupon_data->coupon_code,
                        'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
                        'title' => $coupon_data->discount.' % off',
                        'discount' => $coupon_data->discount,
                        'description' => $coupon_data->description,
                        'start_date' => 1000 * strtotime($coupon_data->start_date),
                        'end_date' => 1000 * strtotime($coupon_data->end_date)
                    );
            }

            $success = array( 'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'placed_on' => 1000 * strtotime($order->created_at),
                    'type' => $order->type,
                    'status' =>$order->order_status,
                    'pickup_date_time' => $pickup,
                    'items_total'=>$order->item_total,
                    'promo_code' => $order->promo_code,
                    'tax'=> (float)$order->tax,
                    'grand_total' => (float)$order->total_price,
                    'user'=>$user,
                    'coupan_code' => $coupon,
                    'product' => $products,
                    'store' => $store
                );

            return $this->sendResponse($success,'Data retrieved successfully');
        }
    }

    public function createTicket(Request $request, $id){

        $ticket_no =  rand(100000, 999999);
        $vendor = Vendor::where('id',$id)->first();
        
        $support_ticket = new SupportTicket;
        $support_ticket->user_id = $id;
        $support_ticket->user_type = $request->user_type;
        $support_ticket->subject = $request->subject;
        $support_ticket->message = $request->message;
        $support_ticket->parent_id = $vendor->parent_id;
        $support_ticket->ticket_no = $ticket_no;
        $support_ticket->generated_by = 'vendor';
        $support_ticket->save();

        if($vendor->parent_id != 0 && $vendor->parent_id != ''){

            $id = $ticket_no;
            $type = 'support_ticket';
            $title = 'New Ticket: #'.$ticket_no;
            $message = $request->message;
            $devices = UserDevice::whereIn('user_id',$support_ticket->parent_id)->where('user_type','vendor')->get();
                                
            $this->sendNotification($title, $message, $devices, $type, $id);
        }
      
        if($support_ticket)
        {
            $data = array('user_id'=>(int)$support_ticket->user_id,
                    'user_type'=>$support_ticket->user_type,
                    'subject'=>$support_ticket->subject,
                    'message'=>$support_ticket->message,
                    'ticket_no'=>$support_ticket->ticket_no,
                    'created_at' => 1000 * strtotime($support_ticket->created_at)
                );
            return $this->sendResponse($data,'Your ticket has been created successfully.');
        }
    }

    public function SupportTicketList($id)
    {
        $support_tickets = SupportTicket::where('user_id',$id)
                            ->orWhere('parent_id',$id)
                            ->where('generated_by','vendor')
                            ->orderBy('created_at','desc')
                            ->paginate(10);
        $data = [];
        if($support_tickets->isNotEmpty())
        {   
            $current_page = $support_tickets->currentPage();
            $total_pages  = $support_tickets->lastPage();   

            foreach($support_tickets as $support_ticket)
            {
                $data[] = array('user_id'=>$support_ticket->user_id,
                    'user_type' => $support_ticket->user_type,
                    'subject' => $support_ticket->subject,
                    'message' => $support_ticket->message,
                    'ticket_no' => (int)$support_ticket->ticket_no,
                    'created_at' => 1000 * strtotime($support_ticket->created_at)
                );
      
            }
            return $this->sendResponse(array('page'=>$current_page,'totalPage'=>$total_pages,'tickets'=>$data),'Data retrieved successfully');
        }
        else
        {
            return $this->sendResponse(array('page'=>1,'totalPage'=>1,'tickets'=>$data),'Data retrieved successfully');
        }
    }

    public function StoreSupportTicketList($id)
    {
        $support_tickets = SupportTicket::where('store_id',$id)
                                ->orderBy('created_at','desc')
                                ->paginate(10);
        $data = [];
        if($support_tickets->isNotEmpty())
        {   
            $current_page = $support_tickets->currentPage();
            $total_pages  = $support_tickets->lastPage();   

            foreach($support_tickets as $support_ticket)
            {
                $data[] = array('user_id'=>$support_ticket->user_id,
                    'user_type' => $support_ticket->user_type,
                    'subject' => $support_ticket->subject,
                    'message' => $support_ticket->message,
                    'ticket_no' => (int)$support_ticket->ticket_no,
                    'created_at' => 1000 * strtotime($support_ticket->created_at)
                );
      
            }
            return $this->sendResponse(array('page'=>$current_page,'totalPage'=>$total_pages,'tickets'=>$data),'Data retrieved successfully');
        }
        else
        {
            return $this->sendResponse(array('page'=>1,'totalPage'=>1,'tickets'=>$data),'Data retrieved successfully');
        }
    }

    public function checkoutUserList($id, Request $request)
    {
        $orders = Orders::select('orders.id',
                        'orders.order_no',
                        'orders.created_at',
                        'orders.type',
                        'orders.pickup_date',
                        'orders.pickup_time',
                        'orders.coupan_id',
                        'orders.total_price',
                        'orders.item_total',
                        'orders.promo_code',
                        'orders.tax',
                        'orders.updated_at',
                        'users.first_name',
                        'users.last_name',
                        'users.image as user_img',
                        'users.email',
                        'users.mobile',
                        'vendor_stores.id as store_id',
                        'vendor_stores.name',
                        'vendor_stores.branch_admin',
                        'vendor_stores.phone_number',
                        'vendor_stores.email',
                        'vendor_stores.open_status',
                        'vendor_stores.image'
                    )
                    ->join('vendor_stores','vendor_stores.id','=','orders.store_id')
                    ->join('users','users.id','orders.customer_id')
                    ->where('orders.order_status','completed')
                    ->where('orders.store_id',$id)
                    ->orderBy('orders.created_at', 'desc');

        if($request->start_date && $request->end_date){
            $start_date = date('Y-m-d H:i:s', $request->start_date);
            $end_date = date('Y-m-d H:i:s',$request->end_date);
            $orders = $orders->whereBetween(DB::raw('DATE(orders.updated_at)'), [$start_date, $end_date]);
        }
        $orders = $orders->paginate(10);

        if($orders->isNotEmpty())
        {
            $current_page = $orders->currentPage();
            $total_pages  = $orders->lastPage();    

            foreach ($orders as $key => $order) {

                $user  = array('name' => $order['first_name'].' '.$order['last_name'],
                            'email' => $order['email'],
                            'mobile' => $order['mobile'],
                            'image' => ($order['user_img'] == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$order['user_img']))
                        );

                $store = array('store_id' => $order['store_id'],
                        'name' => $order['name'],
                        'branch_admin' => $order['branch_admin'],
                        'phone_number' => $order['phone_number'],
                        'email' => $order['email'],
                        'current_status' => $order['open_status'],
                        'image' => ($order['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$order['image']))
                    );

                if($order['type'] == 'pickup')
                {
                    $pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);

                }else{
                    
                    $pickup = null;
                }

                $coupon = [];

                if($order->coupan_id!='' && $order->coupan_id!=Null){

                    $coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();
                    $coupon = array('id' => $coupon_data->id,
                            'coupon_code' => $coupon_data->coupon_code,
                            'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
                            'title' => $coupon_data->discount.' % off',
                            'discount' => $coupon_data->discount,
                            'description' => $coupon_data->description,
                            'start_date' => 1000 * strtotime($coupon_data->start_date),
                            'end_date' => 1000 * strtotime($coupon_data->end_date)
                        );
                }

                $data[]= array('order_id' => $order['id'],
                        'order_no' => $order['order_no'],
                        'placed_on' => 1000 * strtotime($order['created_at']),
                        'type' => $order['type'],
                        'pickup_date_time' => $pickup ,
                        'items_total' => $order['item_total'],
                        'promo_code' => $order['promo_code'],
                        'tax' => (float)$order['tax'],
                        'grand_total' => (float)$order['total_price'],
                        'store' => $store,
                        'user' => $user,
                        'coupon' => $coupon
                    );
            }

            return $this->sendResponse(array('page'=>$current_page,'totalPage'=>$total_pages,'orders'=>$data),'Data retrieved successfully');
        }else{

            $data = [];
            return $this->sendResponse(array('page'=>1,'totalPage'=>1,'orders'=>$data),'Data retrieved successfully');
        }
    }

    public function checkoutOrderDetail($id)
    {
        $order = Orders::find($id);

        if($order == null)
        {
            $success = [];
            return $this->sendResponse($success,'Not Found');

        }else{

            $order_items = OrderItems::select('order_items.*',
                                        'products.title',
                                        'products.store_id as store',
                                        'product_variants.attribute_value_id'
                                    )
                            ->join('product_variants', 'order_items.product_variant_id', 'product_variants.id')
                            ->join('products', 'product_variants.product_id', 'products.id')
                            ->where('order_items.order_id', $order->id)
                            ->get();

            $products = [];

            foreach ($order_items as $order_item) {
                
                $title = $order_item->title;

                $image = [];
                $product_images = ProductImages::where('variant_id',$order_item->product_variant_id)->get();

                foreach ($product_images as $product_image) {
                    $image[] = asset('public/images/product_images/'.$product_image->image);
                }

                $products[] = array('id' => $order_item->product_variant_id,
                    'title' => $title,
                    'price' => (float)$order_item->price,
                    'quantity' => $order_item->quantity,
                    'return_reason' => $order_item->return_reason,
                    'additional_info' => $order_item->additional_info,
                    'image' => $image
                );
            }

            if($order->type == 'pickup'){
                $pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);
            }else{
                $pickup = null;
            }

            $vendor_store = VendorStore::where('id',$order->store_id)->first();
            $users = User::where('id',$order->customer_id)->first();

            $user  = array('name' => $users->first_name.' '.$users->last_name,
                    'email' => $users->email,
                    'mobile' => $users->mobile,
                    'image' => ($users->user_img == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$users->user_img))
                );

            $store = array('store_id' => $vendor_store['id'],
                        'name' => $vendor_store['name'],
                        'branch_admin' => $vendor_store['branch_admin'],
                        'phone_number' => $vendor_store['phone_number'],
                        'email' => $vendor_store['email'],
                        'current_status' => $vendor_store['open_status'],
                        'image' => ($vendor_store['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store['image']))
                    );

            $coupon = [];

            if($order->coupan_id!='' && $order->coupan_id!=Null){

                $coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();

                $coupon = array('id' => $coupon_data->id,
                            'coupon_code' => $coupon_data->coupon_code,
                            'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
                            'title' => $coupon_data->discount.' % off',
                            'discount' => $coupon_data->discount,
                            'description' => $coupon_data->description,
                            'start_date' => 1000 * strtotime($coupon_data->start_date),
                            'end_date' => 1000 * strtotime($coupon_data->end_date)
                        );
            }

            $success = array( 'order_id' => $order->id,
                        'order_no' => $order->order_no,
                        'order_status' => $order->order_status,
                        'placed_on' => 1000 * strtotime($order->created_at),
                        'type' => $order->type,
                        'pickup_date_time' => $pickup,
                        'items_total'=>$order->item_total,
                        'promo_code' => $order->promo_code,
                        'tax'=> (float)$order->tax,
                        'grand_total' => (float)$order->total_price,
                        'cancel_reason' => $order->cancel_reason,
                        'additional_info' => $order->additional_info,
                        'user' => $user,
                        'coupan_code' => $coupon,
                        'product' => $products,
                        'store' => $store
                    );

            return $this->sendResponse($success,'Data retrieved successfully');
        }
    }

    public function totalItemSold($id, Request $request)
    {
        $data = [];
        $orders = Orders::selectRaw('count(order_items.product_variant_id) as total_item,
                                order_items.product_variant_id,products.title,products.id as product_id,orders.updated_at,orders.id as order_id')
                    ->join('order_items','order_items.order_id','orders.id')
                    ->join('product_variants','product_variants.id','order_items.product_variant_id')
                    ->join('products','products.id','product_variants.product_id')
                    ->where('orders.store_id',$id)
                    ->where('orders.order_status','=','completed')
                    ->groupBy('order_items.product_variant_id');
                   

        if($request->start_date && $request->end_date){
            
            /*$start_date = date('Y-m-d H:i:s', $request->start_date);

            $end_date = date('Y-m-d H:i:s',$request->end_date);*/
            $start_timestamp = $request->start_date;
            $start_date = date('Y-m-d H:i:s', $start_timestamp);
            // $end_date = date('Y-m-d H:i:s',$request->end_date);


            $end_timestamp = $request->end_date;
            $end_date = date('Y-m-d H:i:s', $end_timestamp);
            $orders = $orders->whereRaw('DATE(orders.updated_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(orders.updated_at) <= "'.$end_date.'"');
        }
        $orders = $orders->paginate(10);
        // echo $start_date;echo'---';echo $end_date;
        
        if($orders->isNotEmpty()){

            $current_page = $orders->currentPage();
            $total_pages  = $orders->lastPage();    

            foreach ($orders as $key => $order) {

                $product_images = ProductImages::where('product_id',$order->product_id)->get();
                $image = [];
                foreach ($product_images as $key => $value) {
                    $image[] =($value['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$value['image']));
                }
                $data[] = array('product_id' => $order->product_id,
                    'variant_id' => $order->product_variant_id,
                    'title' => $order->title,
                    'total_item' => $order->total_item,
                    'images' => $image);
            }
            return $this->sendResponse(array('page'=>$current_page,'totalPage'=>$total_pages,'orders'=>$data),'Data retrieved successfully');
        }else{
            return $this->sendResponse(array('page'=>1,'totalPage'=>1,'orders'=>$data),'Data retrieved successfully');
        }
    }

    public function totalEarnings(Request $request, $id)
    {
        $start_timestamp = $request->start_date;
        $start_date = date('Y-m-d H:i:s', $start_timestamp);

        $end_timestamp = $request->end_date;
        $end_date = date('Y-m-d H:i:s', $end_timestamp);

       
        $orders = Orders::selectRaw('count(orders.id) as total_item,
                                    sum(orders.total_price) as total_earning')
                    ->where('orders.store_id',$id)
                    ->where('orders.order_status','completed');
        if($request->search_for == 'today')
        {
            $date = date('Y-m-d');

            $orders = $orders->whereRaw('DATE(orders.created_at) = "'.$date.'"');
        }
        if($request->search_for == 'current_week'){
            $monday = strtotime("last monday");
            $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
             
            $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
             
            $this_week_sd = date("Y-m-d",$monday);
            $this_week_ed = date("Y-m-d",$sunday);
            $orders = $orders->whereRaw('DATE(orders.created_at) >= "'.$this_week_sd.'"')
                ->whereRaw('DATE(orders.created_at) <= "'.$this_week_ed.'"');
        }
        if($request->search_for == 'current_month'){
            $first_day_this_month = date('Y-m-01');
            $last_day_this_month  = date('Y-m-t');
            $orders = $orders->whereRaw('DATE(orders.created_at) >= "'.$first_day_this_month.'"')
                ->whereRaw('DATE(orders.created_at) <= "'.$last_day_this_month.'"');
        }
        if($request->start_date && $request->end_date)
        {
            $orders = $orders->whereRaw('DATE(orders.created_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(orders.created_at) <= "'.$end_date.'"');
        }
        $orders = $orders->first();

        return $this->sendResponse($orders,'Data retrieved successfully');
    }

    // sub vendor

    public function getRoles()
    {   
        $vendor_roles = VendorRoles::select('id','role_name')->where('status','active')->get()->toArray();

        return $this->sendResponse($vendor_roles,'Data retrieved successfully');
    }

    public function activeUser(Request $request, $id)
    {
        $users = ActiveUser::select('users.first_name',
                'users.last_name',
                'users.email',
                'users.mobile',
                'users.image'
            )
            ->join('users','users.id','active_users.user_id')
            ->groupBy('users.id')
            ->where('active_users.store_id',$id);

        if($request->start_date && $request->end_date){
            $start_date = date('Y-m-d H:i:s', $request->start_date);
            $end_date = date('Y-m-d H:i:s',$request->end_date); 

            $users = $users->whereRaw('DATE(active_users.created_at) >= "'.$start_date.'"')
                ->whereRaw('DATE(active_users.created_at) <= "'.$end_date.'"');
        }
            $users = $users->paginate(10);
        $userData = [];
        
        if($users->isNotEmpty()){
            $current_page = $users->currentPage();
            $total_pages  = $users->lastPage();    
            foreach ($users as $key => $user) {

                $userData[]  = array('name' => $user->first_name.' '.$user->last_name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'image' => ($user->image == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$user->image))
                );
            }
            return $this->sendResponse(array('page'=>$current_page,'totalPage'=>$total_pages,'users'=>$userData),'Data retrieved successfully');
        }else{
            return $this->sendResponse(array('page'=>1,'totalPage'=>1,'users'=>$userData),'Data retrieved successfully');
        }
    }

    public function returnRequestOrderList($id, Request $request)
    {
        $orders = OrderItems::select('orders.id',
                'orders.order_no',
                'orders.type',
                'orders.total_price',
                'orders.pickup_date',
                'orders.pickup_time',
                'orders.created_at',
                'orders.order_status'
                )
            ->join('orders','orders.id','order_items.order_id')
            ->where('order_items.status','return_request')
            ->where('orders.store_id',$id);
        if($request->start_date && $request->end_date){
            $start_date = date('Y-m-d',strtotime($request->start_date));
            $end_date = date('Y-m-d',strtotime($request->end_date));
            $orders = $orders->whereBetween(DB::raw('DATE(updated_at)'), [$start_date, $end_date]);
        }

        $orders = $orders->paginate(10);

        if($orders->isNotEmpty()){
            $current_page = $orders->currentPage();
            $total_pages  = $orders->lastPage();    
            foreach ($orders as $key => $order) {

                $order_item_count = OrderItems::where('order_id',$order->id)->count();

                $data[] = array('id' => $order->id,
                        'order_no' => $order->order_no,
                        'order_place_on' => 1000 * strtotime($order->created_at),
                        'total' => (float)$order->total_price,
                        'status' =>$order->order_status,
                        'type' => $order->type,
                        'items_count' =>$order_item_count,
                        'pickup' => 1000 * strtotime($order->pickup_date.' '.$order->pickup_time)
                    ); 
            }
            return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'take_away_list'=>$data),'Return Order List.');
        }
        else{
            return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'take_away_list'=>$data),'Return Order List.');
        }
    }

    public function returnOrderList($id, Request $request)
    {
        $orders = OrderItems::select('orders.id',
                'orders.order_no',
                'orders.type',
                'order_items.price',
                'orders.pickup_date',
                'orders.pickup_time',
                'orders.created_at',
                'orders.order_status',
                'order_items.return_reason',
                'order_items.additional_comment'
                )
            ->join('orders','orders.id','order_items.order_id')
            ->where('orders.store_id',$id)
            ->where('order_items.status','return');

        if($request->start_date && $request->end_date){
            $start_date = date('Y-m-d H:i:s', $request->start_date);
            $end_date = date('Y-m-d H:i:s',$request->end_date);
            $orders = $orders->whereBetween(DB::raw('DATE(order_items.updated_at)'), [$start_date, $end_date]);
        }

        $orders = $orders->paginate(10);
        $data=[];
        if($orders->isNotEmpty()){
            $current_page = $orders->currentPage();
            $total_pages  = $orders->lastPage();    
            foreach ($orders as $key => $order) {

                $order_item_count = OrderItems::where('order_id',$order->id)->count();

                $data[] = array('id' => $order->id,
                        'order_no' => $order->order_no,
                        'order_place_on' => 1000 * strtotime($order->created_at),
                        'total' => (float)$order->price,
                        'status' =>$order->order_status,
                        'type' => $order->type,
                        'items_count' =>$order_item_count,
                        'pickup' => 1000 * strtotime($order->pickup_date.' '.$order->pickup_time),
                        'reason' => $order->return_reason,
                        'additional_comment' => $order->additional_comment
                    ); 

            }
            return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'take_away_list'=>$data),'Data retrieved successfully');
        }
        else{
            return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'take_away_list'=>$data),'Data retrieved successfully');
        }
    }

    public function returnOrderDetail($id)
    {
        $order = Orders::find($id);

        if($order == null)
        {
            $success = [];
            return $this->sendResponse($success,'Not Found');

        }else{

            $order_items = OrderItems::select('order_items.*',
                                        'products.title',
                                        'products.store_id as store',
                                        'product_variants.attribute_value_id'
                                    )
                            ->join('product_variants', 'order_items.product_variant_id', 'product_variants.id')
                            ->join('products', 'product_variants.product_id', 'products.id')
                            ->where('order_items.order_id', $order->id)
                            ->where('order_items.status','return')
                            ->get();

            $products = [];

            foreach ($order_items as $order_item) {
                
                $title = $order_item->title;

                $image = [];
                $product_images = ProductImages::where('variant_id',$order_item->product_variant_id)->get();

                foreach ($product_images as $product_image) {
                    $image[] = asset('public/images/product_images/'.$product_image->image);
                }

                $products[] = array('id' => $order_item->product_variant_id,
                    'title' => $title,
                    'price' => (float)$order_item->price,
                    'quantity' => $order_item->quantity,
                    'image' => $image
                );
            }

            if($order->type == 'pickup'){
                $pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);
            }else{
                $pickup = null;
            }

            $vendor_store = VendorStore::where('id',$order_item->store)->first();
            
            $store = array('store_id' => $vendor_store['id'],
                    'name' => $vendor_store['name'],
                    'branch_admin' => $vendor_store['branch_admin'],
                    'phone_number' => $vendor_store['phone_number'],
                    'email' => $vendor_store['email'],
                    'current_status' => $vendor_store['open_status'],
                    'image' => ($vendor_store['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store['image']))
                );

            $coupon = [];

            if($order->coupan_id!='' && $order->coupan_id!=Null){

                $coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();

                $coupon = array('id' => $coupon_data->id,
                        'coupon_code' => $coupon_data->coupon_code,
                        'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
                        'title' => $coupon_data->discount.' % off',
                        'discount' => $coupon_data->discount,
                        'description' => $coupon_data->description,
                        'start_date' => 1000 * strtotime($coupon_data->start_date),
                        'end_date' => 1000 * strtotime($coupon_data->end_date)
                    );
            }

            $success = array( 'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'placed_on' => 1000 * strtotime($order->created_at),
                    'type' => $order->type,
                    'status' =>$order->order_status,
                    'pickup_date_time' => $pickup,
                    'items_total'=>$order->item_total,
                    'promo_code' => $order->promo_code,
                    'tax'=> (float)$order->tax,
                    'grand_total' => (float)$order->total_price,
                    'coupan_code' => $coupon,
                    'product' => $products,
                    'store' => $store
                );

            return $this->sendResponse($success,'Order Data.');
        }
    }

    public function cancelOrderList($id, Request $request)
    {
        $data = [];
        $orders = Orders::select('id',
                            'order_no',
                            'type',
                            'total_price',
                            'pickup_date',
                            'pickup_time',
                            'created_at',
                            'order_status',
                            'cancel_reason',
                            'additional_comment')
                    ->where('store_id',$id)
                    ->where('type','pickup')
                    ->where('order_status','cancelled');

        if($request->start_date && $request->end_date){
            $start_date = date('Y-m-d H:i:s', $request->start_date);
            $end_date = date('Y-m-d H:i:s',$request->end_date);
            //$orders = $orders->whereBetween(DB::raw('DATE(updated_at)'), [$start_date, $end_date]);
            $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date]);
        }
        $orders = $orders->orderBy('id','DESC')->paginate(10);

        if($orders->isNotEmpty()){
            $current_page = $orders->currentPage();
            $total_pages  = $orders->lastPage();    
            foreach ($orders as $key => $order) {

                $order_item_count = OrderItems::where('order_id',$order->id)->count();

                $data[] = array('id' => $order->id,
                        'order_no' => $order->order_no,
                        'order_place_on' => 1000 * strtotime($order->created_at),
                        'total' => (float)$order->total_price,
                        'status' =>$order->order_status,
                        'type' => $order->type,
                        'items_count' =>$order_item_count,
                        'pickup' => 1000 * strtotime($order->pickup_date.' '.$order->pickup_time),
                        'reason' => $order->cancel_reason,
                        'additional_comment' => $order->additional_comment
                    ); 

            }
            return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'take_away_list'=>$data),'Data retrieved successfully');
        }
        else{
            return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'take_away_list'=>$data),'Data retrieved successfully');
        }
    }

    public function cancelOrderDetail($id)
    {
        $order = Orders::find($id);

        if($order == null)
        {
            $success = [];
            return $this->sendResponse($success,'Not Found');

        }else{

            $order_items = OrderItems::select('order_items.*',
                                        'products.title',
                                        'products.store_id as store',
                                        'product_variants.attribute_value_id'
                                    )
                            ->join('product_variants', 'order_items.product_variant_id', 'product_variants.id')
                            ->join('products', 'product_variants.product_id', 'products.id')
                            ->where('order_items.order_id', $order->id)
                            ->get();

            $products = [];

            foreach ($order_items as $order_item) {
                
                $title = $order_item->title;

                $image = [];
                $product_images = ProductImages::where('variant_id',$order_item->product_variant_id)->get();

                foreach ($product_images as $product_image) {
                    $image[] = asset('public/images/product_images/'.$product_image->image);
                }

                $products[] = array('id' => $order_item->product_variant_id,
                    'title' => $title,
                    'price' => (float)$order_item->price,
                    'quantity' => $order_item->quantity,
                    'image' => $image
                );
            }

            if($order->type == 'pickup'){
                $pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);
            }else{
                $pickup = null;
            }

            $vendor_store = VendorStore::where('id',$order_item->store)->first();
            
            $store = array('store_id' => $vendor_store['id'],
                    'name' => $vendor_store['name'],
                    'branch_admin' => $vendor_store['branch_admin'],
                    'phone_number' => $vendor_store['phone_number'],
                    'email' => $vendor_store['email'],
                    'current_status' => $vendor_store['open_status'],
                    'image' => ($vendor_store['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$vendor_store['image']))
                );

            $coupon = [];

            if($order->coupan_id!='' && $order->coupan_id!=Null){

                $coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();

                $coupon = array('id' => $coupon_data->id,
                        'coupon_code' => $coupon_data->coupon_code,
                        'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
                        'title' => $coupon_data->discount.' % off',
                        'discount' => $coupon_data->discount,
                        'description' => $coupon_data->description,
                        'start_date' => 1000 * strtotime($coupon_data->start_date),
                        'end_date' => 1000 * strtotime($coupon_data->end_date)
                    );
            }

            $success = array( 'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'placed_on' => 1000 * strtotime($order->created_at),
                    'type' => $order->type,
                    'status' =>$order->order_status,
                    'pickup_date_time' => $pickup,
                    'items_total'=>$order->item_total,
                    'promo_code' => $order->promo_code,
                    'tax'=> (float)$order->tax,
                    'grand_total' => (float)$order->total_price,
                    'coupan_code' => $coupon,
                    'product' => $products,
                    'store' => $store
                );

            return $this->sendResponse($success,'Order Data.');
        }
    }

    public function notificationList($id)
    {
        $notification_data = [];
        $user_notifications = UserNotification::where('user_id',$id)
                                // ->groupBy('title')
                                ->where('user_type','vendor')
                                ->orderBy('id','DESC')
                                ->paginate(10);
        
        if($user_notifications->isNotEmpty())
        {   
            $current_page = $user_notifications->currentPage();
            $total_pages  = $user_notifications->lastPage();

            foreach ($user_notifications as $key => $user_notification) {

                $notification_data[] = array(
                    'id' => $user_notification->id,
                    'title' => $user_notification->title,
                    'description' => $user_notification->description,
                    'date' => 1000 * strtotime($user_notification->created_at)
                );
            }
            return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'notifications'=>$notification_data),'Data retrieved successfully');       
        }else{
            return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'notifications'=>$notification_data),'We can\'t find proper data to display');
        }
    }

    public function unverifiedInshopOrderList($id)
    {
        $orders = Orders::select('orders.id',
                        'orders.order_no',
                        'orders.created_at',
                        'orders.type',
                        'orders.pickup_date',
                        'orders.pickup_time',
                        'orders.coupan_id',
                        'orders.total_price',
                        'orders.item_total',
                        'orders.promo_code',
                        'orders.tax',
                        'orders.is_verified',
                        'orders.updated_at',
                        'users.first_name',
                        'users.last_name',
                        'users.image as user_img',
                        'users.email',
                        'users.mobile',
                        'vendor_stores.id as store_id',
                        'vendor_stores.name',
                        'vendor_stores.branch_admin',
                        'vendor_stores.phone_number',
                        'vendor_stores.email',
                        'vendor_stores.open_status',
                        'vendor_stores.image'
                    )
                    ->join('vendor_stores','vendor_stores.id','=','orders.store_id')
                    ->join('users','users.id','orders.customer_id')
                    ->where('orders.store_id',$id)
                    ->where('orders.is_verified','no')
                    ->where('orders.type','inshop')
                    ->orderBy('orders.created_at', 'desc')
                    ->paginate(10);

        if($orders->isNotEmpty())
        {
            $current_page = $orders->currentPage();
            $total_pages  = $orders->lastPage();    

            foreach ($orders as $key => $order) {

                $order_items = OrderItems::select('order_items.*',
                                        'products.title',
                                        'products.store_id as store',
                                        'product_variants.attribute_value_id'
                                    )
                            ->join('product_variants', 'order_items.product_variant_id', 'product_variants.id')
                            ->join('products', 'product_variants.product_id', 'products.id')
                            ->where('order_items.order_id', $order->id)
                            ->get();

                $products = [];

                foreach ($order_items as $order_item) {
                    
                    $title = $order_item->title;

                    $image = [];
                    $product_images = ProductImages::where('variant_id',$order_item->product_variant_id)->get();

                    foreach ($product_images as $product_image) {
                        $image[] = asset('public/images/product_images/'.$product_image->image);
                    }

                    $products[] = array('id' => $order_item->product_variant_id,
                        'title' => $title,
                        'price' => (float)$order_item->price,
                        'quantity' => $order_item->quantity,
                        'image' => $image
                    );
                }



                $user  = array('name' => $order['first_name'].' '.$order['last_name'],
                            'email' => $order['email'],
                            'mobile' => $order['mobile'],
                            'image' => ($order['user_img'] == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$order['user_img']))
                        );

                $store = array('store_id' => $order['store_id'],
                        'name' => $order['name'],
                        'branch_admin' => $order['branch_admin'],
                        'phone_number' => $order['phone_number'],
                        'email' => $order['email'],
                        'current_status' => $order['open_status'],
                        'image' => ($order['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$order['image']))
                    );

                if($order['type'] == 'pickup')
                {
                    $pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);

                }else{
                    
                    $pickup = null;
                }

                $coupon = [];

                if($order->coupan_id!='' && $order->coupan_id!=Null){

                    $coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();
                    $coupon = array('id' => $coupon_data->id,
                            'coupon_code' => $coupon_data->coupon_code,
                            'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
                            'title' => $coupon_data->discount.' % off',
                            'discount' => $coupon_data->discount,
                            'description' => $coupon_data->description,
                            'start_date' => 1000 * strtotime($coupon_data->start_date),
                            'end_date' => 1000 * strtotime($coupon_data->end_date)
                        );
                }

                $data[]= array('order_id' => $order['id'],
                        'order_no' => $order['order_no'],
                        'placed_on' => 1000 * strtotime($order['created_at']),
                        'type' => $order['type'],
                        'pickup_date_time' => $pickup ,
                        'items_total' => $order['item_total'],
                        'promo_code' => $order['promo_code'],
                        'tax' => (float)$order['tax'],
                        'grand_total' => (float)$order['total_price'],
                        'is_verified' => $order['is_verified'],
                        'product' => $products,
                        'store' => $store,
                        'user' => $user,
                        'coupon' => $coupon
                    );
            }

            return $this->sendResponse(array('page'=>$current_page,'totalPage'=>$total_pages,'orders'=>$data),'Data retrieved successfully');
        }else{

            $data = [];
            return $this->sendResponse(array('page'=>1,'totalPage'=>1,'orders'=>$data),'Data retrieved successfully');
        }
    }

    public function inshopVerifiedOrder($id)
    {
        Orders::where('id',$id)->update(array('is_verified' => 'yes','order_status'=>'completed'));
        return $this->sendResponse(null,'Order has been verified successfully.');
    }

    public function broadCastDealListing(){
       
        $products = Products::selectRaw('max(product_variants.discount) as max_discount,categories.name,product_variants.discount,categories.id,product_variants.id as variant')
                ->join('categories','categories.id','products.category_id')
                ->join('product_variants','product_variants.product_id','products.id')
                ->groupBy('products.category_id')
                ->orderBy('max_discount','desc')
                ->get();
        
        $data = [];
        foreach($products as $product){
            $data[] = array('id' => $product->id,
                        'title' => $product->name.' up to '.$product->max_discount.'% off'
                    );
        }

        return $this->sendResponse($data,'Data retrieved successfully');
    }

    public function broadCastDealSend(Request $request, $id){

        $order = Orders::select('customer_id')->groupBy('customer_id')->where('store_id',$id)->get()->toArray();
        //customer notification
        $id = $id;
        $type = 'broadcast_deal';
        $title = 'Today\'s Special Deal';
        $message = $request->title;
        $devices = UserDevice::whereIn('user_id',$order)->where('user_type','customer')->get();
        $this->sendNotification($title, $message, $devices, $type, $id);

        return $this->sendResponse(null,'Deal broadcasted successfully');
    }

    public function pickupOrderList($id){

        $orders = Orders::select('orders.id',
                        'orders.order_no',
                        'orders.created_at',
                        'orders.type',
                        'orders.pickup_date',
                        'orders.pickup_time',
                        'orders.coupan_id',
                        'orders.total_price',
                        'orders.item_total',
                        'orders.promo_code',
                        'orders.tax',
                        'orders.is_verified',
                        'orders.updated_at',
                        'users.first_name',
                        'users.last_name',
                        'users.image as user_img',
                        'users.email',
                        'users.mobile',
                        'vendor_stores.id as store_id',
                        'vendor_stores.name',
                        'vendor_stores.branch_admin',
                        'vendor_stores.phone_number',
                        'vendor_stores.email',
                        'vendor_stores.open_status',
                        'vendor_stores.image'
                    )
                    ->join('vendor_stores','vendor_stores.id','=','orders.store_id')
                    ->join('users','users.id','orders.customer_id')
                    ->where('orders.store_id',$id)
                    ->where('orders.type','pickup')
                    ->where('orders.order_status','=','pending')
                    ->orderBy('orders.created_at', 'desc')
                    ->paginate(10);

        if($orders->isNotEmpty())
        {
            $current_page = $orders->currentPage();
            $total_pages  = $orders->lastPage();    

            foreach ($orders as $key => $order) {

                $order_items = OrderItems::select('order_items.*',
                                        'products.title',
                                        'products.store_id as store',
                                        'product_variants.attribute_value_id'
                                    )
                            ->join('product_variants', 'order_items.product_variant_id', 'product_variants.id')
                            ->join('products', 'product_variants.product_id', 'products.id')
                            ->where('order_items.order_id', $order->id)
                            ->get();

                $products = [];

                foreach ($order_items as $order_item) {
                    
                    $title = $order_item->title;

                    $image = [];
                    $product_images = ProductImages::where('variant_id',$order_item->product_variant_id)->get();

                    foreach ($product_images as $product_image) {
                        $image[] = asset('public/images/product_images/'.$product_image->image);
                    }

                    $products[] = array('id' => $order_item->product_variant_id,
                        'title' => $title,
                        'price' => (float)$order_item->price,
                        'quantity' => $order_item->quantity,
                        'image' => $image
                    );
                }



                $user  = array('name' => $order['first_name'].' '.$order['last_name'],
                            'email' => $order['email'],
                            'mobile' => $order['mobile'],
                            'image' => ($order['user_img'] == Null ? asset('public/images/User-Avatar.png') : asset('public/user_photo/'.$order['user_img']))
                        );

                $store = array('store_id' => $order['store_id'],
                        'name' => $order['name'],
                        'branch_admin' => $order['branch_admin'],
                        'phone_number' => $order['phone_number'],
                        'email' => $order['email'],
                        'current_status' => $order['open_status'],
                        'image' => ($order['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/stores/'.$order['image']))
                    );

                if($order['type'] == 'pickup')
                {
                    $pickup = 1000 * strtotime($order->pickup_date.' '.$order->pickup_time);

                }else{
                    
                    $pickup = null;
                }

                $coupon = [];

                if($order->coupan_id!='' && $order->coupan_id!=Null){

                    $coupon_data = VendorCoupons::where('id',$order->coupan_id)->first();
                    $coupon = array('id' => $coupon_data->id,
                            'coupon_code' => $coupon_data->coupon_code,
                            'image' => ($coupon_data->image == Null ? asset('public/images/no-image.jpg') : asset('public/images/vendors_coupan/'.$coupon_data->image)),
                            'title' => $coupon_data->discount.' % off',
                            'discount' => $coupon_data->discount,
                            'description' => $coupon_data->description,
                            'start_date' => 1000 * strtotime($coupon_data->start_date),
                            'end_date' => 1000 * strtotime($coupon_data->end_date)
                        );
                }

                $data[]= array('order_id' => $order['id'],
                        'order_no' => $order['order_no'],
                        'placed_on' => 1000 * strtotime($order['created_at']),
                        'type' => $order['type'],
                        'pickup_date_time' => $pickup ,
                        'items_total' => $order['item_total'],
                        'promo_code' => $order['promo_code'],
                        'tax' => (float)$order['tax'],
                        'grand_total' => (float)$order['total_price'],
                        'is_verified' => $order['is_verified'],
                        'product' => $products,
                        'store' => $store,
                        'user' => $user,
                        'coupon' => $coupon
                    );
            }

            return $this->sendResponse(array('page'=>$current_page,'totalPage'=>$total_pages,'orders'=>$data),'Order Data.');
        }else{

            $data = [];
            return $this->sendResponse(array('page'=>1,'totalPage'=>1,'orders'=>$data),'Order Data.');
        }
    }

    public function pickupOrderChangeStatus(Request $request, $id){

        if($request->status == 'ready_to_pickup'){
            Orders::where('id',$id)->update(array('order_status' => 'ready_to_pickup'));

            $order = Orders::where('id',$id)->first();
            $order_item_count = OrderItems::where('order_id',$order->id)->count();

            $data = array('id' => $order->id,
                    'order_no' => $order->order_no,
                    'order_place_on' => 1000 * strtotime($order->created_at),
                    'total' => (float)$order->total_price,
                    'status' =>$order->order_status,
                'type' => $order->type,
                    'items_count' =>$order_item_count,
                    'pickup' => 1000 * strtotime($order->pickup_date.' '.$order->pickup_time)
                ); 





            $id = $order->id;
            $type = 'order';
            $title = 'Ready for pickup';
            $message = 'Your order-'.$order->order_no.' is ready for pickup';
            $devices = UserDevice::where('user_id',$order->customer_id)->where('user_type','customer')->get();
            $this->sendNotification($title, $message, $devices, $type, $id);

            
        }elseif ($request->status == 'completed') {
            Orders::where('id',$id)->update(array('order_status' => 'completed'));                
        }
        return $this->sendResponse($data,'Change Succesfully.');
    }

    public function lowStockProduct($id, Request $request){

        $products =Products::select(
                'product_variants.id',
                'products.title as product',
                'products.id as product_id',
                'products.status',
                'categories.name as category',
                'brands.name as brand',
                //'vendor_stores.name',
                //'vendor_stores.branch_admin',
                //'vendor_stores.email',
                //'vendor_stores.phone_number',
                //'vendor_stores.open_status',
                //'vendor_stores.image',
                //'vendor_stores.id as store_id',
                'product_variants.price',
                'product_variants.discount',
                'product_variants.quantity'
            )
            //->join('vendor_stores','vendor_stores.id','=','products.store_id')
            ->join('categories','categories.id','=','products.category_id')
            ->join('brands','brands.id','=','products.brand_id')
            ->join('product_variants','product_variants.product_id','=','products.id')
            ->whereRaw('`product_variants`.`quantity` <= `product_variants`.`lowstock_threshold`')
            ->where('products.store_id', $id)
            ->paginate(10);
        

        if($products->isNotEmpty()){   


            $current_page = $products->currentPage();
            $total_pages  = $products->lastPage();   

            foreach ($products as $key => $value) {

                $image = [];
                $product_images = ProductImages::where('variant_id',$value['id'])->get();
                foreach ($product_images as $key) {

                    $image[] = array('image' => ($key['image'] == Null ? asset('public/images/no-image.jpg') : asset('public/images/product_images/'.$key['image'])) );
                }

                $success[] = array(
                    'id' => $value['id'],
                    'product_id' => $value['product_id'],
                    'name' => $value['product'],
                    'brand' => $value['brand'],
                    'price' => $value['price'],
                    'discount' => $value['discount'],
                    'quantity' => $value['quantity'],
                    'category' => $value['category'],
                    'status' => $value['status'],
                    //'wishlist' => $wishlist,
                    'image' => $image,
                    //'rating' => $rating
                );
            }
            return $this->sendResponse(array('page'=> $current_page,'totalPage'=>$total_pages,'products'=>$success),'Low stock product list.');
        }else{
           
            return $this->sendResponse(array('page'=> 1,'totalPage'=>1,'products'=>[]),'We can\'t find proper data to display');
        }
    }

    public function pickupOrderNotification($id)
    {
        // $customer_at = $request->location;
        $order = Orders::where('id',$id)->first();
        $id = $id;
        $type = 'order';
        $title = 'We are unable to locate you';
        $message = 'We are unable to locate you, Pick up order-'.$order->order_no.' at customer service desk or contact store manager';
        $devices = UserDevice::whereIn('user_id',[$order->customer_id])->where('user_type','customer')->get();
        $this->sendNotification($title, $message, $devices, $type, $id);
        // $this->sendVendorNotification($title, $message, $devices, $type, $id);
        return $this->sendResponse(null,'Notification Send to the customer.');
    }
    
    
}

