<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::post('register', 'API\RegisterController@register');

Route::middleware('auth:api')->group( function () {
	Route::resource('products', 'API\ProductController');
});*/

//Route::group(['middleware' => ['cors', 'json.response']], function () {

	// User
	Route::post('register', 'API\AuthController@register')->name('customer-register');
	Route::post('login', 'API\AuthController@login')->name('customer-login');
	Route::post('social_login', 'API\AuthController@socialLogin')->name('customer-social-login');
	Route::post('forgot_password','API\AuthController@ForgotPassword')->name('customer-forgot-password');
	Route::post('save_user_device','API\AuthController@saveUserDevice')->name('customer-save-user-device');

	Route::post('category_list','API\ShopController@categoryList');
	Route::post('dashboard','API\ShopController@dashboard');
	Route::post('store_list','API\ShopController@storeList');
	Route::get('store_dashboard/{id}','API\ShopController@storeDashboard');
	Route::post('product_by_category/{id}','API\ShopController@productByCategory');
	Route::post('best_selling_product','API\ShopController@bestSellingProduct');
	Route::post('store_best_selling_product/{id}','API\ShopController@storeBestSellingProduct');
	Route::post('best_trending_product','API\ShopController@bestTrendingProduct');
	Route::post('store_best_trending_product/{id}','API\ShopController@storeBestTrendingProduct');
	Route::post('best_seasonal_product','API\ShopController@bestSeasonalProduct');
	Route::post('store_best_seasonal_product/{id}','API\ShopController@storebestSeasonalProduct');
	Route::post('product_detail/{id}','API\ShopController@productDetail');
	Route::post('product_variants_detail','API\ShopController@productVariantDetail');
	Route::get('filter_option','API\ShopController@filterOption');
	Route::post('filter_list','API\ShopController@filterList');
	Route::post('auto_search/{id?}','API\ShopController@autoSearch');
	Route::post('store_product_search/{id}','API\ShopController@storeProductSearch');
	Route::post('product_search','API\ShopController@productSearch');
	Route::post('product_by_id','API\ShopController@productListById');
	Route::post('discount_offer','API\ShopController@discountOffer');
	Route::post('discount_offer_category/{id}','API\ShopController@discountOfferCategory');
	Route::get('store-detail/{id}','API\OrderController@storeDetail');

	Route::get('membership-list', 'API\AuthController@membershipList');
	Route::get('membership-incentives', 'API\AuthController@membershipIncentives');
	Route::get('customer-incentives', 'API\AuthController@customerIncentives');

	// vendor
	Route::post('/vendor/login', 'API\Vendor\AuthController@login');
	Route::post('/vendor/forgot_password','API\Vendor\AuthController@ForgotPassword');
	Route::post('/vendor/save_vendor_device','API\Vendor\AuthController@saveVendorDevice');
//});

Route::group(['middleware' => 'auth:api'], function(){

	Route::post('get_user', 'API\AuthController@getUserByEmail');
	Route::post('edit_profile/{id}','API\AuthController@editProfile');
	Route::get('get_customer_checklist/{id}', 'API\AuthController@getCustomerChecklist');
	Route::post('get_store','API\ShopController@getStore');
	// Route::get('best_selling_product/{id}','API\ShopController@bestSellingProduct');
	//Route::post('best_selling_product','API\ShopController@bestSellingProduct');
	//Route::post('store_best_selling_product/{id}','API\ShopController@storeBestSellingProduct');

	//Route::post('best_trending_product','API\ShopController@bestTrendingProduct');
	//Route::post('store_best_trending_product/{id}','API\ShopController@storeBestTrendingProduct');

	//Route::post('best_seasonal_product','API\ShopController@bestSeasonalProduct');
	//Route::post('store_best_seasonal_product/{id}','API\ShopController@storebestSeasonalProduct');

	Route::post('store_product_list/{id}','API\ShopController@storeProductList');
	// Route::get('store_category_list/{id}','API\ShopController@storeCategoryList');
	//Route::post('product_search','API\ShopController@productSearch');
	//Route::post('store_product_search/{id}','API\ShopController@storeProductSearch');
	Route::post('change_password/{id}','API\AuthController@changePassword');
	//Route::post('category_list','API\ShopController@categoryList');
	Route::get('banner_list','API\ShopController@bannerList');
	//Route::post('store_list','API\ShopController@storeList');
	//Route::post('dashboard','API\ShopController@dashboard');
	//Route::post('product_detail/{id}','API\ShopController@productDetail');
	// Route::get('product_detail/{id}','API\AuthController@productDetail');
	//Route::get('store_dashboard/{id}','API\ShopController@storeDashboard');
	Route::post('product_list','API\ShopController@productList');
	//Route::get('filter_option','API\ShopController@filterOption');
	//Route::post('filter_list','API\ShopController@filterList');
	Route::post('add-remove-wishlist','API\ShopController@addremoveWishlist');
	Route::get('wishlist/{id}','API\ShopController@wishList');
	//Route::post('auto_search/{id?}','API\ShopController@autoSearch');
	Route::post('checkout','API\OrderController@Checkout');
	Route::get('order_detail/{id}','API\OrderController@orderDetail');
	Route::post('add_money_wallet/{id}','API\OrderController@addMoneyWallet');
	Route::post('transfer_money/{id}','API\OrderController@transferMoney');
	Route::get('customer-balance/{id}','API\OrderController@customerBalance');
	Route::get('coupan_list/{id}','API\OrderController@coupanList');
	//Route::post('product_by_id','API\ShopController@productListById');
	//Route::post('product_variants_detail','API\ShopController@productVariantDetail');
	Route::post('transcation_history/{id}','API\OrderController@transcationHistory');
	Route::post('order_list/{id}','API\OrderController@orderList');
	//Route::post('product_by_category/{id}','API\ShopController@productByCategory');
	Route::post('cancel_order/{id}','API\OrderController@cancelOrder');
	Route::post('return_order_item/{id}','API\OrderController@returnOrderItem');
	//Route::post('discount_offer','API\ShopController@discountOffer');
	//Route::post('discount_offer_category/{id}','API\ShopController@discountOfferCategory');
	Route::get('discount_product/{id}','API\ShopController@discountProduct');
	Route::post('inshop','API\ShopController@inShop');
	Route::post('scan_barcode_product','API\ShopController@scanBarcodeProduct');
	Route::post('suggested-place/{id}','API\OrderController@suggestedPlace');
	Route::post('test_store','API\OrderController@test_store');
	Route::post('notification_list/{id}','API\OrderController@notificationList');

	Route::post('support-ticket/{id}','API\TicketController@createTicket');
	Route::post('support-ticket-list/{id}','API\TicketController@SupportTicketList');
	Route::post('reward_point_history/{id}','API\OrderController@rewardPointHistory');
	Route::post('order_reason','API\OrderController@orderReason');
	Route::post('product_feedback/{id}','API\OrderController@productFeedback');
	Route::post('repeat_order/{id}','API\OrderController@repeatOrder');
	Route::post('add-to-cart/{id}','API\OrderController@addToCart');
	Route::get('remove-cart/{id}','API\OrderController@removeCart');
	Route::get('inshop-cart/{id}','API\OrderController@inshopCart');
	//Route::get('store-detail/{id}','API\OrderController@storeDetail');

	Route::post('save_customer_card/{id}','API\AuthController@saveCustomerCard');
	Route::get('retrive_customer_cards/{id}','API\AuthController@retriveCustomerCards');
	Route::post('set_customer_default_card/{id}','API\AuthController@setCustomerDefaultCard');
	Route::post('delete_customer_card/{id}','API\AuthController@deleteCustomerCard');
	Route::post('pickup-order-notification/{id}','API\OrderController@pickupOrderNotification');

	Route::get('accept-wallet-term/{id}', 'API\AuthController@acceptWalletTerm');
	Route::post('change-price-drop-alert-status/{id}', 'API\AuthController@changePriceDropAlertStatus');
	Route::get('check-price-drop-alert/{id}', 'API\AuthController@checkPriceDropAlert');
	Route::get('check-is-join/{id}', 'API\AuthController@checkIsJoin');
	Route::get('one-time-customer-fee/{id}', 'API\AuthController@oneTimeCustomerFee');
	Route::post('user_guide_complete/{id}', 'API\AuthController@userGuideComplete');

	Route::post('change-subscription', 'API\AuthController@changeSubscription');
	Route::post('cancel-subscription', 'API\AuthController@cancelSubscription');

	Route::get('get-errand-runner/{cid}', 'API\AuthController@getErrandRunner');
	Route::post('save-errand-runner/{cid}', 'API\AuthController@saveErrandRunner');
});

/*Route::group(['middleware' => 'auth:vendor-api'], function(){

	Route::post('edit_profile/{id}','API\VendorAuthController@editProfile');
});*/

Route::group(['prefix' => 'vendor', 'middleware' => 'auth:vendor-api'], function() {

	Route::post('signup/{id}','API\Vendor\AuthController@signup');
   	Route::post('edit_profile/{id}','API\Vendor\AuthController@editProfile');
   	Route::post('change_password/{id}','API\Vendor\AuthController@changePassword');
   	Route::get('get-store/{id}','API\Vendor\ShopController@getStore');
   	Route::post('dashboard/{id}','API\Vendor\ShopController@dashboard');
   	Route::post('take-away-list/{id}','API\Vendor\ShopController@takeAwayList');
   	Route::get('take-away-detail/{id}','API\Vendor\ShopController@takeAwayDetail');
   	Route::post('checkout-user-list/{id}','API\Vendor\ShopController@checkoutUserList');
   	Route::get('checkout-order-detail/{id}','API\Vendor\ShopController@checkoutOrderDetail');

   	Route::post('total-item-sold/{id}','API\Vendor\ShopController@totalItemSold');
   	Route::get('get-roles','API\Vendor\ShopController@getRoles');

   	Route::post('support-ticket/{id}','API\Vendor\ShopController@createTicket');
	Route::post('support-ticket-list/{id}','API\Vendor\ShopController@SupportTicketList');
	Route::post('store-support-ticket-list/{id}','API\Vendor\ShopController@StoreSupportTicketList');
	Route::post('total-earnings/{id}','API\Vendor\ShopController@totalEarnings');
	Route::post('active-users/{id}','API\Vendor\ShopController@activeUser');

	Route::post('return-order-list/{id}','API\Vendor\ShopController@returnOrderList');
	Route::post('return-request-order-list/{id}','API\Vendor\ShopController@returnRequestOrderList');



	Route::get('return-order-detail/{id}','API\Vendor\ShopController@returnOrderDetail');

	Route::post('cancel-order-list/{id}','API\Vendor\ShopController@cancelOrderList');
	Route::get('cancel-order-detail/{id}','API\Vendor\ShopController@cancelOrderDetail');
	Route::get('child-vendor-list/{id}','API\Vendor\AuthController@childVendorList');
	Route::post('child-vendor-edit/{id}','API\Vendor\AuthController@childVendorEdit');
	Route::get('child-vendor-delete/{id}','API\Vendor\AuthController@childVendorDelete');

	Route::post('notification_list/{id}','API\Vendor\ShopController@notificationList');
	Route::post('unverified_inshop_order_list/{id}','API\Vendor\ShopController@unverifiedInshopOrderList');
	Route::get('inshop_verified_order/{id}','API\Vendor\ShopController@inshopVerifiedOrder');
	Route::get('broad-cast-listing','API\Vendor\ShopController@broadCastDealListing');
	Route::post('broad-cast-send/{id}','API\Vendor\ShopController@broadCastDealSend');
	Route::post('pickup-order-list/{id}','API\Vendor\ShopController@pickupOrderList');
	Route::post('pickup-order-change-status/{id}','API\Vendor\ShopController@pickupOrderChangeStatus');
	Route::get('pickup-order-notification/{id}','API\Vendor\ShopController@pickupOrderNotification');
	Route::post('low-stock-product/{id}','API\Vendor\ShopController@lowStockProduct');

});


// Wholesale 2b Products Api
    Route::get('all_products','API\w2b\WholesaleProductController@index');
    Route::get('all_categories','API\w2b\WholesaleProductController@categories');
    Route::get('get_products/{cat_name}','API\w2b\WholesaleProductController@get_products');
    Route::get('product-detail/{sku}','API\w2b\WholesaleProductController@ProductDetail');
    Route::post('post-checkout','API\w2b\WholesaleProductController@postCheckout');
    Route::post('post-checkout2','API\w2b\WholesaleProductController@postCheckout2');
    Route::get('user_orders/{userId}','API\w2b\WholesaleProductController@userOrder');
    Route::get('ordered_products/{orderId}','API\w2b\WholesaleProductController@orderedProduct');
    Route::get('single_order/{orderId}','API\w2b\WholesaleProductController@singleOrder');
    Route::get('cancel_order/{orderId}','API\w2b\WholesaleProductController@cancelOrder');
    Route::get('repeat_order/{orderId}','API\w2b\WholesaleProductController@repeatOrder');
    Route::get('best_products','API\w2b\WholesaleProductController@bestProduct');
    Route::get('best_products/{productSku}','API\w2b\WholesaleProductController@bestProductId');
    Route::get('best_sellers','API\w2b\WholesaleProductController@bestSeller');
    Route::get('best_sellers/{vendorId}','API\w2b\WholesaleProductController@bestSellerId');


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//
