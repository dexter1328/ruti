<?php

// use Exception;
use App\EmailTemplate;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/return-policy', function () {
    return view('front_end.return-policy');
});*/

/*Route::get('/cache-config-clear', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    dd("Done");
});

Route::get('/config-cache', function () {
    \Artisan::call('config:cache');
    dd("Done");
});*/

/*Route::get('/test-cron', function () {
    \Artisan::call('schedule:run');
    dd("Done");
});*/

// Route::get('/apple-app-site-association', function () {

//     $data = [
//         "webcredentials" => [
//             "apps" => [
//                 "3JR9WQK268.com.apps.ezsiop",
//                 "3JR9WQK268.com.apps.ezsiopvendor"
//             ]
//         ],
//         "applinks" => [
//             "apps" => [
//             ],
//             "details" => [
//                 [
//                     "appID" => "3JR9WQK268.com.apps.ezsiop",
//                     "paths" => [
//                        "NOT /_/*",
//                         "/*"
//                     ]
//                 ],
//                 [
//                     "appID" => "3JR9WQK268.com.apps.ezsiopvendor",
//                     "paths" => [
//                        "NOT /_/*",
//                         "/*"
//                     ]
//                 ]
//             ]
//         ]
//     ];

//     return response()->json($data);
// });

/*Route::get('/free_subscription_all_users', function () {

    $user = App\User::all();
    foreach ($user as $key => $value) {

        $user_subscription = new App\UserSubscription;
        $user_subscription->user_id = $value->id;
        $user_subscription->membership_id = 1;
        $user_subscription->status = 'active';
        $user_subscription->save();
    }
});*/


// Route::get('/renew-customer-subscription/{days?}', 'TestController@renewCustomerSubscription');
// Route::get('/cancel-customer-subscription', 'TestController@cancelCustomerSubscription');
// Route::get('/customer-incentive-qalifiers', 'TestController@customerIncentiveQalifiers');
// Route::get('/customer-incentive-winners', 'TestController@customerIncentiveWinners');
// Route::get('/maintain-customer-wallet-amount', 'TestController@maintainCustomerWalletAmount');
// Route::get('/vendor-inventory-reminder', 'TestController@vendorInventoryReminder');
// Route::get('/price-drop-notification', 'TestController@PriceDropNotification');
// Route::get('/vendor-login-cron/{id}', 'TestController@StoreHourCron');
// Route::get('/paid_module_change_status', 'TestController@PaidModuleChangeStatusCron');

use App\Mail\SupplierSuccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SupplierController;

Auth::routes();

Route::get('api/password/reset/{token}', 'API\AuthController@resetPassword');
Route::post('api/password/reset', 'API\AuthController@reset');
Route::get('api/vendor/password/reset/{token}', 'API\Vendor\AuthController@resetPassword');
Route::post('api/vendor/password/reset', 'API\Vendor\AuthController@reset');
Route::post('api/vendor/password/api_reset', 'API\Vendor\AuthController@ApiReset');



Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/debug-sentry', function () {
//     throw new Exception('My first Sentry error!');
// });
Route::get('/optimize', 'FrontEndController@optimize')->name('artisan-optimize');
Route::get('/flush-session', 'FrontEndController@sessionFlush')->name('session-flush');
Route::get('/debug-sentry', 'FrontEndController@sentry')->name('sentry-page');
Route::get('/home', 'FrontEndController@index')->name('home-page');
Route::get('/', 'FrontEndController@shop')->name('product-shop');
Route::get('/category/{cate?}', 'FrontEndController@catName')->name('cat-products');
Route::get('/shop/search', 'FrontEndController@shopSearch')->name('shop-search');
Route::get('/shop/search/autocomplete', 'FrontEndController@autocomplete')->name('shop-search-autocomplete');
Route::get('/shop/product_detail/{slug}/{sku}', 'FrontEndController@ProductDetail')->name('product-detail');
Route::post('/user-rating', 'FrontEndController@rating')->name('user-rating');
Route::post('/vote-best-seller', 'FrontEndController@voteBestSeller')->name('vote-best-seller');
Route::post('/vote-best-product', 'FrontEndController@voteBestProduct')->name('vote-best-product');
Route::get('/user_wishlist', 'FrontEndController@wishlistPage')->name('wb-wishlist-page');
Route::delete('/user_wishlist/delete/{sku}', 'FrontEndController@removeWishlist')->name('remove-from-wishlist');
Route::get('/wishlist/{sku}', 'FrontEndController@wishlist')->name('wb-wishlist');
Route::get('/cart', 'FrontEndController@cart')->name('product-cart');
Route::get('/add-to-cart/{sku}', 'FrontEndController@addToCart')->name('add.to.cart');
Route::get('/add-to-cart1/{sku}', 'FrontEndController@addToCart1')->name('add.to.cart1');
Route::get('/add-to-cart2/{sku}', 'FrontEndController@addToCart2')->name('add.to.cart2');
Route::patch('update-cart', 'FrontEndController@updateCart')->name('update.cart');
Route::delete('remove-from-cart', 'FrontEndController@removeCart')->name('remove.from.cart');
Route::get('/remove-everything', 'FrontEndController@removeEverything')->name('remove-everything');
Route::get('/checkout', 'FrontEndController@checkout')->name('product-checkout');
Route::get('/state_cities/{state_id}', 'FrontEndController@state')->name('state-cities');
Route::post('/user-apply-coupon', 'FrontEndController@applyCoupon')->name('user-apply-coupon');
Route::post('/post-checkout', 'FrontEndController@postCheckout')->name('post-checkout');
Route::get('/payment-page', 'FrontEndController@paymentPage')->name('payment-page');
Route::post('/order-payment', 'FrontEndController@orderPayment')->name('order-payment');
Route::post('/paypal-payment-charge', 'FrontEndController@paypalPayment')->name('paypal-payment');
Route::get('/paypal-payment-success', 'FrontEndController@paypalPaymentSuccess')->name('paypal-payment-success');
Route::get('/paypal-payment-error', 'FrontEndController@paypalPaymentError')->name('paypal-payment-error');
Route::post('/user-wallet-payment/{amount}', 'FrontEndController@userWalletPayment')->name('user-wallet-payment');
Route::get('/thank-you-page', 'FrontEndController@thankYou')->name('thank-you-page');
Route::get('/user-account/{filter?}', 'W2bCustomerController@userAccount')->name('user-account-page');
Route::put('/user-profile-update/{id}', 'W2bCustomerController@userProfileUpdate')->name('user-profile-update');
Route::get('/order-invoice/{id}', 'W2bCustomerController@orderInvoice')->name('order-invoice');
Route::get('/gift-receipt/{id}', 'W2bCustomerController@giftReceipt')->name('gift-receipt');
Route::post('/gift-receipt-update/{id}', 'W2bCustomerController@giftReceiptUpdate')->name('gift-receipt-update');
Route::get('/return-item/{sku}/{orderId}/{userId}/{vendorId}', 'W2bCustomerController@returnItem')->name('return-item');
Route::post('/return-item-submit', 'W2bCustomerController@returnItemSubmit')->name('return-item-submit');
Route::post('/add-to-wallet', 'W2bCustomerController@addToWallet')->name('add-to-wallet');
Route::get('/user-products/{id}', 'W2bCustomerController@userProduct')->name('user-product-page');
Route::get('/dmca', 'FrontEndController@dmca');
Route::get('/terms-condition', 'FrontEndController@termsCondition');
Route::get('/privacy-policy', 'FrontEndController@privacyPolicy');
Route::get('/read-first', 'FrontEndController@readFirst');
Route::get('/blog', 'FrontEndController@blog')->name('nature-blog');
Route::get('/blog-detail/{id}', 'FrontEndController@blogDetail')->name('nature-blog-detail');
Route::get('/supplier/read-first', 'FrontEndController@readFirstSupplier');
Route::get('/trending-products', 'FrontEndController@trendingProducts')->name('trending-products');
Route::get('/special-offers', 'FrontEndController@specialOffers')->name('special-offers');
Route::get('/test-cart-mail', 'FrontEndController@notPaidMail')->name('test.cart.mail');
Route::post('/sub-newsletter', 'FrontEndController@subNewsletter')->name('sub-newsletter');



Route::get('stripe', 'StripePaymentController@stripe');
Route::post('stripepost', 'StripePaymentController@stripePost')->name('stripe.post');


Route::get('/get-stores/{vid}', 'CommonController@getStoresByVendorID')->name('get-stores');
Route::get('/get-brands/{sid}', 'CommonController@getBrandsByStoreID')->name('get-brands');
Route::get('/get-attribute/{sid}', 'CommonController@getAttributeByStoreID')->name('get-attribute');
Route::get('/get-categories/{sid}', 'CommonController@getCategoriesByStoreID')->name('get-categories');
Route::get('/get-categories-hierarchy/{sid}', 'CommonController@getCategoriesHierarchyByStoreID')->name('get-categories-hierarchy');

Route::get('/get-categories-dropdown/{sid}', 'CommonController@getCategoriesDropDownByStoreID')->name('get-categories-dropdown');
Route::get('/get-product/{sid}', 'CommonController@getProductByStore')->name('get-product');
Route::get('/get-state/{id}', 'CommonController@getState')->name('get-state');
Route::get('/get-city/{id}', 'CommonController@getCity')->name('get-city');
Route::get('mobile-cms/{slug}', 'CmsController@mobileCMS');
Route::get('/get-store-customers/{sid}', 'CommonController@getStoreCustomers')->name('get-store-customers');

Route::get('/subscribe_newsletter/{email}', 'CommonController@subscribeNewsletter');
Route::match(['get', 'post'], '/vendor-signup', 'CommonController@vendorSignup');
Route::match(['get', 'post'], '/supplier/signup', 'CommonController@supplierSignup');
Route::get('/thank-you', 'CommonController@thankYou');


// strip webhook response
Route::post('/stripe', 'StripeController@index');

Route::get('session-check', 'CommonController@ajaxCheck')->name('session-check');






// *******  Admin Routes Start  **********

Route::group(['middleware' => 'sessionExpired'], function () {
  Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');

        Route::match(['get', 'post'], '/submit-otp/{token}', 'AdminAuth\LoginController@submitOTP');

    Route::post('/resend_otp_mail', 'AdminAuth\LoginController@resendOtpMail');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.request');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('admin.password.email');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');

    Route::resource('admins', 'Admin\AdminController');
    Route::get('/profile', 'Admin\AdminController@profile')->name('admins.profile');
    Route::post('/profile', 'Admin\AdminController@editprofile')->name('admins.profile');

    // Route::get('login_history','Admin\AdminController@loginHistory')->name('admins.login_history');
        Route::get('login_history', 'Admin\AdminController@loginHistory')->name('login_history.index');

        Route::get('import_export_logs', 'Admin\AdminController@importExportLogs')->name('admins.import_export_logs');
        Route::post('/get-selling-chart', 'Admin\AdminController@getSellingChart')->name('admins.get-selling-chart');
        Route::post('/get-earning-chart', 'Admin\AdminController@getEarningChart')->name('admins.get-earning-chart');
        Route::get('withdraw_requests', 'Admin\AdminController@withdrawRequest')->name('admin.withdraw_requests');
        Route::put('withdraw_status/{id}', 'Admin\AdminController@updateStatus')->name('withdraw_request.update-status');

        Route::match(['get', 'post'], '/customer_transaction', 'Admin\TranscationController@customerTransaction')->name('customer_transaction.index');
        Route::match(['get', 'post'], '/vendor_transaction', 'Admin\TranscationController@vendorTransaction')->name('vendor_transaction.index');

    Route::resource('admin_roles', 'Admin\RoleController');
    Route::resource('menus', 'Admin\MenuController')->only(['index', 'store', 'destroy']);
    Route::get('/menus/get-menus/{position}', 'Admin\MenuController@getMenus')->name('menus.get-menus');
    Route::resource('pages', 'Admin\PageController');
    Route::resource('banners', 'Admin\BannerController');

    Route::get('/user_notification', 'Admin\UserNotificationController@index')->name('user_notification.index');

    // Route::post('products/get-inventory', 'Admin\ProductsController@getInventory')->name('admin.get-inventory');
    Route::post('/user_notification/view_datatable', 'Admin\UserNotificationController@view')->name('admin.view_datatable');

    Route::resource('galleries', 'Admin\GalleryController');
    Route::post('/galleries/remove_image/{id}', 'Admin\GalleryController@RemoveImage')->name('admin.remove_image');

    Route::resource('newsletters', 'Admin\NewsletterController');
    Route::post('/newsletters/send/{id}', 'Admin\NewsletterController@send')->name('admin.newsletters.send');
    Route::get('newsletters/get-user-newsletters/{id}', 'Admin\NewsletterController@getUserNewsletters')->name('admin.get-user-newsletters');

    Route::resource('push_notifications', 'Admin\PushNotificationController');
    Route::post('/push_notifications/send/{id}', 'Admin\PushNotificationController@send')->name('admin.push_notifications.send');
    Route::get('push_notifications/get-user-notifications/{id}', 'Admin\PushNotificationController@getUserNotification')->name('admin.get-user-notifications');


    Route::resource('reward_points', 'Admin\RewardPointController');

    Route::resource('categories', 'Admin\CategoryController')->except('show');
    Route::resource('attributes', 'Admin\AttributeController')->except(['show']);
    Route::get('delete-attribute-value/{id}', 'Admin\AttributeController@deleteAttributeValue')->name('admin.delete-attribute-value');

    Route::get('membership/list/{type}', 'Admin\MembershipController@membershipList')->name('membership.list');
    Route::get('membership/create/{type}', 'Admin\MembershipController@create')->name('membership.create');
        Route::resource('membership', 'Admin\MembershipController')->except(['index', 'create', 'show', 'destroy']);
    // Route::resource('membership', 'Admin\MembershipController')->only(['edit','update']);
        Route::resource('membership-coupons', 'Admin\MembershipCouponController')->except(['show', 'edit', 'update']);
    Route::get('membership-coupons/retrive/{sid}', 'Admin\MembershipCouponController@retrive')->name('membership-coupons.retrive');

    Route::get('checklist/{type}', 'Admin\ChecklistController@index')->name('checklist.index');
    Route::get('checklist/create/{type}', 'Admin\ChecklistController@create')->name('checklist.create');
    Route::get('checklist/change_status/{id}', 'Admin\ChecklistController@changeStatus')->name('checklist.change_status');
        Route::resource('checklist', 'Admin\ChecklistController')->except('index', 'create', 'show');

        /*******************vendor*******************/
    Route::resource('vendor', 'Admin\VendorController');
    // Route::match(['get','post'],'vendor/add_role/{id}', 'Admin\VendorController@addRole')->name('admin.add_role');
    Route::get('vendor/add_role/{id}', 'Admin\VendorController@addRole')->name('admin.add_role');
    Route::post('vendor/vendor_add_role/{id}', 'Admin\VendorController@vendorAddRole')->name('admin.vendor_add_role');
    Route::get('vendor/edit_role/{id}', 'Admin\VendorController@editRole')->name('admin.edit_role');

    Route::post('vendor/import-vendor', 'Admin\VendorController@importVendor')->name('admin.import-vendor');
    Route::post('vendor/view/vendor_datatable', 'Admin\VendorController@view')->name('admin.view.vendor_datatable');
    Route::get('vendor/export/vendor', 'Admin\VendorController@exportVendor')->name('admin.export.vendor');

    Route::post('vendor/get_vendor_import_preview', 'Admin\VendorController@getImportPreview')->name('admin.get_vendor_import_preview');

    Route::post('vendor/update_role', 'Admin\VendorController@updateRole')->name('admin.update_role');

    // Route::post('/vendor/get_vendor_import_preview', 'Admin\VendorController@getImportPreview')->name('admin.get_vendor_import_preview');

    Route::get('vendor/delete_role/{id}', 'Admin\VendorController@deleteRole')->name('admin.delete_role');
        Route::match(['get', 'post'], 'vendor/paid_modules/{id}', 'Admin\VendorController@paidModules')->name('admin.paid_modules');

        Route::match(['get', 'post'], 'vendor/paid_modules/create/{id}', 'Admin\VendorController@paidModulesCreate')->name('admin.paid_modules.create');

        Route::match(['get', 'post'], 'vendor/paid_modules/edit/{id}', 'Admin\VendorController@paidModulesEdit')->name('admin.paid_modules.edit');

    Route::resource('vendor_store', 'Admin\VendorStoreController');

    Route::post('vendor_store/import-store', 'Admin\VendorStoreController@importStore')->name('admin.import-store');
    Route::get('vendor_store/export/store', 'Admin\VendorStoreController@exportStore')->name('admin.export.store');

    Route::resource('vendor_configuration', 'Admin\VendorConfigurationController')->except('show');
    Route::resource('vendor_coupons', 'Admin\VendorCouponsController')->except('show');
    Route::get('vendor_coupons/unverified', 'Admin\VendorCouponsController@unverifiedVendorCoupon');
    Route::get('vendor_coupons/verified/{id}', 'Admin\VendorCouponsController@verifiedVendorCoupon');
    Route::get('vendor_coupons/unverified_edit/{id}', 'Admin\VendorCouponsController@verifiedEditVendorCoupon');

    Route::resource('vendor_coupons_used', 'Admin\VendorCouponsUsedController')->except('show');
        Route::resource('vendor_payment', 'Admin\VendorPaymentController');
        Route::post('/vendor_payment/vendor_pay', 'Admin\VendorPaymentController@vendorPay')->name('admin.vendor_payment.vendor_pay');

    Route::resource('brand', 'Admin\BrandController');


        // supplier management **********************************************************************************************
        // Route::match(['get','post'],'supplier/add_role/{id}', 'Admin\SupplierController@addRole')->name('admin.add_role_supplier');
        Route::get('supplier/add_role/{id}', 'Admin\SupplierController@addRole')->name('admin.add_role_supplier');
        Route::post('supplier/supplier_add_role/{id}', 'Admin\SupplierController@supplierAddRole')->name('admin.supplier_add_role');
        Route::get('supplier/edit_role/{id}', 'Admin\SupplierController@editRole')->name('admin.edit_role_supplier');


        Route::post('supplier/import-supplier', 'Admin\SupplierController@importSupplier')->name('admin.import-supplier');
        Route::post('supplier/view/supplier_datatable', 'Admin\SupplierController@view')->name('admin.view.supplier_datatable');
        Route::get('supplier/export/supplier', 'Admin\SupplierController@exportSupplier')->name('admin.export.supplier');

        Route::post('supplier/get_supplier_import_preview', 'Admin\SupplierController@getImportPreview')->name('admin.get_supplier_import_preview');

        Route::post('supplier/update_role', 'Admin\SupplierController@updateRole')->name('admin.update_role_supplier');

        // Route::post('/supplier/get_supplier_import_preview', 'Admin\SupplierController@getImportPreview')->name('admin.get_supplier_import_preview');

        Route::get('supplier/delete_role/{id}', 'Admin\SupplierController@deleteRole')->name('admin.delete_role_supplier');
        Route::match(['get', 'post'], 'supplier/paid_modules/{id}', 'Admin\SupplierController@paidModules')->name('admin.paid_modules_supplier');

        Route::match(['get', 'post'], 'supplier/paid_modules/create/{id}', 'Admin\SupplierController@paidModulesCreate')->name('admin.paid_modules_supplier.create');

        Route::match(['get', 'post'], 'supplier/paid_modules/edit/{id}', 'Admin\SupplierController@paidModulesEdit')->name('admin.paid_modules_supplier.edit');

        //Route::get('supplier/approve/{supplier}', 'Admin\SupplierController@reviewUpdate');
        Route::get('supplier/approve/{id}', [SupplierController::class, 'approvedMailSupplier'])->name('approvedMailSupplier');
        Route::get('supplier/reject/{supplier}', 'Admin\SupplierController@reviewUpdate');
        Route::resource('supplier', 'Admin\SupplierController');

        Route::resource('supplier_category', 'Admin\SupplierCategoryController');

        Route::resource('supplier_store', 'Admin\SupplierStoreController');

        Route::post('supplier_store/import-store', 'Admin\SupplierStoreController@importStore')->name('admin.import-store-supplier');
        Route::get('supplier_store/export/store', 'Admin\SupplierStoreController@exportStore')->name('admin.export.store-supplier');

        Route::resource('supplier_configuration', 'Admin\SupplierConfigurationController')->except('show');
        Route::resource('supplier_coupons', 'Admin\SupplierCouponsController')->except('show');
        Route::get('supplier_coupons/unverified', 'Admin\SupplierCouponsController@unverifiedSupplierCoupon');
        Route::get('supplier_coupons/verified/{id}', 'Admin\SupplierCouponsController@verifiedSupplierCoupon');
        Route::get('supplier_coupons/unverified_edit/{id}', 'Admin\SupplierCouponsController@verifiedEditSupplierCoupon');

        Route::resource('supplier_coupons_used', 'Admin\SupplierCouponsUsedController')->except('show');
        Route::resource('supplier_payment', 'Admin\SupplierPaymentController');
        Route::post('/supplier_payment/supplier_pay', 'Admin\SupplierPaymentController@supplierPay')->name('admin.supplier_payment.supplier_pay');


    Route::resource('products', 'Admin\ProductsController')->except('show');
    Route::get('w2b_products', 'Admin\WbProductController@index')->name('admin.wbproducts');
    Route::get('w2b_products/orders', 'Admin\WbProductController@order')->name('admin.wbproducts.orders');
    Route::post('orders/post_shipping_details/{orderId?}/{productSku?}', 'Admin\WbProductController@postShippingDetails')->name('admin.orders.post_shipping_details');
    Route::get('orders/shipping_details/{orderId?}/{productSku?}', 'Admin\WbProductController@shippingDetails')->name('admin.orders.shipping_details');
    Route::get('/order/status/{orderId?}/{sku?}/{status?}', 'Admin\WbProductController@orderStatus')->name('admin.order-status-change');
    // Route::get('/wborder/shipped/{id}', 'Admin\WbProductController@shippedStatus')->name('admin.wbstatus.shipped');
    // Route::get('/wborder/status/{id}/{status?}','Admin\WbProductController@orderStatus')->name('wborder-status-change');
    Route::get('w2b_products/ordered_products/{id}', 'Admin\WbProductController@orderedProducts')->name('admin.wborderedproducts');
    Route::post('/products/remove_image/{id}', 'Admin\ProductsController@RemoveImage');
    Route::get('/products/add_attribute_set/{lnght}', 'Admin\ProductsController@addAttributeSet')->name('admin.add_attribute_set');
    Route::get('/products/get_attribute_values/{id}/{lnght}', 'Admin\ProductsController@getAttributeValues')->name('admin.get_attribute_values');

    Route::get('/products/product_cron', 'Admin\ProductsController@productCron')->name('admin.product_cron');

    Route::post('/products/get_import_preview', 'Admin\ProductsController@getImportPreview')->name('admin.get_import_preview');

    Route::get('/products/export-product', 'Admin\ProductsController@exportProduct')->name('admin.products.export-product');

    Route::get('products/inventory', 'Admin\ProductsController@inventory')->name('admin.products.inventory');
    Route::post('products/view_product_datatable', 'Admin\ProductsController@productDatatable')->name('admin.products.view_product_datatable');

    Route::post('products/get-inventory', 'Admin\ProductsController@getInventory')->name('admin.get-inventory');
    Route::post('products/update-quantity', 'Admin\ProductsController@updateQuantity')->name('admin.product-update-quantity');
    Route::post('products/update-discount', 'Admin\ProductsController@updateDiscount')->name('admin.product-update-discount');
    Route::post('products/update-price', 'Admin\ProductsController@updatePrice')->name('admin.product-update-price');
    Route::post('products/import-product', 'Admin\ProductsController@importProduct')->name('admin.import-product');
    Route::get('products/generate-barcodes', 'Admin\ProductsController@generateBarcodes')->name('admin.products.generate-barcodes');
    Route::post('products/get-barcode-products', 'Admin\ProductsController@getBarcodeProducts')->name('admin.products.get-barcode-products');
    Route::post('products/print-barcode', 'Admin\ProductsController@printBarcode')->name('admin.products.print-barcode');
    Route::get('products/product-status/{id}', 'Admin\ProductsController@productStatus')->name('admin.products.product-status');
    Route::get('vendor_coupons/coupon_status/{id}', 'Admin\VendorCouponsController@couponStatus')->name('admin.vendor_coupons.coupon_status');
    Route::get('vendor_coupons/view_used_coupon/{id}', 'Admin\VendorCouponsController@viewUsedCoupon')->name('admin.vendor_coupons.view_used_coupon');

    Route::resource('product_images', 'Admin\ProductImagesController')->except('show');
    Route::get('/product-gallery/{pid}', 'Admin\ProductImagesController@productGallery');
    Route::get('/addimage/{pid}', 'Admin\ProductImagesController@addimage');

    Route::resource('customer', 'Admin\CustomerController');
    Route::get('customer/customer-status/{id}', 'Admin\CustomerController@customerStatus')->name('admin.customer.customer-status');
    Route::get('customer/view/{id}', 'Admin\CustomerController@view')->name('admin.customer.view');

        Route::match(['get', 'post'], 'customer_incentive/{type}', 'Admin\CustomerIncentiveController@index')->name('admin.customer_incentive');

    Route::resource('orders', 'Admin\OrdersController');
        Route::get('order/inshop_order', 'Admin\OrdersController@inshop_order')->name('admin.order.inshop_order');
        Route::get('order/inshop_order_view/{id}', 'Admin\OrdersController@inshop_order_view')->name('admin.order.inshop_order_view');
        Route::get('order/pickup_order', 'Admin\OrdersController@pickup_order')->name('admin.order.pickup_order');
        Route::get('order/pickup_order_view/{id}', 'Admin\OrdersController@pickup_order_view')->name('admin.order.pickup_order_view');

    Route::resource('order_return', 'Admin\OrderReturnController');
        Route::get('order/return/request', 'Admin\OrderReturnController@orderReturnRequest')->name('admin.order.return.request');
        Route::get('order/return/request/show/{id}', 'Admin\OrderReturnController@orderReturnRequestShow')->name('admin.order.return.request.show');

        Route::post('order/pickup_order/change_status/{id}', 'Admin\OrdersController@pickupInshopChangeStatus')->name('admin.order.pickup_order.change_status');

    Route::resource('cancelled_orders', 'Admin\CancelledOrdersController');
    Route::resource('customer_feedback', 'Admin\CustomerFeedbackController');
    Route::resource('customer_reviews', 'Admin\CustomerReviewsController');
    Route::resource('customer_reward_points', 'Admin\CustomerRewardPointController')->only(['index', 'create', 'store']);
    Route::resource('customer_used_reward_points', 'Admin\CustomerRewardUsedController')->only(['index', 'create', 'store']);
    Route::resource('reward_used', 'Admin\CustomerRewardUsedController');
        Route::resource('support_ticket', 'Admin\SupportTicketController')->only(['index', 'create', 'store', 'show']);
        Route::post('support_ticket/support_ticket_notification', 'Admin\SupportTicketController@support_ticket_notification')->name('admin.support_ticket.support_ticket_notification');

    Route::resource('product_reviews', 'Admin\ProductReviewsController')->except('show');
    Route::resource('discount_offers', 'Admin\DiscountOffersController')->except('show');
    Route::resource('settings', 'Admin\SettingController')->only(['index', 'store']);
    Route::resource('suggested-place', 'Admin\SuggestedPlaceController');
    Route::post('/suggested-place/send/{id}', 'Admin\SuggestedPlaceController@send')->name('admin.suggested-place.send');
    Route::resource('order_reason', 'Admin\OrderReasonController');
    Route::resource('email_template', 'Admin\EmailTemplateController', ['as' => 'admin', 'only' => array('index', 'edit', 'update')]);

    Route::resource('blog', 'Admin\BlogController');
    Route::resource('admin_coupon', 'Admin\AdminCouponController');
    Route::put('admin_coupon/change_status/{id}', 'Admin\AdminCouponController@updateStatus')->name('admin_coupon.update-status');
    Route::get('generate-coupon-code', 'Admin\AdminCouponController@generate_coupon_code')->name('generate-coupon-code');

    });
});


// *******  Admin Routes End  **********






Route::group(['middleware' => array('supplierChecklist')], function () {
    Route::group(['prefix' => 'supplier'], function () {
        Route::match(['get', 'post'], '/home', 'Supplier\DashboardController')->name('home');

        Route::get('/login', 'Supplier\Auth\LoginController@showLoginForm')->name('supplier.login');
        Route::post('/login', 'Supplier\Auth\LoginController@login');
        Route::post('/logout', 'Supplier\Auth\LoginController@logout')->name('supplier.logout');

        Route::match(['get', 'post'], '/submit-otp/{token}', 'Supplier\Auth\LoginController@submitOTP');

        Route::post('/resend_otp_mail', 'Supplier\Auth\LoginController@resendOtpMail');


        Route::post('/password/email', 'Supplier\Auth\ForgotPasswordController@sendResetLinkEmail')->name('supplier.password.request');
        Route::post('/password/reset', 'Supplier\Auth\ResetPasswordController@reset')->name('supplier.password.email');
        Route::get('/password/reset', 'Supplier\Auth\ForgotPasswordController@showLinkRequestForm')->name('supplier.password.reset');
        Route::get('/password/reset/{token}', 'Supplier\Auth\ResetPasswordController@showResetForm');

        // supplier panel
        Route::resource('suppliers', 'Supplier\SupplierController');
        Route::post('suppliers/import-supplier', 'Supplier\SupplierController@importSupplier')->name('supplier.import-supplier');
        Route::post('suppliers/view/supplier_datatable', 'Supplier\SupplierController@view')->name('supplier.view.supplier_datatable');
        Route::get('suppliers/export/supplier', 'Supplier\SupplierController@exportSupplier')->name('supplier.export.supplier');
        Route::get('suppliers/login/history', 'Supplier\SupplierController@loginSupplierHistory')->name('supplier.login.history');
        Route::post('/suppliers/get_supplier_import_preview', 'Supplier\SupplierController@getImportPreview')->name('supplier.get_supplier_import_preview');
        Route::match(['get', 'post'], '/suppliers/set-store-permission/{id}', 'Supplier\SupplierController@setStorePermission')->name('supplier.set-store-permission');
        Route::post('suppliers/otp-supplier', 'Supplier\SupplierController@otpSupplier')->name('supplier.otp-supplier');
        //Route::post('suppliers/inventory_update_reminder_check/{id}', 'Supplier\SupplierController@inventoryUpdateReminderCheck')->name('supplier.inventory_update_reminder_check');
        //Route::get('checklist','Supplier\SupplierController@checklist')->name('supplier.checklist');
        Route::get('active-plans', 'Supplier\SupplierController@activePlan')->name('supplier.active-plan');
        Route::get('choose-plan', 'Supplier\SupplierController@choosePlan')->name('supplier.choose-plan');

        Route::get('choose-ruti-fullfill-page', 'Supplier\SupplierController@chooseRutiFullfillPage')->name('supplier.choose-ruti-fullfill-page');
        Route::get('choose-ruti-fullfill', 'Supplier\SupplierController@chooseRutiFullfill')->name('supplier.choose-ruti-fullfill');
        Route::post('ruti-fullfill-submit', 'Supplier\SupplierController@rutiFulfillSubmit')->name('ruti-fullfill-submit');
        Route::post('fulfill-with-wallet', 'Supplier\SupplierController@fulfillWithWallet')->name('fulfill-with-wallet');
        Route::post('supplier_fulfill', 'Supplier\SupplierController@supplierFulfill')->name('supplier_fulfill');
        Route::get('supplier-wallet', 'Supplier\SupplierController@supplierWallet')->name('supplier.wallet');
        Route::get('receive-wallet', 'Supplier\SupplierController@receiveWallet')->name('supplier.receive.wallet');
        Route::get('withdraw-wallet', 'Supplier\SupplierController@withdrawWallet')->name('supplier.withdraw.wallet');
        Route::post('withdraw-to-bank', 'Supplier\SupplierController@withdrawToBank')->name('withdraw-to-bank');
        Route::get('withdraw-thank-you', 'Supplier\SupplierController@withdrawThankYou')->name('withdraw-thank-you');
        Route::post('add-to-supplier-wallet', 'Supplier\SupplierController@addToWallet')->name('add-to-supplier-wallet');
        Route::post('/supplier-wallet-payment/{amount}', 'Supplier\SupplierController@supplierWalletPayment')->name('supplier-wallet-payment');



        Route::get('get-plan-by-interval-license/{interval}/{license?}', 'Supplier\SupplierController@getPlanByIntervalLicense')->name('supplier.get-plan-by-interval-license');
        Route::post('one-time-setup-fee/{store_id}', 'Supplier\SupplierController@oneTimeSetupFee')->name('supplier.one-time-setup-fee');
        Route::post('create-subscription', 'Supplier\SupplierController@createSubscription')->name('supplier.create-subscription');

        Route::post('ruti-fullfill-payment', 'Supplier\SupplierController@rutiPayment')->name('supplier.ruti-fullfill-payment');

        Route::get('payment-page/{id}', 'Supplier\SupplierController@paymentPage')->name('supplier.payment-page');
        // Route::get('ruti_fullfill_pay/{id}', 'Supplier\SupplierController@ruti_fullfill_pay')->name('supplier.payment-page');
        Route::post('change-subscription', 'Supplier\SupplierController@changeSubscription')->name('supplier.change-subscription');
        Route::get('get-subscription/{vendor_id}', 'Supplier\SupplierController@getSubscription')->name('supplier.get-subscription');
        Route::get('get-store-roles/{store_id}', 'Supplier\SupplierController@getStoreRoles')->name('supplier.get-store-roles');
        Route::delete('cancel-subscription/{id}', 'Supplier\SupplierController@cancelSubscription')->name('supplier.cancel-subscription');
        // Route::get('manage-supplier-card', 'Supplier\SupplierController@manageSupplierCard')->name('supplier.manage-supplier-card');
        Route::get('get-supplier-card', 'Supplier\SupplierController@getSupplierCard')->name('supplier.get-supplier-card');
        Route::match(['get', 'post'],'save-supplier-card', 'Supplier\SupplierController@saveSupplierCard')->name('supplier.save-supplier-card');
        Route::post('edit-supplier-card', 'Supplier\SupplierController@editSupplierCard')->name('supplier.edit-supplier-card');
        Route::post('set-supplier-default-card', 'Supplier\SupplierController@setSupplierDefaultCard')->name('supplier.set-supplier-default-card');
        Route::post('delete-supplier-card', 'Supplier\SupplierController@deleteSupplierCard')->name('supplier.delete-supplier-card');
        Route::get('get-assigned-coupon/{sid}', 'Supplier\SupplierController@getAssignedCoupon')->name('supplier.get-assigned-coupon');
        Route::post('complete-user-guide/{vid}', 'Supplier\SupplierController@completeUserGuide')->name('supplier.complete-user-guide');

        Route::post('stores/import-store', 'Supplier\SupplierStoreController@importStore')->name('supplier.import-store');
        Route::get('stores/export/store', 'Supplier\SupplierStoreController@exportStore')->name('supplier.export.store');

        Route::resource('stores', 'Supplier\SupplierStoreController', ['as' => 'supplier']);
        Route::resource('brand', 'Supplier\BrandController', ['as' => 'supplier']);

        Route::resource('products', 'Supplier\ProductsController', ['as' => 'supplier'])->except('show');
        Route::get('products/inventory', 'Supplier\ProductsController@inventory')->name('supplier.products.inventory');
        Route::get('products/inventory-upload', 'Supplier\ProductsController@inventoryUpload')->name('supplier.inventory.upload');
        Route::post('/import_parse', 'Supplier\ProductsController@parseImport')->name('import_parse');
        Route::post('/import_process', 'Supplier\ProductsController@processImport')->name('import_process');
        Route::post('products/get-inventory', 'Supplier\ProductsController@getInventory')->name('supplier.get-inventory');
        Route::post('products/update-quantity', 'Supplier\ProductsController@updateQuantity')->name('supplier.product-update-quantity');
        Route::post('products/update-discount', 'Supplier\ProductsController@updateDiscount')->name('supplier.product-update-discount');
        Route::post('products/update-price', 'Supplier\ProductsController@updatePrice')->name('supplier.product-update-price');

        Route::post('products/view_product_datatable', 'Supplier\ProductsController@productDatatable')->name('supplier.products.view_product_datatable');

        Route::get('products/export-product', 'Supplier\ProductsController@exportProduct')->name('supplier.products.export-product');

        Route::post('products/get-barcode-products', 'Supplier\ProductsController@getBarcodeProducts')->name('supplier.products.get-barcode-products');
        Route::post('/products/get_import_preview', 'Supplier\ProductsController@getImportPreview')->name('supplier.get_import_preview');

        Route::post('products/print-barcode', 'Supplier\ProductsController@printBarcode')->name('supplier.products.print-barcode');
        Route::get('products/product-status/{id}', 'Supplier\ProductsController@productStatus')->name('supplier.products.product-status');
        Route::get('customer/view/{id}', 'Supplier\CustomerController@view')->name('supplier.customer.view');
        Route::resource('customer', 'Supplier\CustomerController', ['as' => 'supplier'])->except(['edit', 'update', 'store', 'create']);

        Route::get('customer/customer-status/{id}', 'Supplier\CustomerController@customerStatus')->name('supplier.customer.customer-status');

        Route::resource('supplier_configuration', 'Supplier\SupplierConfigurationController', ['as' => 'supplier']);
        Route::resource('supplier_coupons', 'Supplier\SupplierCouponsController', ['as' => 'supplier']);
        Route::resource('supplier_coupons_used', 'Supplier\SupplierCouponsUsedController', ['as' => 'supplier']);

        Route::get('supplier_coupons/view_used_coupon/{id}', 'Supplier\SupplierCouponsController@viewUsedCoupon')->name('supplier.supplier_coupons.view_used_coupon');

        Route::resource('categories', 'Supplier\CategoryController', ['as' => 'supplier']);
        Route::resource('customer_feedback', 'Supplier\CustomerFeedbackController', ['as' => 'supplier']);
        Route::resource('customer_reviews', 'Supplier\CustomerReviewsController', ['as' => 'supplier']);
        Route::resource('customer_reward_points', 'Supplier\CustomerRewardPointController', ['as' => 'supplier']);
        Route::resource('customer_used_reward_points', 'Supplier\CustomerRewardUsedController', ['as' => 'supplier'])->only(['index', 'create', 'store']);

        Route::resource('orders', 'Supplier\OrdersController', ['as' => 'supplier'])->only('index', 'update');
        Route::get('supplier_shippo/{userId}/{sku}/{supplierId}', 'Supplier\OrdersController@supplierShippo')->name('supplier.supplier_shippo');

        Route::get('orders/shipping_details/{orderId?}/{productSku?}', 'Supplier\OrdersController@shippingDetails')->name('supplier.orders.shipping_details');
        Route::post('orders/post_shipping_details/{orderId?}/{productSku?}', 'Supplier\OrdersController@postShippingDetails')->name('supplier.orders.post_shipping_details');
        Route::get('/order/status/{orderId?}/{sku?}/{status?}', 'Supplier\OrdersController@orderStatus')->name('supplier.order-status-change');
        Route::get('orders/view_details/{id}', 'Supplier\OrdersController@view_details')->name('supplier.orders.view_details');
        Route::get('orders/view_order/{id}', 'Supplier\OrdersController@view_order')->name('supplier.orders.view_order');
        Route::resource('order_return', 'Supplier\OrderReturnController', ['as' => 'supplier']);
        Route::get('order_return/show_return/{orderId}/{ProductSku}', 'Supplier\OrderReturnController@showReturn')->name('supplier.orders.show-return');
        Route::get('orders/return/request', 'Supplier\OrderReturnController@orderReturnRequest')->name('supplier.orders.return.request');
        Route::get('orders/return/request/show/{id}', 'Supplier\OrderReturnController@orderReturnRequestShow')->name('supplier.orders.return.request.show');

        Route::resource('cancelled_orders', 'Supplier\CancelledOrdersController', ['as' => 'supplier']);
        Route::resource('attributes', 'Supplier\AttributeController', ['as' => 'supplier']);
        Route::resource('discount_offers', 'Supplier\DiscountOffersController', ['as' => 'supplier']);

        // marketplace routes
        Route::get('marketplace-orders', 'Supplier\OrdersController@marketplaceOrder')->name('supplier.marketplace-orders');
        Route::get('marketplace-orders/view_details/{id}', 'Supplier\OrdersController@marketplaceOrderDetail')->name('supplier.marketplace_orders.view_details');


        //        Route::resource('stores_supplier', 'Supplier\StoresSupplierController', ['as' => 'supplier']);
        Route::resource('supplier_roles', 'Supplier\RoleController', ['as' => 'supplier']);

        Route::get('supplier_roles/show/{id}', 'Supplier\RoleController@showRoleCustomer')->name('supplier.supplier_roles.show');
        Route::get('supplier_roles/delete/{id}', 'Supplier\RoleController@deleteRoleCustomer')->name('supplier.supplier_roles.delete');

        Route::post('suppliers/add_bank_detail', 'Supplier\SupplierController@addBankDetail')->name('supplier.add_bank_detail');

        // Route::get('suppliers/add_bank_detail/{id}','Supplier\SupplierController@loginSupplierHistory')->name('supplier.add_bank_detail');

        Route::get('/profile', 'Supplier\SupplierController@profile')->name('supplier.profile');
        Route::post('/profile', 'Supplier\SupplierController@editprofile')->name('supplier.profile');

        Route::post('/SettingController/{id}', 'Supplier\SupplierController@fullfill_type_change')->name('fullfill_type_change');

        Route::resource('product_reviews', 'Supplier\ProductReviewsController', ['as' => 'supplier']);

        Route::resource('newsletters', 'Supplier\NewsletterController', ['as' => 'supplier']);
        Route::post('/newsletters/send/{id}', 'Supplier\NewsletterController@send')->name('supplier.newsletters.send');
        Route::get('newsletters/get-user-newsletters/{id}', 'Supplier\NewsletterController@getUserNewsletters')->name('supplier.get-user-newsletters');

        Route::resource('push_notifications', 'Supplier\PushNotificationController', ['as' => 'supplier']);
        Route::post('/push_notifications/send/{id}', 'Supplier\PushNotificationController@send')->name('supplier.push_notifications.send');
        Route::get('push_notifications/get-user-notifications/{id}', 'Supplier\PushNotificationController@getUserNotification')->name('supplier.get-user-notifications');

        Route::match(['get', 'post'], '/customer_transaction', 'Supplier\TranscationController@customerTransaction')->name('customer_transaction.index');

        Route::resource('settings', 'Supplier\SettingController', ['as' => 'supplier'])->only(['index', 'store']);

        // Route::get('console/schedule', function () {
        //     Artisan::call('sendBuyerReminder:cron');
        //     return back()->with('success', 'Remainder email successfully sent to buyer');
        // })->name('setReminder');

        Route::post('/setReminderToBuyer', 'Supplier\SettingController@setReminderToBuyer')->name('setReminderToBuyer');

  });
});

Route::group(['middleware' => 'vendorChecklist'], function () {
Route::group(['prefix' => 'vendor'], function () {

  Route::get('/login', 'VendorAuth\LoginController@showLoginForm')->name('vendor.login');
  Route::post('/login', 'VendorAuth\LoginController@login');
  Route::post('/logout', 'VendorAuth\LoginController@logout')->name('vendor.logout');

        Route::match(['get', 'post'], '/submit-otp/{token}', 'VendorAuth\LoginController@submitOTP');


  Route::post('/resend_otp_mail', 'VendorAuth\LoginController@resendOtpMail');

  Route::get('/register', 'VendorAuth\RegisterController@showRegistrationForm')->name('vendor.register');
  Route::post('/register', 'VendorAuth\RegisterController@register');

  Route::post('/password/email', 'VendorAuth\ForgotPasswordController@sendResetLinkEmail')->name('vendor.password.request');
  Route::post('/password/reset', 'VendorAuth\ResetPasswordController@reset')->name('vendor.password.email');
  Route::get('/password/reset', 'VendorAuth\ForgotPasswordController@showLinkRequestForm')->name('vendor.password.reset');
  Route::get('/password/reset/{token}', 'VendorAuth\ResetPasswordController@showResetForm');

  Route::resource('vendors', 'Vendor\VendorController');
  Route::post('vendors/import-vendor', 'Vendor\VendorController@importVendor')->name('vendor.import-vendor');
  Route::post('vendors/view/vendor_datatable', 'Vendor\VendorController@view')->name('vendor.view.vendor_datatable');
  Route::get('vendors/export/vendor', 'Vendor\VendorController@exportVendor')->name('vendor.export.vendor');
        Route::get('vendors/login/history', 'Vendor\VendorController@loginVendorHistory')->name('vendor.login.history');
  Route::post('/vendors/get_vendor_import_preview', 'Vendor\VendorController@getImportPreview')->name('vendor.get_vendor_import_preview');
        Route::match(['get', 'post'], '/vendors/set-store-permission/{id}', 'Vendor\VendorController@setStorePermission')->name('vendor.set-store-permission');
  Route::post('vendors/otp-vendor', 'Vendor\VendorController@otpVendor')->name('vendor.otp-vendor');
  //Route::post('vendors/inventory_update_reminder_check/{id}', 'Vendor\VendorController@inventoryUpdateReminderCheck')->name('vendor.inventory_update_reminder_check');
  //Route::get('checklist','Vendor\VendorController@checklist')->name('vendor.checklist');
        Route::get('active-plans', 'Vendor\VendorController@activePlan')->name('vendor.active-plan');
        Route::get('choose-plan', 'Vendor\VendorController@choosePlan')->name('vendor.choose-plan');


        Route::get('marketplace-page', 'Vendor\VendorController@marketplacePage')->name('vendor.marketplace-page');
        Route::post('marketplace-store-payment', 'Vendor\VendorController@storePayment')->name('marketplace-store-payment');
        Route::post('marketplace-store-wallet-payment', 'Vendor\VendorController@marketplaceWalletPayment')->name('marketplace-store-wallet-payment');
        Route::post('marketplace/buy-products', 'Vendor\VendorController@buyProduct')->name('vendor.marketplace-buy-products');
        Route::get('marketplace-thank-you', 'Vendor\VendorController@thankYou')->name('marketplace-thank-you');
        Route::get('marketplace-page/product-search', 'Vendor\VendorController@productSearch')->name('vendor.product-search');
        Route::get('choose-ruti-fullfill-page', 'Vendor\VendorController@chooseRutiFullfillPage')->name('vendor.choose-ruti-fullfill-page');
        Route::get('choose-ruti-fullfill', 'Vendor\VendorController@chooseRutiFullfill')->name('vendor.choose-ruti-fullfill');
        Route::post('ruti-fullfill-submit', 'Vendor\VendorController@rutiFulfillSubmit')->name('vendor.ruti-fullfill-submit');
        Route::post('fulfill-with-wallet', 'Vendor\VendorController@fulfillWithWallet')->name('vendor.fulfill-with-wallet');
        Route::post('vendor_fulfill', 'Vendor\VendorController@vendorFulfill')->name('vendor_fulfill');
        Route::get('vendor-wallet', 'Vendor\VendorController@vendorWallet')->name('vendor.wallet');
        Route::get('receive-wallet', 'Vendor\VendorController@receiveWallet')->name('vendor.receive.wallet');
        Route::get('withdraw-wallet', 'Vendor\VendorController@withdrawWallet')->name('vendor.withdraw.wallet');
        Route::post('withdraw-to-bank', 'Vendor\VendorController@withdrawToBank')->name('vendor.withdraw-to-bank');
        Route::get('withdraw-thank-you', 'Vendor\VendorController@withdrawThankYou')->name('vendor.withdraw-thank-you');
        Route::post('add-to-vendor-wallet', 'Vendor\VendorController@addToWallet')->name('add-to-vendor-wallet');
        Route::post('/vendor-wallet-payment/{amount}', 'Vendor\VendorController@vendorWalletPayment')->name('vendor-wallet-payment');




        Route::get('get-plan-by-interval-license/{interval}/{license?}', 'Vendor\VendorController@getPlanByIntervalLicense')->name('vendor.get-plan-by-interval-license');
        Route::post('one-time-setup-fee/{store_id}', 'Vendor\VendorController@oneTimeSetupFee')->name('vendor.one-time-setup-fee');
        Route::post('create-subscription', 'Vendor\VendorController@createSubscription')->name('vendor.create-subscription');
        Route::post('change-subscription', 'Vendor\VendorController@changeSubscription')->name('vendor.change-subscription');
        Route::get('get-subscription/{store_id}', 'Vendor\VendorController@getSubscription')->name('vendor.get-subscription');
        Route::get('get-store-roles/{store_id}', 'Vendor\VendorController@getStoreRoles')->name('vendor.get-store-roles');
        Route::delete('cancel-subscription/{id}', 'Vendor\VendorController@cancelSubscription')->name('vendor.cancel-subscription');
  // Route::get('manage-vendor-card', 'Vendor\VendorController@manageVendorCard')->name('vendor.manage-vendor-card');
  Route::get('get-vendor-card', 'Vendor\VendorController@getVendorCard')->name('vendor.get-vendor-card');
  Route::post('save-vendor-card', 'Vendor\VendorController@saveVendorCard')->name('vendor.save-vendor-card');
  Route::post('edit-vendor-card', 'Vendor\VendorController@editVendorCard')->name('vendor.edit-vendor-card');
  Route::post('set-vendor-default-card', 'Vendor\VendorController@setVendorDefaultCard')->name('vendor.set-vendor-default-card');
  Route::post('delete-vendor-card', 'Vendor\VendorController@deleteVendorCard')->name('vendor.delete-vendor-card');
  Route::get('get-assigned-coupon/{sid}', 'Vendor\VendorController@getAssignedCoupon')->name('vendor.get-assigned-coupon');
  Route::post('complete-user-guide/{vid}', 'Vendor\VendorController@completeUserGuide')->name('vendor.complete-user-guide');

  Route::post('stores/import-store', 'Vendor\VendorStoreController@importStore')->name('vendor.import-store');
  Route::get('stores/export/store', 'Vendor\VendorStoreController@exportStore')->name('vendor.export.store');

  Route::resource('stores', 'Vendor\VendorStoreController', ['as' => 'vendor']);
  Route::resource('brand', 'Vendor\BrandController', ['as' => 'vendor']);

  Route::resource('products', 'Vendor\ProductsController', ['as' => 'vendor'])->except('show');
  Route::get('products/inventory', 'Vendor\ProductsController@inventory')->name('vendor.products.inventory');

  Route::get('products/inventory-upload', 'Vendor\ProductsController@inventoryUpload')->name('vendor.inventory.upload');
  Route::post('/import_parse', 'Vendor\ProductsController@parseImport')->name('vendor.import_parse');
  Route::post('/import_process', 'Vendor\ProductsController@processImport')->name('vendor.import_process');

  Route::post('products/get-inventory', 'Vendor\ProductsController@getInventory')->name('vendor.get-inventory');
  Route::post('products/update-quantity', 'Vendor\ProductsController@updateQuantity')->name('vendor.product-update-quantity');
  Route::post('products/update-discount', 'Vendor\ProductsController@updateDiscount')->name('vendor.product-update-discount');
  Route::post('products/update-price', 'Vendor\ProductsController@updatePrice')->name('vendor.product-update-price');
  Route::post('products/import-product', 'Vendor\ProductsController@importProduct')->name('vendor.import-product');
  Route::get('products/generate-barcodes', 'Vendor\ProductsController@generateBarcodes')->name('vendor.products.generate-barcodes');

  Route::post('products/view_product_datatable', 'Vendor\ProductsController@productDatatable')->name('vendor.products.view_product_datatable');

  Route::get('products/export-product', 'Vendor\ProductsController@exportProduct')->name('vendor.products.export-product');

  Route::post('products/get-barcode-products', 'Vendor\ProductsController@getBarcodeProducts')->name('vendor.products.get-barcode-products');
  Route::post('/products/get_import_preview', 'Vendor\ProductsController@getImportPreview')->name('vendor.get_import_preview');
  Route::get('/products/get_attribute_values/{id}/{lnght}', 'Vendor\ProductsController@getAttributeValues')->name('vendor.get_attribute_values');

  Route::post('products/print-barcode', 'Vendor\ProductsController@printBarcode')->name('vendor.products.print-barcode');
  Route::get('products/product-status/{id}', 'Vendor\ProductsController@productStatus')->name('vendor.products.product-status');
        Route::resource('customer', 'Vendor\CustomerController', ['as' => 'vendor'])->except('edit', 'update', 'store', 'create');

  Route::get('customer/view/{id}', 'Vendor\CustomerController@view')->name('vendor.customer.view');
  Route::get('customer/customer-status/{id}', 'Vendor\CustomerController@customerStatus')->name('vendor.customer.customer-status');

  Route::resource('vendor_configuration', 'Vendor\VendorConfigurationController', ['as' => 'vendor']);
  Route::resource('vendor_coupons', 'Vendor\VendorCouponsController', ['as' => 'vendor']);
  Route::resource('vendor_coupons_used', 'Vendor\VendorCouponsUsedController', ['as' => 'vendor']);

  Route::get('vendor_coupons/view_used_coupon/{id}', 'Vendor\VendorCouponsController@viewUsedCoupon')->name('vendor.vendor_coupons.view_used_coupon');

  Route::resource('categories', 'Vendor\CategoryController', ['as' => 'vendor']);
  Route::resource('customer_feedback', 'Vendor\CustomerFeedbackController', ['as' => 'vendor']);
  Route::resource('customer_reviews', 'Vendor\CustomerReviewsController', ['as' => 'vendor']);
  Route::resource('customer_reward_points', 'Vendor\CustomerRewardPointController', ['as' => 'vendor']);
  Route::resource('customer_used_reward_points', 'Vendor\CustomerRewardUsedController', ['as' => 'vendor'])->only(['index', 'create', 'store']);

  Route::resource('orders', 'Vendor\OrdersController', ['as' => 'vendor'])->except('show');

        Route::get('orders/view_order/{id}', 'Vendor\OrdersController@view_order')->name('vendor.orders.view_order');
        Route::get('orders/view_detail/{id}', 'Vendor\OrdersController@view_details')->name('vendor.orders.view_details');
        Route::get('/order/status/{orderId?}/{sku?}/{status?}', 'Vendor\OrdersController@orderStatus')->name('vendor.order-status-change');
        Route::get('orders/shipping_details/{orderId?}/{productSku?}', 'Vendor\OrdersController@shippingDetails')->name('vendor.orders.shipping_details');
        Route::post('orders/post_shipping_details/{orderId?}/{productSku?}', 'Vendor\OrdersController@postShippingDetails')->name('vendor.orders.post_shipping_details');
        Route::get('orders/inshop_order', 'Vendor\OrdersController@inshop_order')->name('vendor.orders.inshop_order');
        Route::get('orders/inshop_order_view/{id}', 'Vendor\OrdersController@inshop_order_view')->name('vendor.orders.inshop_order_view');
        Route::get('orders/pickup_order', 'Vendor\OrdersController@pickup_order')->name('vendor.orders.pickup_order');
        Route::get('orders/pickup_order_view/{id}', 'Vendor\OrdersController@pickup_order_view')->name('vendor.orders.pickup_order_view');
        Route::post('orders/pickup_order/change_status/{id}', 'Vendor\OrdersController@pickupInshopChangeStatus')->name('vendor.orders.pickup_order.change_status');
        Route::resource('order_return', 'Vendor\OrderReturnController', ['as' => 'vendor']);
        Route::get('order_return/show_return/{orderId}/{ProductSku}', 'Vendor\OrderReturnController@showReturn')->name('vendor.orders.show-return');

        Route::get('orders/return/request', 'Vendor\OrderReturnController@orderReturnRequest')->name('vendor.orders.return.request');
        Route::get('orders/return/request/show/{id}', 'Vendor\OrderReturnController@orderReturnRequestShow')->name('vendor.orders.return.request.show');

  Route::resource('cancelled_orders', 'Vendor\CancelledOrdersController', ['as' => 'vendor']);
  Route::resource('attributes', 'Vendor\AttributeController', ['as' => 'vendor']);
  Route::resource('discount_offers', 'Vendor\DiscountOffersController', ['as' => 'vendor']);

  Route::resource('stores_vendor', 'Vendor\StoresVendorController', ['as' => 'vendor']);
  Route::resource('vendor_roles', 'Vendor\RoleController', ['as' => 'vendor']);

        Route::get('vendor_roles/show/{id}', 'Vendor\RoleController@showRoleCustomer')->name('vendor.vendor_roles.show');
        Route::get('vendor_roles/delete/{id}', 'Vendor\RoleController@deleteRoleCustomer')->name('vendor.vendor_roles.delete');

        Route::post('vendors/add_bank_detail', 'Vendor\VendorController@addBankDetail')->name('vendor.add_bank_detail');

  // Route::get('vendors/add_bank_detail/{id}','Vendor\VendorController@loginVendorHistory')->name('vendor.add_bank_detail');

  Route::get('/profile', 'Vendor\VendorController@profile')->name('vendor.profile');
  Route::post('/profile', 'Vendor\VendorController@editprofile')->name('vendor.profile');
        Route::resource('product_reviews', 'Vendor\ProductReviewsController', ['as' => 'vendor']);

  Route::resource('newsletters', 'Vendor\NewsletterController', ['as' => 'vendor']);
  Route::post('/newsletters/send/{id}', 'Vendor\NewsletterController@send')->name('vendor.newsletters.send');
  Route::get('newsletters/get-user-newsletters/{id}', 'Vendor\NewsletterController@getUserNewsletters')->name('vendor.get-user-newsletters');

  Route::resource('push_notifications', 'Vendor\PushNotificationController', ['as' => 'vendor']);
  Route::post('/push_notifications/send/{id}', 'Vendor\PushNotificationController@send')->name('vendor.push_notifications.send');
  Route::get('push_notifications/get-user-notifications/{id}', 'Vendor\PushNotificationController@getUserNotification')->name('vendor.get-user-notifications');

        Route::match(['get', 'post'], '/customer_transaction', 'Vendor\TranscationController@customerTransaction')->name('customer_transaction.index');

  Route::resource('settings', 'Vendor\SettingController', ['as' => 'vendor'])->only(['index', 'store']);

});
});

Route::group(['prefix' => 'employee'], function () {
  Route::get('/login', 'EmployeeAuth\LoginController@showLoginForm')->name('employee.login');
  Route::post('/login', 'EmployeeAuth\LoginController@login');
  Route::post('/logout', 'EmployeeAuth\LoginController@logout')->name('employee.logout');

  Route::get('/register', 'EmployeeAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'EmployeeAuth\RegisterController@register');

  Route::post('/password/email', 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'EmployeeAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'EmployeeAuth\ResetPasswordController@showResetForm');

    Route::match(['get', 'post'], '/header', 'Employee\EmployeeController@pageHeader')->name('pagemeta.header');

    Route::match(['get', 'post'], '/about', 'Employee\EmployeeController@about')->name('pagemeta.about');

    Route::match(['get', 'post'], '/vendors', 'Employee\EmployeeController@vendors')->name('pagemeta.vendors');
  Route::get('/remove-vendors/{id}', 'Employee\EmployeeController@removeVendors')->name('pagemeta.remove-vendors');

    Route::match(['get', 'post'], '/features', 'Employee\EmployeeController@features')->name('pagemeta.features');
  Route::get('/remove-feature/{id}', 'Employee\EmployeeController@removeFeature')->name('pagemeta.remove-feature');

    Route::match(['get', 'post'], '/faq', 'Employee\EmployeeController@faq')->name('pagemeta.faq');
  Route::get('/remove-faq/{id}', 'Employee\EmployeeController@removeFaq')->name('pagemeta.remove-faq');

    Route::match(['get', 'post'], '/downloads', 'Employee\EmployeeController@downloads')->name('pagemeta.downloads');

    Route::match(['get', 'post'], '/client-feedback', 'Employee\EmployeeController@clientFeedback')->name('pagemeta.client-feedback');
  Route::get('/remove-client-feedback/{id}', 'Employee\EmployeeController@removeClentFeedback')->name('pagemeta.remove-client-feedback');

    Route::match(['get', 'post'], '/footer', 'Employee\EmployeeController@pageFooter')->name('pagemeta.footer');

    Route::match(['get', 'post'], '/dmca', 'Employee\EmployeeController@dmca')->name('pagemeta.dmca');
  Route::get('/remove-dmca/{id}', 'Employee\EmployeeController@removeDmca')->name('pagemeta.remove-dmca');

    Route::match(['get', 'post'], '/terms-conditions', 'Employee\EmployeeController@termsConditions')->name('pagemeta.terms-conditions');
  Route::get('/remove-terms-conditions/{id}', 'Employee\EmployeeController@removeTermsConditions')->name('pagemeta.remove-terms-conditions');

    Route::match(['get', 'post'], '/privacy-policy', 'Employee\EmployeeController@privacyPolicy')->name('pagemeta.privacy-policy');
  Route::get('/remove-privacy-policy/{id}', 'Employee\EmployeeController@removePrivacyPolicy')->name('pagemeta.remove-privacy-policy');
});


Route::group(['prefix' => 'w2bcustomer'], function () {
    Route::get('/login', 'W2bCustomerAuth\LoginController@showLoginForm')->name('w2bcustomer.login');
    Route::post('/login', 'W2bCustomerAuth\LoginController@login');
    Route::post('/logout', 'W2bCustomerAuth\LoginController@logout')->name('w2bcustomer.logout');
    // Route::post('/logout', 'EmployeeAuth\LoginController@logout')->name('employee.logout');


    Route::post('/password/email', 'W2bCustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('w2bcustomer.password.request');
    Route::post('/password/reset', 'W2bCustomerAuth\ResetPasswordController@reset')->name('w2bcustomer.password.email');
    Route::get('/password/reset', 'W2bCustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('w2bcustomer.password.reset');
    Route::get('/password/reset/{token}', 'W2bCustomerAuth\ResetPasswordController@showResetForm');


    Route::get('/register', 'W2bCustomerAuth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'W2bCustomerAuth\RegisterController@register');
    Route::get('/auth/fb', 'W2bCustomerAuth\LoginController@authFacebook')->name('auth.facebook');
    Route::get('/auth/google', 'W2bCustomerAuth\LoginController@authGoogle')->name('auth.google');
    Route::get('/auth/fb/callback', 'W2bCustomerAuth\LoginController@fbCallback')->name('facebook.callback');
    Route::get('/auth/google/callback', 'W2bCustomerAuth\LoginController@googleCallback')->name('google.callback');

    // Route::post('/password/email', 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    // Route::post('/password/reset', 'EmployeeAuth\ResetPasswordController@reset')->name('password.email');
    // Route::get('/password/reset', 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    // Route::get('/password/reset/{token}', 'EmployeeAuth\ResetPasswordController@showResetForm');


  });



