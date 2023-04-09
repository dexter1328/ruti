
<?php

use App\AdminRolePermission;
use App\VendorRolePermission;
use App\StoresVendor;
use App\VendorStore;
use App\VendorPaidModule;

if (!defined('SUPPLIER')){
    define("SUPPLIER", 'supplier');
}

if (!defined('VENDOR')){
    define("VENDOR", 'vendor');
}

if (!function_exists('admin_modules'))
{
    function admin_modules(): array
    {
        return array(
            'admins' => 'Admins',
            'admin_roles' => 'Admin Roles',
            'menus' => 'Menus',
            'pages' => 'Pages',
            'banners' => 'Banners',
            'galleries' => 'Galleries',
            'newsletters' => 'Newsletters',
            'push_notifications' => 'Push Notifications',
            'reward_points'=>'Reward Points',
            'membership'=>'Memberships',
            'checklist'=>'Checklist',
            'vendor'=>'Vendors',
            'vendor_store'=>'Vendor Stores',
            'vendor_configuration'=>'Vendor Configuration',
            'vendor_coupons'=>'Vendor Coupons',
            'vendor_coupons_used'=>'Vendor Used Coupons',
            'products'=>'Products',
            'categories'=>'Categories',
            'attributes'=>'Attributes',
            'brand'=>'Brand',
            'customer'=>'Customer',
            'customer_incentive'=>'Customer Incentive',
            'customer_feedback'=>'Customer Feedback',
            'customer_reviews'=>'Customer Reviews',
            'product_reviews'=>'Product Reviews',
            'customer_reward_points'=>'Customer Reward Points',
            'customer_used_reward_points'=>'Customer Used Reward Points',
            'orders'=>'Orders',
            'order_items'=>'Order Items',
            'order_return'=>'Order Return',
            'cancelled_orders'=>'Cancelled Orders',
            'support_ticket'=>'Support Ticket',
            'settings'=>'Setting',
            'discount_offers' =>'Discount Offers',
            'vendor_payment' => 'Vendor Payment',
            'notifications' => 'Notifications',
            'suggested_place' => 'Suggested Place',
            'order_reason' =>'Order Reason',
            'user_notification' => 'User Notification',
            'import_product' => 'Import Product',
            'customer_transaction' => 'Customer Transaction',
            'vendor_transaction' => 'Vendor Transaction',
            'login_history' => 'Login Activity',
            'supplier'=>'Suppliers',
            'supplier_store'=>'Supplier Stores',
            'supplier_configuration'=>'Supplier Configuration',
            'supplier_coupons'=>'Supplier Coupons',
            'supplier_coupons_used'=>'Supplier Used Coupons',
            'email_template' => 'Email Template'
        );
    }
}

if (!function_exists('vendor_modules'))
{
    function vendor_modules(): array
    {
        return array(
            'vendor_roles' => 'Vendor Roles',
            'vendors'=>'Vendors',
            'stores'=>'Stores',
            'vendor_configuration'=>'Vendor Configuration',
            'vendor_coupons'=>'Vendor Coupons',
            'vendor_coupons_used'=>'Vendor Used Coupons',
            'products'=>'Products',
            'product_reviews' => 'Product Reviews',
            'categories'=>'Categories',
            'attributes'=>'Attributes',
            'brand'=>'Brand',
            'discount_offers' => 'Discount Offers',
            'customer'=>'Customer',
            'customer_feedback'=>'Customer Feedback',
            'customer_reviews'=>'Customer Reviews',
            'customer_reward_points'=>'Customer Reward Points',
            'orders'=>'Orders',
            'order_return'=>'Order Return',
            'cancelled_orders'=>'Cancelled Orders',
            'import_product' => 'Import Product',
            'customer_transaction' => 'Customer Transaction',
            'settings'=>'Setting',
        );
    }
}

if (!function_exists('supplier_modules'))
{
    function supplier_modules(): array
    {
        return array(
            'supplier_roles' => 'Supplier Roles',
            'suppliers'=>'Suppliers',
            'supplier_configuration'=>'Supplier Configuration',
            // 'supplier_coupons'=>'Supplier Coupons',
            // 'supplier_coupons_used'=>'Supplier Used Coupons',
            'products'=>'Products',
            'product_reviews' => 'Product Reviews',
            'categories'=>'Categories',
            'brand'=>'Brand',
            'customer'=>'Customer',
            'customer_reviews'=>'Customer Reviews',
            'orders'=>'Orders',
//            'order_return'=>'Order Return',
            'cancelled_orders'=>'Cancelled Orders',
            'customer_transaction' => 'Customer Transaction',
            'settings'=>'Setting',
        );
    }
}

if (!function_exists('vendor_mobile_modules'))
{
    function vendor_mobile_modules(): array
    {
        return array(
            'mobile_analytics' =>'Analytics',
            'mobile_total_earnings' => 'Total Earnings',
            'mobile_order_transactions' =>'Order Transactions',
            'mobile_active_users' => 'Active Users',
            'mobile_share_deals' => 'Share Deals',
            'mobile_inventory_status' => 'Inventory Status',
            'mobile_verify_scan' => 'Verify & Scan'
        );
    }
}

if (!function_exists('getVendorStore'))
{
    function getVendorStore(): array
    {
        if(auth()->user()->parent_id == 0){
            $vendor_store = VendorStore::vendor()->select('id')->where('vendor_id',auth()->user()->id)->get();
            return Arr::pluck($vendor_store,'id');
        }else{
            $store_vendor = StoresVendor::select('store_id')->where('vendor_id',auth()->user()->id)->get();
            return Arr::pluck($store_vendor, 'store_id');
        }

    }
}

if (!function_exists('getSupplierStore'))
{
    function getSupplierStore(): array
    {
        if(auth()->user()->parent_id == 0){
            $vendor_store = VendorStore::supplier()->select('id')->where('vendor_id',auth()->user()->id)->get();
            return Arr::pluck($vendor_store,'id');
        }else{
            $store_vendor = StoresVendor::select('store_id')->where('vendor_id',auth()->user()->id)->get();
            return Arr::pluck($store_vendor, 'store_id');
        }

    }
}

if (!function_exists('getSeasons'))
{
    function getSeasons(): array
    {
        return array(
            'spring' => array(
                'title' => 'Spring',
                'months' => array('March', 'April', 'May')
            ),
            'summer'=> array(
                'title' => 'Summer',
                'months' => array('June', 'July', 'August')
            ),
            'fall' => array(
                'title' => 'Fall or Autumn',
                'months' => array('September', 'October', 'November')
            ),
            'winter' => array(
                'title' => 'Winter',
                'months' => array('December', 'January', 'February')
            ),
        );
    }
}

if (!function_exists('getCurrentSeason'))
{
    function getCurrentSeason($month)
    {
        $season = '';
        foreach (getSeasons() as $key => $value) {
            if(in_array($month, $value['months'])){
                $season = $key;
                break;
            }
        }
        if($season == ''){
            return false;
        }else{
            return $season;
        }
    }
}

function has_permission($role_id,$module,$permission): bool
{
    $role = AdminRolePermission::join('admin_roles','admin_roles.id','=','admin_role_permissions.role_id')
            ->where('admin_role_permissions.role_id',$role_id)
            ->where('admin_role_permissions.module_name',$module)
            ->where('admin_role_permissions.'.$permission,'yes')
            ->where('admin_roles.status','active')
            ->first();
    if((!empty($role) && $role->$permission=='yes') || Auth::user()->id == 1 ){
        return true;
    }else{
        return false;
    }
}


if (!function_exists('main_vendor_roles'))
{
    function main_vendor_roles(): array
    {
        return array(
            'administrator'     => 'Administrator',
            'store-manager'     =>'Store Manager',
            'store-supervisor'  =>'Store Supervisor',
            'store-security'    =>'Store Security',
            'store-floor-staff' =>'Store Floor Staff',
        );
    }
}

if (!function_exists('main_supplier_roles'))
{
    function main_supplier_roles(): array
    {
        return array(
            'administrator'     => 'Administrator',
            'store-manager'     =>'Store Manager',
            'store-supervisor'  =>'Store Supervisor',
            'store-security'    =>'Store Security',
            'store-floor-staff' =>'Store Floor Staff',
        );
    }
}

if (!function_exists('vendor_paid_modules'))
{
    function vendor_paid_modules(): array
    {
        return array(
            'newsletters' => 'Newsletters',
            // 'vendor_coupons'=>'Coupons',
            'customer_contact_info'=>'Customer Contact Info',
        );
    }
}

if (!function_exists('supplier_paid_modules'))
{
    function supplier_paid_modules(): array
    {
        return array(
            'newsletters' => 'Newsletters',
            // 'vendor_coupons'=>'Coupons',
            'customer_contact_info'=>'Customer Contact Info',
        );
    }
}

function vendor_has_permission($role_id,$module,$permission): bool
{
    $user = Auth::user();
    $paid_module_arr = vendor_paid_modules();
    if(array_key_exists($module,$paid_module_arr)){
        $paid_user_id = ($user->parent_id == 0 ? $user->id : $user->parent_id);
        $paid_vendor_module = DB::table('vendor_paid_modules')
                ->where('vendor_id',$paid_user_id)
                ->where('module_code',$module)
                ->whereDate('start_date', '>=', date('m/d/Y'))
                ->whereDate('end_date', '<=', date('m/d/Y'))
                ->first();
        if(empty($paid_vendor_module) || $paid_vendor_module->status == 'no' ){
            return false;
        }
    }

    $role = VendorRolePermission::join('vendor_roles','vendor_roles.id','=','vendor_role_permissions.role_id')
            ->where('vendor_role_permissions.role_id',$role_id)
            ->where('vendor_role_permissions.module_name',$module)
            ->where('vendor_role_permissions.'.$permission,'yes')
            ->where('vendor_roles.status','active')
            ->first();
    if((!empty($role) && $role->$permission=='yes') || Auth::user()->parent_id == 0 ){
        return true;
    }else{
        return false;
    }
}

function weekdays(): array
{
    return array(
        'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
    );
}

function vendor_store_hours(): DatePeriod
{
    $begin = new DateTime("0:00");
    $end   = new DateTime("24:00");

    $interval = DateInterval::createFromDateString('15 min');

    return new DatePeriod($begin, $interval, $end);
    // foreach ($times as $time) {
    //     echo '<option>'.$time->format('H:i').'</option>';

    // }
}

function vendor_newsletter_permission($id): bool
{
    $vendor_newsletter = VendorPaidModule::where('vendor_id',$id)->where('module_name','newsletter')->first();
    if(!empty($vendor_newsletter)){
        if($vendor_newsletter->status == 'yes'){
           return true;
        }else{
           return false;
        }
        // return true;
    }else{

        return false;
    }
}

function vendor_coupon_permission($id): bool
{
    $vendor_newsletter = VendorPaidModule::where('vendor_id',$id)->where('module_name','coupon')->first();
    if(!empty($vendor_newsletter)){
        if($vendor_newsletter->status == 'yes'){
           return true;
        }else{
           return false;
        }
        // return true;
    }else{

        return false;
    }
}

if (!function_exists('customer_membership_types'))
{
    function customer_membership_types(): array
    {
        return array(
            'explorer' => 'Explorer',
            'classic' => 'Classic',
            'bougie' => 'Bougie'
        );
    }
}

if (!function_exists('customer_membership_features'))
{
    function customer_membership_features(): array
    {
        return array(
            'support' => array(
                    'label' => 'Receive support',
                    'type' => 'select',
                    'values' => array('(6AM - 6PM)', '24 hours by 7 days a week')
                ),
            'customer_couponing' => array(
                    'label' => 'Direct to customer couponing',
                    'type' => 'select',
                    'values' => array('2 applicable/month', '10 applicable/month', 'Unlimited')
                ),
            'customer_couponing_habit' => array(
                    'label' => 'Receive relevant customer couponing based on habits',
                    'type' => 'checkbox',
                    'values' => array('Include')
                ),
            'product_discount' => array(
                    'label' => 'Receive product discount',
                    'type' => 'checkbox',
                    'values' => array('Include')
                ),
            'earn_reward_points' => array(
                    'label' => 'Earn reward points',
                    'type' => 'checkbox',
                    'values' => array('Include')
                ),
            'wallet_transfer' => array(
                    'label' => 'Wallet to wallet transfer',
                    'type' => 'select',
                    'values' => array('2% transaction fee', '1% transaction fee', 'No transaction fee')
                ),
            /*'delivery_services' => array(
                    'label' => 'Delivery services',
                    'type' => 'checkbox',
                    'values' => array('Include')
                ),*/
            /*'transaction_report' => array(
                    'label' => 'Transaction report',
                    'type' => 'checkbox',
                    'values' => array('Include')
                ),*/
            /*'communication_grocery_stores' => array(
                    'label' => 'Direct communication to grocery stores',
                    'type' => 'checkbox',
                    'values' => array('Include')
                ),*/
            /*'access_updates' => array(
                    'label' => 'Automatic access to updates',
                    'type' => 'checkbox',
                    'values' => array('Include')
                ),*/
        );
    }
}

if (!function_exists('vendor_membership_types'))
{
    function vendor_membership_types(): array
    {
        return array(
            'sprout' => 'Sprout',
            'blossom' => 'Blossom',
            'one_time_setup_fee' => 'One Time Setup Fee',
        );
    }
}

if (!function_exists('supplier_membership_types'))
{
    function supplier_membership_types(): array
    {
        return array(
            'seed' => 'Seed',
            'sprout1' => 'Sprout',
        );
    }
}

if (!function_exists('supplier_ruti_fullfill'))
{
    function supplier_ruti_fullfill(): array
    {
        return array(
            'ruti_fullfill' => 'Ruti fullfill',
        );
    }
}

if (!function_exists('vendor_membership_features'))
{
    function vendor_membership_features(): array
    {
        return array(
            'fund_transfer' => array(
                    'label' => 'Daily Funds Transfer',
                    'type' => 'checkbox',
                    'values' => array('Include')
                ),
            'support' => array(
                    'label' => 'Support',
                    'type' => 'select',
                    'values' => array('(6AM - 6PM)', '24 hours by 7 days a week')
                ),
            'customer_couponing' => array(
                    'label' => 'Direct to customer couponing',
                    'type' => 'select',
                    'values' => array('20 posts per month', '30 posts per month')
                ),
            'license' =>  array(
                    'label' => 'Member license Permission to download App',
                    'type' => 'array',
                    'values' => array(
                        'administrator' => array(
                            'label' => 'Administrator',
                            'type' => 'checkbox',
                            'values' => array('Include')
                        ),
                        'manager' => array(
                            'label' => 'Manager',
                            'type' => 'checkbox',
                            'values' => array('Include')
                        ),
                        'store_clerk' => array(
                            'label' => 'Store Clerk',
                            'type' => 'checkbox',
                            'values' => array('Include')
                        ),
                        'security_clerk' => array(
                            'label' => 'Security Clerk',
                            'type' => 'checkbox',
                            'values' => array('Include')
                        )
                    ),
                )
        );
    }
}

// if (!function_exists('supplier_membership_features'))
// {
//     function supplier_membership_features(): array
//     {
//         return array(
//             'fund_transfer' => array(
//                     'label' => 'Daily Funds Transfer',
//                     'type' => 'checkbox',
//                     'values' => array('Include')
//                 ),
//             'support' => array(
//                     'label' => 'Support',
//                     'type' => 'select',
//                     'values' => array('(6AM - 6PM)', '24 hours by 7 days a week')
//                 ),
//             'customer_couponing' => array(
//                     'label' => 'Direct to customer couponing',
//                     'type' => 'select',
//                     'values' => array('20 posts per month', '30 posts per month')
//                 ),
//             'license' =>  array(
//                     'label' => 'Member license Permission to download App',
//                     'type' => 'array',
//                     'values' => array(
//                         'administrator' => array(
//                             'label' => 'Administrator',
//                             'type' => 'checkbox',
//                             'values' => array('Include')
//                         ),
//                         'manager' => array(
//                             'label' => 'Manager',
//                             'type' => 'checkbox',
//                             'values' => array('Include')
//                         ),
//                         'store_clerk' => array(
//                             'label' => 'Store Clerk',
//                             'type' => 'checkbox',
//                             'values' => array('Include')
//                         ),
//                         'security_clerk' => array(
//                             'label' => 'Security Clerk',
//                             'type' => 'checkbox',
//                             'values' => array('Include')
//                         )
//                     ),
//                 )
//         );
//     }
// }

if (!function_exists('common_membership_coupons'))
{
    function common_membership_coupons(): array
    {
        /*$membership_coupons = array(
            'annual_pay_discount' => 'Annual Payment Discount'
        );*/
        $coupons = config('services.stripe.coupons');
        return array(
            $coupons[0] => 'GET30',
            $coupons[1] => 'DIS50',
            $coupons[2] => 'EXE70'
        );
    }
}

if (!function_exists('customer_incentives'))
{
    function customer_incentives(): array
    {
        /* $customer_incentives = array (
            0 => array (
                0 => 'TIER 1',
                1 => 'STORE PURCHASE (Minimum)',
                2 => 'Membership Status',
                3 => 'AMOUNT PURCHASE (Minimum)',
            ),
            1 => array (
                0 => 'Scholarship for college student',
                1 => 'TWICE A MONTH',
                2 => 'Bougie',
                3 => '$150',
            ),
            2 => array (
                0 => 'One week round trip to Europe',
                1 => 'TWICE A MONTH',
                2 => 'Bougie',
                3 => '$150',
            ),
            3 => array (
                0 => 'One week round trip to the Caribbean',
                1 => 'TWICE A MONTH',
                2 => 'Bougie',
                3 => '$150',
            ),
            4 => array (
                0 => 'TIER 2',
                1 => '',
                2 => '',
                3 => '',
            ),
            5 => array (
                0 => '2 Nights stay in 5 star hotel & resort',
                1 => 'TWICE A MONTH',
                2 => 'Classic',
                3 => '$100',
            ),
            6 => array (
                0 => 'Adventure parks tickets',
                1 => 'TWICE A MONTH',
                2 => 'Classic',
                3 => '$100',
            ),
            7 => array (
                0 => 'Theme parks tickets',
                1 => 'TWICE A MONTH',
                2 => 'Classic',
                3 => '$100',
            ),
            8 => array (
                0 => 'TIER 3',
                1 => '',
                2 => '',
                3 => '',
            ),
            9 => array (
                0 => '$300 gift cards',
                1 => 'TWICE A MONTH',
                2 => 'Explorer',
                3 => '$100',
            ),
            10 => array (
                0 => 'HP laptop',
                1 => 'TWICE A MONTH',
                2 => 'Explorer',
                3 => '$100',
            ),
            11 => array (
                0 => 'Tablets',
                1 => 'TWICE A MONTH',
                2 => 'Explorer',
                3 => '$100',
            )
        );*/
        return array (
            0 => array (
                'key' => 'TIER 1',
                'items' => array(
                    array(
                        'title' => 'Scholarship for college student',
                        'purchaseTimes' => 'TWICE A MONTH',
                        'plan' => 'Bougie',
                        'purchaseAmount' => '$150'
                    ),
                    array(
                        'title' => 'One week round trip to Europe',
                        'purchaseTimes' => 'TWICE A MONTH',
                        'plan' => 'Bougie',
                        'purchaseAmount' => '$150'
                    ),
                    array(
                        'title' => 'One week round trip to the Caribbean',
                        'purchaseTimes' => 'TWICE A MONTH',
                        'plan' => 'Bougie',
                        'purchaseAmount' => '$150'
                    )
                ),
            ),
            1 => array (
                'key' => 'TIER 2',
                'items' => array(
                    array(
                        'title' => '2 Nights stay in 5 star hotel & resort',
                        'purchaseTimes' => 'TWICE A MONTH',
                        'plan' => 'Classic',
                        'purchaseAmount' => '$100'
                    ),
                    array(
                        'title' => 'Adventure parks tickets',
                        'purchaseTimes' => 'TWICE A MONTH',
                        'plan' => 'Classic',
                        'purchaseAmount' => '$100'
                    ),
                    array(
                        'title' => 'Theme parks tickets',
                        'purchaseTimes' => 'TWICE A MONTH',
                        'plan' => 'Classic',
                        'purchaseAmount' => '$100'
                    )
                ),
            ),
            2 => array (
                'key' => 'TIER 3',
                'items' => array(
                    array(
                        'title' => '$300 gift cards',
                        'purchaseTimes' => 'TWICE A MONTH',
                        'plan' => 'Explorer',
                        'purchaseAmount' => '$100'
                    ),
                    array(
                        'title' => 'HP laptop',
                        'purchaseTimes' => 'TWICE A MONTH',
                        'plan' => 'Explorer',
                        'purchaseAmount' => '$100'
                    ),
                    array(
                        'title' => 'Tablets',
                        'purchaseTimes' => 'TWICE A MONTH',
                        'plan' => 'Explorer',
                        'purchaseAmount' => '$100'
                    )
                ),
            )
        );
    }
}

if (!function_exists('customer_membership_incentives'))
{
    function customer_membership_incentives(): array
    {
        return array(
            'Payment will be applied 5 days before the membership plan expires to ensure continuous use of the service.',
            'First time user gets 30 days free trial when you sign up for Bougie membership',
            '15% off when user pay annually',
            //'$25 reward for  vendor referral, when vendor registers',
            'Earn reward points for every customer referral',
            'Earn reward points for every purchase'
        );
    }
}

if (!function_exists('vendor_membership_incentives'))
{
    function vendor_membership_incentives(): array
    {
        return array(
            '15% off for every ( 2 ) additional licenses permitted to users to download app',
            '15% off for annual payment',
            '15% discount on next payment for vendor referral, when new vendor registers'
        );
    }
}

if (!function_exists('vendor_checklist'))
{
    function vendor_checklist(): array
    {
        return array(
            'signup_image_upload' => 'Signup & Image upload',
            'add_vendor' => 'Add Vendor Information',
            'add_store' => 'Add Store Information',
            'set_role_permission' => 'Set Role and Permission',
            'add_inventory' => 'Add Inventory',
            'inventory_management_review' => 'Inventory Management Review',
            'setup_vendor_app' => 'Setup Vendor App',
            'setup_app_user_permissions' => 'Setup App User Permissions',
            'store_hours' => 'Store Hours',
            'download_vendor_app' => 'Download Vendor App (limited for store users)',
            'review' => 'Review and Go'
        );
    }
}

if (!function_exists('supplier_checklist'))
{
    function supplier_checklist(): array
    {
        return array(
            'signup_image_upload' => 'Signup & Image upload',
            'add_supplier' => 'Add Supplier Information',
            'add_store' => 'Add Store Information',
            'set_role_permission' => 'Set Role and Permission',
            'add_inventory' => 'Add Inventory',
            'inventory_management_review' => 'Inventory Management Review',
            'setup_supplier_app' => 'Setup Supplier App',
            'setup_app_user_permissions' => 'Setup App User Permissions',
            'store_hours' => 'Store Hours',
            'download_supplier_app' => 'Download Supplier App (limited for store users)',
            'review' => 'Review and Go'
        );
    }
}

if (!function_exists('customer_checklist'))
{
    function customer_checklist(): array
    {
        return array(
            'signup_image_upload' => 'Signup & Photo mandatory',
            'refer_20_friends' => 'Refer 20 friends minimum (once a month)',
            'maintain_minimum_wallet' => 'Maintain $25 minimum in Wallet',
            'make_store_purchase' => 'Make a Store purchase (at least once a week)',
            'suggest_store' => 'Suggest a Store & Earn when Store Register  (twice a month)',
            'social_share_ezsiop' => 'Share Nature Checkout on social media (once a week)',
            'review' => 'Review and Go'
        );
    }
}

if (!function_exists('customer_incentive_types'))
{
    function customer_incentive_types(): array
    {
        return array(

            'tier_1' => 'Tier 1',
            'tier_2' => 'Tier 2',
            'tier_3' => 'Tier 3',
        );
    }
}

if (!function_exists('customer_incentive_sub_types'))
{
    function customer_incentive_sub_types(): array
    {
        return array(
            'college_scholarship' => 'Scholarship for college student',
            'europe_trip' => 'One week round trip to Europe',
            'caribbean_trip' => 'One week round trip to the Caribbean',
            'stay_in_hotel' => '2 Nights stay in 5 star hotel & resort',
            'adventure_park' => 'Adventure parks tickets',
            'theme_park' => 'Theme parks tickets',
            'gift_card' => '$300 gift cards',
            'laptop' => 'HP laptop',
            'tablet' => 'Tablets'
        );
    }
}

if (!function_exists('miles2kms'))
{
    function miles2kms($miles): float
    {
        return $miles * 1.609344;
    }
}

if (!function_exists('invoiceAmountFormat'))
{
    function invoiceAmountFormat($amount): string
    {
        if($amount < 0) {
           $amount = '-$' . number_format((abs($amount)/100),2,".","");
        } else {
           $amount = '$' . number_format(($amount/100),2,".","");
        }
        return $amount;
    }
}
