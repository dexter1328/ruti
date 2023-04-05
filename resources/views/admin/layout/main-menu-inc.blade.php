@php
//dd(Auth::guard('admin')->user());
$user_role_id = Auth::user()->role_id ?? null;
@endphp
<ul class="sidebar-menu do-nicescrol">
    <li>
        <a href="{{url('admin/home')}}" class="waves-effect">
            <i class="icon-home icons"></i><span>Dashboard</span>
        </a>
    </li>
    @if(has_permission($user_role_id,'admins','read') || has_permission($user_role_id,'admin_roles','read') )
        <li class="{{ (request()->is('admin/admins') or request()->is('admin/admins/*') or request()->is('admin/admin_roles') or request()->is('admin/admin_roles/*')) ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-user icons"></i><span>Manage Admins</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                @if(has_permission($user_role_id,'admins','read'))
                    <li class="{{ (request()->is('admin/admins') or request()->is('admin/admins/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/admins')}}">
                            <i class="zmdi zmdi-dot-circle-alt"></i>All Admins
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'admin_roles','read'))
                    <li class="{{ (request()->is('admin/admin_roles') or request()->is('admin/admin_roles/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/admin_roles')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Roles
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    @if(has_permission($user_role_id,'pages','read') || has_permission($user_role_id,'menus','read') || has_permission($user_role_id,'banners','read') || has_permission($user_role_id,'galleries','read') || has_permission($user_role_id,'newsletters','read') || has_permission($user_role_id,'push_notifications','read') || has_permission($user_role_id,'user_notification','read') )
        <li class="{{ (request()->is('admin/pages/*') or request()->is('admin/menus/*') or request()->is('admin/banners/*') or request()->is('admin/galleries/*') or request()->is('admin/newsletters/*') or request()->is('admin/push_notifications/*') or request()->is('admin/user_notification')) ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-globe icons"></i><span>Manage Front Website</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                @if(has_permission($user_role_id,'menus','read'))
                    <li class="{{ (request()->is('admin/menus') or request()->is('admin/menus/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/menus')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Menus
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'pages','read'))
                    <li class="{{ (request()->is('admin/pages') or request()->is('admin/pages/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/pages')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Pages
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'banners','read'))
                    <li class="{{ (request()->is('admin/banners') or request()->is('admin/banners/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/banners')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Banners
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'galleries','read'))
                    <li class="{{ (request()->is('admin/galleries') or request()->is('admin/galleries/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/galleries')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Galleries
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'newsletters','read'))
                    <li class="{{ (request()->is('admin/newsletters') or request()->is('admin/newsletters/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/newsletters')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Newsletters
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'push_notifications','read'))
                    <li class="{{ (request()->is('admin/push_notifications') or request()->is('admin/push_notifications/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/push_notifications')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Push Notifications
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'user_notification','read'))
                    <li class="{{ (request()->is('admin/user_notification') or request()->is('admin/user_notification/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/user_notification')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage User Notification
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(has_permission($user_role_id,'reward_points','read'))
        <li class="{{ (request()->is('admin/reward_points') or request()->is('admin/reward_points/*')) ? 'active' : '' }}">
            <a href="{{url('admin/reward_points')}}" class="waves-effect">
                <i class="icon-badge icons"></i><span>Manage Reward Points</span>
            </a>
        </li>
    @endif

    @if(has_permission($user_role_id,'membership','read'))
        <li class="{{ (request()->is('admin/membership') or request()->is('admin/membership/*')) ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-user-follow icons"></i><span>Manage Memberships</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                <li class="{{ (request()->is('admin/membership/list/customer')) ? 'active' : '' }}">
                    <a href="{{url('admin/membership/list/customer')}}">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Customer Membership
                    </a>
                </li>
                <li class="{{ (request()->is('admin/membership/list/vendor')) ? 'active' : '' }}">
                    <a href="{{url('admin/membership/list/vendor')}}">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Vendor Membership
                    </a>
                </li>
                <li class="{{ (request()->is('admin/membership/list/supplier')) ? 'active' : '' }}">
                    <a href="{{url('admin/membership/list/supplier')}}">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Supplier Membership
                    </a>
                </li>
                <li class="{{ (request()->is('admin/membership-coupons')) ? 'active' : '' }}">
                    <a href="{{url('admin/membership-coupons')}}">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Membership Coupons
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if(has_permission($user_role_id,'checklist','read'))
        <li class="{{ (request()->is('admin/checklist') or request()->is('admin/checklist/*')) ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-list icons"></i><span>Manage Checklist</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                <li class="{{ (request()->is('admin/checklist/customer')) ? 'active' : '' }}">
                    <a href="{{url('admin/checklist/customer')}}">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Customer Checklist
                    </a>
                </li>
                <li class="{{ (request()->is('admin/checklist/vendor')) ? 'active' : '' }}">
                    <a href="{{url('admin/checklist/vendor')}}">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Vendor Checklist
                    </a>
                </li>
                <li class="{{ (request()->is('admin/checklist/supplier')) ? 'active' : '' }}">
                    <a href="{{url('admin/checklist/supplier')}}">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Supplier Checklist
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if(has_permission($user_role_id,'vendor','read') || has_permission($user_role_id,'vendor_store','read') || has_permission($user_role_id,'vendor_configuration','read') || has_permission($user_role_id,'vendor_coupons','read') || has_permission($user_role_id,'vendor_coupons_used','read') )
        <li class="{{ (request()->is('admin/vendor/*') or request()->is('admin/vendor_store/*') or request()->is('admin/vendor_configuration/*') or request()->is('admin/vendor_coupons/*') or request()->is('admin/vendor_coupons_used/*') or request()->is('admin/vendor_unverified_coupons/*')) ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-people icons"></i><span>Manage Vendors Details</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                @if(has_permission($user_role_id,'vendor','read'))
                    <li class="{{ (request()->is('admin/vendor') or request()->is('admin/vendor/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/vendor')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Vendors
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'vendor_store','read'))
                    <li class="{{ (request()->is('admin/vendor_store') or request()->is('admin/vendor_store/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/vendor_store')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Vendor Stores
                        </a>
                    </li>
                @endif
                @php /* @endphp
                <li class="{{ (request()->is('admin/vendor_configuration') or request()->is('admin/vendor_configuration/*')) ? 'active' : '' }}">
                    <a href="{{url('admin/vendor_configuration')}}" class="waves-effect">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Manage Configurations
                    </a>
                </li>
                @php */ @endphp
                @if(has_permission($user_role_id,'vendor_coupons','read'))
                    <li class="{{ (request()->is('admin/vendor_coupons') or request()->is('admin/vendor_coupons/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/vendor_coupons')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Verified Coupons
                        </a>
                    </li>
                    <li class="{{ (request()->is('admin/vendor_coupons') or request()->is('admin/vendor_coupons/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/vendor_coupons/unverified')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Unverified Coupons
                        </a>
                    </li>
                @endif
                <!-- <li class="{{ (request()->is('admin/vendor_coupons_used') or request()->is('admin/vendor_coupons_used/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_coupons_used')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Used Coupons
								</a>
							</li> -->
                <!-- <li class="{{ (request()->is('admin/vendor_payment') or request()->is('admin/vendor_payment/*')) ? 'active' : '' }}">
								<a href="{{url('admin/vendor_payment')}}" class="waves-effect">
									<i class="zmdi zmdi-dot-circle-alt"></i>Manage Accounting
								</a>
							</li> -->
            </ul>
        </li>
    @endif

    {{-- supplier --}}
    @if(has_permission($user_role_id,'vendor','read') || has_permission($user_role_id,'vendor_store','read') || has_permission($user_role_id,'vendor_configuration','read') || has_permission($user_role_id,'vendor_coupons','read') || has_permission($user_role_id,'vendor_coupons_used','read') )
        <li class="{{ (request()->is('admin/supplier/*') or request()->is('admin/supplier_store/*') or request()->is('admin/supplier_configuration/*') or request()->is('admin/supplier_coupons/*') or request()->is('admin/supplier_coupons_used/*') or request()->is('admin/supplier_unverified_coupons/*')) ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-people icons"></i><span>Manage Suppliers Details</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                @if(has_permission($user_role_id,'vendor','read'))
                    <li class="{{ (request()->is('admin/supplier') or request()->is('admin/supplier/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/supplier')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Suppliers
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'vendor_store','read'))
                    <li class="{{ (request()->is('admin/supplier_store') or request()->is('admin/supplier_store/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/supplier_store')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Supplier Stores
                        </a>
                    </li>
                @endif

                @if(has_permission($user_role_id,'vendor_coupons','read'))
                    <li class="{{ (request()->is('admin/supplier_coupons') or request()->is('admin/supplier_coupons/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/supplier_coupons')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Verified Coupons
                        </a>
                    </li>
                    <li class="{{ (request()->is('admin/supplier_coupons') or request()->is('admin/supplier_coupons/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/supplier_coupons/unverified')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Unverified Coupons
                        </a>
                    </li>
                @endif

            </ul>
        </li>
    @endif
    @if(has_permission($user_role_id,'products','read') || has_permission($user_role_id,'brand','read') || has_permission($user_role_id,'categories','read') || has_permission($user_role_id,'attributes','read') || has_permission($user_role_id,'discount_offers','read')|| has_permission($user_role_id,'product_reviews','read') )
        <li class="{{ (request()->is('admin/products/*') or request()->is('admin/brand/*') or request()->is('admin/categories/*') or request()->is('admin/attributes/*') or request()->is('admin/discount_offers/*') or request()->is('admin/product_reviews/*')) ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-present icons"></i><span>Manage Product Details</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                @if(has_permission($user_role_id,'products','read'))
                    <li class="{{ (request()->is('admin/products') or (request()->is('admin/products/*') && !request()->is('admin/products/inventory') && !request()->is('admin/products/generate-barcodes'))) ? 'active' : '' }}">
                        <a href="{{url('admin/products')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Products
                        </a>
                    </li>

                    <li class="{{ (request()->is('admin/products/inventory')) ? 'active' : '' }}">
                        <a href="{{url('admin/products/inventory')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Inventory
                        </a>
                    </li>
                    <li class="{{ (request()->is('admin/products/generate-barcodes')) ? 'active' : '' }}">
                        <a href="{{url('admin/products/generate-barcodes')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Product Barcodes
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'product_reviews','read'))
                    <li class="{{ (request()->is('admin/product_reviews') or request()->is('admin/product_reviews/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/product_reviews')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Reviews
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'categories','read'))
                    <li class="{{ request()->is('admin/categories/*') ? 'active' : '' }}">
                        <a href="{{url('admin/categories')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Categories
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'attributes','read'))
                    <li class="{{ request()->is('admin/attributes/*') ? 'active' : '' }}">
                        <a href="{{url('admin/attributes')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Attributes
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'brand','read'))
                    <li class="{{ (request()->is('admin/brand') or request()->is('admin/brand/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/brand')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Brands
                        </a>
                    </li>
                @endif
                <!-- <li class="{{ (request()->is('admin/discount_offers') or request()->is('admin/discount_offers/*')) ? 'active' : '' }}">
								<a href="{{url('admin/discount_offers')}}" class="waves-effect">
									<i class="fa fa-percent"></i>Manage Discount Offers
								</a>
							</li> -->
            </ul>
        </li>
    @endif
    @if(has_permission($user_role_id,'products','read') || has_permission($user_role_id,'brand','read') || has_permission($user_role_id,'categories','read') || has_permission($user_role_id,'attributes','read') || has_permission($user_role_id,'discount_offers','read')|| has_permission($user_role_id,'product_reviews','read') )
        <li class="{{ (request()->is('admin/w2b_products/*')) ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-present icons"></i><span>Wholesale2b</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                @if(has_permission($user_role_id,'products','read'))
                    <li class="{{ (request()->is('admin/w2b_products') ) ? 'active' : '' }}">
                        <a href="{{url('admin/w2b_products')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Products List
                        </a>
                    </li>

                @endif
                @if(has_permission($user_role_id,'products','read'))
                    <li class="{{ (request()->is('admin/w2b_products') ) ? 'active' : '' }}">
                        <a href="{{url('admin/w2b_products/orders')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Orders
                        </a>
                    </li>

                @endif

            </ul>
        </li>
    @endif
    @if(has_permission($user_role_id,'customer_incentive','read'))
        <li class="{{ request()->is('admin/customer_incentive/*') ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-people icons"></i><span>Manage Incentives</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                <li class="{{ request()->is('admin/customer_incentive/qualifiers') ? 'active' : '' }}">
                    <a href="{{url('admin/customer_incentive/qualifiers')}}" class="waves-effect">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Manage Qualifiers
                    </a>
                </li>
                <li class="{{ request()->is('admin/customer_incentive/winners') ? 'active' : '' }}">
                    <a href="{{url('admin/customer_incentive/winners')}}" class="waves-effect">
                        <i class="zmdi zmdi-dot-circle-alt"></i>Manage Winners
                    </a>
                </li>
            </ul>
        </li>
    @endif
    @if(has_permission($user_role_id,'customer','read') || has_permission($user_role_id,'suggested-place','read') )
        <li class="{{ request()->is('admin/customer') || request()->is('admin/customer/*') || request()->is('admin/customer_feedback') || request()->is('admin/customer_feedback/*') || request()->is('admin/customer_reviews') || request()->is('admin/customer_reviews/*') || request()->is('admin/customer_reward_points') || request()->is('admin/customer_reward_points/*') || request()->is('admin/customer_used_reward_points') || request()->is('admin/customer_used_reward_points/*') || request()->is('admin/suggested-place') || request()->is('admin/suggested-place/*')? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-people icons"></i><span>Manage Customers Details</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                @if(has_permission($user_role_id,'customer','read'))
                    <li class="{{ (request()->is('admin/customer') or request()->is('admin/customer/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/customer')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Customers
                        </a>
                    </li>
                @endif

                @if(has_permission($user_role_id,'suggested-place','read'))
                    <li class="{{ (request()->is('admin/suggested-place') or request()->is('admin/suggested-place/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/suggested-place')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Suggested Place
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    @if(has_permission($user_role_id,'orders','read') || has_permission($user_role_id,'order_return','read') || has_permission($user_role_id,'cancelled_orders','read') || has_permission($user_role_id,'order_reason','read') )
        <li class="{{ (request()->is('admin/orders/*') or request()->is('admin/order_return/*') or request()->is('admin/cancelled_orders/*') or request()->is('admin/order_reason/*') or request()->is('admin/order/return/request') or request()->is('admin/order/inshop_order') or request()->is('admin/order/pickup_order')) ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-basket-loaded icons"></i><span>Manage Orders Details</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                @if(has_permission($user_role_id,'orders','read'))
                    <li class="{{ (request()->is('admin/orders') or request()->is('admin/orders/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/orders')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Orders
                        </a>
                    </li>
                    <li class="{{ (request()->is('admin/order/inshop_order')) ? 'active' : '' }}">
                        <a href="{{url('admin/order/inshop_order')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage In Store Order
                        </a>
                    </li>
                    <li class="{{ (request()->is('admin/order/pickup_order')) ? 'active' : '' }}">
                        <a href="{{url('admin/order/pickup_order')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Pickup Order
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'order_return','read'))
                    <li class="{{ (request()->is('admin/order/return/request')) ? 'active' : '' }}">
                        <a href="{{url('admin/order/return/request')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Return Request Orders
                        </a>
                    </li>
                    <li class="{{ (request()->is('admin/order_return') or request()->is('admin/order_return/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/order_return')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Return Orders
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'cancelled_orders','read'))
                    <li class="{{ (request()->is('admin/cancelled_orders') or request()->is('admin/cancelled_orders/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/cancelled_orders')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Cancel Orders
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'order_reason','read'))
                    <li class="{{ (request()->is('admin/order_reason') or request()->is('admin/order_reason/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/order_reason')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Manage Order Reasons
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(has_permission($user_role_id,'support_ticket','read'))
        <li class="{{ (request()->is('admin/support_ticket') or request()->is('admin/support_ticket/*')) ? 'active' : '' }}">
            <a href="{{url('admin/support_ticket')}}" class="waves-effect">
                <i class="icon-support icons"></i><span>Manage Ticket Issues</span>
            </a>
        </li>
    @endif
    @if(has_permission($user_role_id,'settings','read'))
        <li class="{{ (request()->is('admin/settings')) ? 'active' : '' }}">
            <a href="{{url('admin/settings/')}}" class="waves-effect">
                <i class="icon-settings icons"></i><span>Manage Settings</span>
            </a>
        </li>
    @endif
    @if(has_permission($user_role_id,'login_history','read'))
        <li class="{{ (request()->is('admin/login_history')) ? 'active' : '' }}">
            <a href="{{ url('admin/login_history') }}" class="waves-effect">
                <i class="icon-clock icons"></i><span>Manage Login Activities</span>
            </a>
        </li>
        <li class="{{ (request()->is('admin/import_export_logs')) ? 'active' : '' }}">
            <a href="{{ url('admin/import_export_logs') }}" class="waves-effect">
                <i class="icon-clock icons"></i><span>Manage Import/Export Logs</span>
            </a>
        </li>
    @endif
    @if(has_permission($user_role_id,'customer_transaction','read') || has_permission($user_role_id,'vendor_transaction','read') )
        <li class="{{ request()->is('admin/customer_transaction') || request()->is('admin/vendor_transaction') ? 'active menu-open' : '' }}">
            <a href="javaScript:void();" class="waves-effect">
                <i class="icon-people icons"></i><span>Manage Transactions</span><i class="fa fa-angle-down"></i>
            </a>
            <ul class="sidebar-submenu">
                @if(has_permission($user_role_id,'customer_transaction','read'))
                    <li class="{{ (request()->is('admin/customer_transaction') or request()->is('admin/customer_transaction/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/customer_transaction')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Customer Transactions
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'vendor_transaction','read'))
                    <li class="{{ (request()->is('admin/vendor_transaction') or request()->is('admin/vendor_transaction/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/vendor_transaction')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Vendor Transactions
                        </a>
                    </li>
                @endif
                @if(has_permission($user_role_id,'supplier_transaction','read'))
                    <li class="{{ (request()->is('admin/supplier_transaction') or request()->is('admin/supplier_transaction/*')) ? 'active' : '' }}">
                        <a href="{{url('admin/supplier_transaction')}}" class="waves-effect">
                            <i class="zmdi zmdi-dot-circle-alt"></i>Supplier Transactions
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    @if(has_permission($user_role_id,'email_template','read'))
        <li class="{{ (request()->is('admin/email_template')) ? 'active' : '' }}">
            <a href="{{url('admin/email_template/')}}" class="waves-effect">
                <i class="zmdi zmdi-email"></i> <span>Manage Email Templates</span>
            </a>
        </li>
    @endif
</ul>