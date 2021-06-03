<?php

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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	if(\auth()->check()) {
		return redirect('/reports');
	}

    return view('login');
})->name('login');

Route::get('/signup', 'Auth\RegisterController@index');

Route::get('/forgot-password', 'Auth\ForgotPasswordController@index');
Route::post('/forgot-password', 'Auth\ForgotPasswordController@post');

Route::get('/forgot-password/{token}', 'Auth\ForgotPasswordController@verify');
Route::post('/forgot-password/{token}', 'Auth\ForgotPasswordController@verifyPost');

Route::post('/signup', 'Auth\RegisterController@post');


Route::get('/logout', function() {
	\auth()->logout();

	return redirect('/');
});
Route::any('/payment/webhook', 'WebHookController@webhook');
Route::get('/cronjobs', 'CronController@fire');

Route::get('/cronjobsone', 'CronController@cron_one');

Route::get('/cronjobstwo', 'CronController@cron_two');

Route::post('/', 'Auth\LoginController@login');

Route::get('/form/{link}', 'FormsController@viewForm');
Route::post('/form/{link}', 'FormsController@viewFormPost');

Route::get('/contact-form/{link}', 'ContactsController@viewForm');
Route::post('/contact-form/{link}', 'ContactsController@viewFormPost');

Route::post('/contact-form-success', 'ContactsController@success');

Route::get('/form/{link}/{order_id}/invoice', 'FormsController@viewInvoice');

Route::get('/view_invoice/{invoice}/{order_id}', 'FormsController@viewInvoiceByInvoiceNumber');

// Protected routes
Route::group(['middleware' => ['auth']], function() {
// Editors
Route::post('/store/editor', 'EditorController@store')->name('editor.store');
Route::get('/editor', 'EditorController@index')->name('editor');
Route::get('/editor/create', 'EditorController@show')->name('editor.create');
Route::any('/editor/update/{id}', 'EditorController@update')->name('page.update');
Route::get('/editor-page{id}', 'EditorController@single')->name('single.editor');
Route::post('/editor/upload', 'EditorController@upload')->name('editor.upload');
Route::get('/editor/delete/{id}', 'EditorController@destroy')->name('editor.delete');
Route::get('/editor/trash', 'EditorController@trashed')->name('editor.trash');
Route::get('/editor/kill/{id}', 'EditorController@kill')->name('editor.kill');

   // Reports
   Route::get('/reports', 'ReportsController@index')->name('home');

   Route::get('/revenue', 'ReportsController@revenue');

    Route::get('/contacts', 'ContactsController@index');

    Route::get('/entries', 'ContactsController@entries');

    Route::get('/contacts/create', 'ContactsController@create');
    Route::post('/contacts/create', 'ContactsController@createPost');

    Route::get('/contacts/edit/{id}', 'ContactsController@edit');
    Route::post('/contacts/edit/{id}', 'ContactsController@editPost');

    Route::get('/contacts/delete/{id}', 'ContactsController@delete');

   // Orders
   Route::get('/orders', 'OrdersController@orders');
   Route::get('/orders/new', 'OrdersController@newOrder');
   Route::post('/orders/new', 'OrdersController@newOrderPost');

   Route::get('/orders/edit/{id}', 'OrdersController@edit_orders_get');
   Route::post('/orders/edit/{id}', 'OrdersController@edit_orders_post');

   Route::get('/orders/edit/choose_form/{id}', 'OrdersController@choose_form_get');
   Route::post('/orders/edit/choose_form/{id}', 'OrdersController@choose_form_post');

   Route::get('/orders/delete/{id}', 'OrdersController@delete_orders');

   Route::post('/orders/comment', 'OrdersController@comment_order');

   // Waybill Generate
   Route::get('/waybill/generate', 'WaybillController@generateView');
   Route::post('/api/waybill/generate', 'WaybillController@generatePost');

   Route::post('/api/sendBulkMessage', 'Controller@sendBulkMessage');
   Route::post('/api/sendmessage', 'Controller@sendmessage');
   // View Waybills
   Route::get('/waybills/view/all', 'WaybillController@viewWaybills');
   Route::get('/waybills/view/{code}', 'WaybillController@viewWaybill');

   Route::get('/waybills/edit/{code}', 'WaybillController@editWaybills');
   Route::post('/api/waybill/edit/{code}', 'WaybillController@editWaybillsPost');

   Route::get('/waybills/delete/{code}', 'WaybillController@deleteWaybills');

   // Users
   Route::get('/users', 'UsersController@all');
   Route::get('/users/add', 'UsersController@add_user');
   Route::post('/users/add', 'UsersController@add_user_post');

   Route::get('/users/edit/{id}', 'UsersController@edit_user');
   Route::post('/users/edit/{id}', 'UsersController@edit_user_post');

   Route::get('/users/reset/{id}', 'UsersController@reset_user');

   Route::get('/users/disable/{id}', 'UsersController@disable_user');
   Route::get('/users/enable/{id}', 'UsersController@enable_user');

   Route::get('/users/delete/{id}', 'UsersController@delete_user');

   // Profile
   Route::get('/profile', 'ProfileController@profile');

   Route::post('/profile/update_account', 'ProfileController@update_account_post');
   Route::post('/profile/change_password', 'ProfileController@change_password');
   Route::post('/profile/update-account-info', 'ProfileController@update_bank_info');
   Route::post('/profile/upload_dp', 'ProfileController@upload_dp');

   Route::get('/forms', 'FormsController@index');

   Route::get('/forms/create', 'FormsController@add_forms');
   Route::post('/forms/create', 'FormsController@add_forms_post');

   Route::get('/forms/edit/{id}', 'FormsController@edit');
   Route::post('/forms/edit/{id}', 'FormsController@editPost');
   Route::get('/forms/delete/{id}', 'FormsController@delete');

   // Wallet
   Route::get('/wallet', 'WalletController@index');
   Route::get('/wallet/fund', 'WalletController@fund');
   Route::post('/wallet/fundPost', 'WalletController@fundPost');

   Route::get('/wallet/verify-payment/{reference}', 'WalletController@verifyPayment')
    ->name('verify-transaction');

   Route::get('/wallet/webhook', 'WalletController@verifyPaymentWebhook');

   Route::get('/wallet/usage', 'WalletController@wallet_usage');

   Route::get('/wallet/transfer', 'WalletController@transfer');
   Route::post('/wallet/transfer', 'WalletController@transferPost');

   Route::get('/wallet/withdraw', 'WalletController@withdraw');
   Route::post('/wallet/withdraw', 'WalletController@withdrawPost');

   Route::group(['prefix' => 'withdrawals'], function() {
       Route::post('/get-bank-info', 'WithdrawalController@getBankInfo');
   });

   Route::get('/message/history', 'Controller@message_history');

   Route::get('/business', 'BusinessController@index');
   Route::get('/business/add', 'BusinessController@add');
   Route::post('/business/add', 'BusinessController@addPost');

   Route::post('/business/upload_dp', 'BusinessController@upload_dp');

   Route::post('/business', 'BusinessController@post');

   Route::group(['prefix' => 'referral'], function() {
       Route::get('/', 'ReferralsController@index');
       Route::post('/generate-code', 'ReferralsController@generateCode');
       Route::get('/users', 'ReferralsController@referredUsers');
   });

   Route::get('/subscription', 'SubscriptionController@subscription')
        ->name('business-subscription');

    Route::get('/subscription/free', 'SubscriptionController@free');
    Route::get('/subscription/upgrade/{id}', 'SubscriptionController@upgrade');

   // Admin
   Route::get('/admin', 'AdminController@index');

   Route::get('/admin/customers', 'AdminController@customers');
    Route::get('/admin/customers/entries/form/{id}', 'AdminController@formEntriescustomers');

   Route::post('/admin/customers/edit/{id}', 'AdminController@edit_customers_post');
   Route::get('/admin/customers/delete/{id}', 'AdminController@delete_customers');

    Route::get('/admin/todos', 'AdminController@todos');

   Route::get('/admin/products', 'AdminController@products');
   Route::get('/admin/products/add', 'AdminController@add_products');
   Route::post('/admin/products/add', 'AdminController@add_products_post');

   Route::get('/admin/products/edit/{id}', 'AdminController@edit_products');
   Route::post('/admin/products/edit/{id}', 'AdminController@edit_products_post');
   Route::get('/admin/products/delete/{id}', 'AdminController@delete_products');

   Route::get('/admin/forms', 'FormsController@index');
   Route::get('/admin/forms/add', 'FormsController@add_forms');
   Route::post('/admin/forms/add', 'FormsController@add_forms_post');

   Route::get('/admin/forms/edit/{id}', 'FormsController@edit');
   Route::post('/admin/forms/edit/{id}', 'FormsController@editPost');
   Route::get('/admin/forms/delete/{id}', 'FormsController@delete');

   Route::get('/admin/deliverytime', 'AdminController@deliverytime');
   Route::get('/admin/deliverytime/add', 'AdminController@add_deliverytime');
   Route::post('/admin/deliverytime/add', 'AdminController@add_deliverytimePost');

   Route::get('/admin/deliverytime/edit/{id}', 'AdminController@edit_deliverytime');
   Route::post('/admin/deliverytime/edit/{id}', 'AdminController@edit_deliverytimePost');

   Route::get('/admin/deliverytime/delete/{id}', 'AdminController@delete_deliverytime');

   Route::get('/admin/deliverytime/hide/{id}', 'AdminController@hide_deliverytime');
   Route::get('/admin/deliverytime/unhide/{id}', 'AdminController@unhide_deliverytime');

   Route::get('/admin/whatsapp_numbers', 'AdminController@whatsapp_numbers');

   Route::get('/admin/whatsapp_numbers/add', 'AdminController@add_whatsapp_numbers');
   Route::post('/admin/whatsapp_numbers/add', 'AdminController@add_whatsapp_numbers_process');

   Route::get('/admin/whatsapp_numbers/edit/{id}', 'AdminController@edit_whatsapp_number');
   Route::post('/admin/whatsapp_numbers/edit/{id}', 'AdminController@edit_whatsapp_number_process');

   // Protected routes
   Route::group(['prefix' => 'staffpanel'], function() {
        Route::get('/', 'StaffpanelController@index');
   });

    // Store Routes
    Route::get('/store', 'StoreController@index');
    Route::get('/store/setup', 'StoreController@setup');
    Route::post('/store/setup', 'StoreController@setupPost');

    Route::get('/store/settings', 'StoreController@settings');
    Route::post('/store/settings', 'StoreController@settingsPost');

    Route::get('/store/items', 'StoreController@items');
    Route::get('/store/items/add', 'StoreController@itemsAdd');
    Route::post('/store/items/add', 'StoreController@itemsPost');

    Route::get('/store/items/hide/{id}', 'StoreController@hideItem');
    Route::get('/store/items/unhide/{id}', 'StoreController@unhideItem');

    Route::get('/store/items/edit/{id}', 'StoreController@itemsEdit');
    Route::post('/store/items/edit/{id}','StoreController@itemsEditPost');

    Route::get('/store/items/delete/{id}', 'StoreController@itemsDelete');

    Route::get('/store/items/duplicate/{id}', 'StoreController@duplicateItem');
});


Route::group(array('domain' => '{slug}.orderbank.com.ng'), function() {
    Route::get('/', 'StoreController@view');
    Route::get('{item_id}/{item_slug}', 'StoreController@viewItem');
});

Route::get('/store/i/{slug}', 'StoreController@view');
Route::get('/store/i/{slug}/{item_id}/{item_slug}', 'StoreController@viewItem');

Route::post('/todos','TodosController@store');

/**
 * Global Admin Routes
 */
Route::group(['prefix' => 'gadmin', 'middleware' => ['gadmin']], function() {
    // Index
    Route::get('/', 'GlobalAdminController@index');
    // Businesses
    Route::get('/businesses', 'GlobalAdminController@businesses');

    // Update Business Details
    Route::get('/businesses/update/business_details/{id}', 'GlobalAdminController@businesses_update_details');
    Route::get('/businesses/all', 'BusinessController@all')->name('business.view');

    Route::get('/businesses/trash/{id}', 'BusinessController@access_destroy')->name('business.delete');
    Route::get('/businesses/delete/kill/{id}', 'BusinessController@access_kill')->name('business.kill');
    Route::get('/businesses/access/{id}', 'BusinessController@access')->name('business.access');
    Route::post('/businesses/update/business_details/{id}', 'GlobalAdminController@businesses_update_details_post');
    // Update Profile Details
    Route::get('/businesses/update/profile_details/{id}', 'GlobalAdminController@businesses_update_profile_details');
    Route::post('/businesses/update/profile_details/{id}', 'GlobalAdminController@businesses_update_profile_details_post');

    // Delete Business
    Route::get('/businesses/delete/{id}', 'GlobalAdminController@businesses_delete');
    // Ban Business
    Route::get('/businesses/ban/{id}', 'GlobalAdminController@businesses_ban');
    Route::get('/businesses/unban/{id}', 'GlobalAdminController@businesses_unban');

    Route::get('/businesses', 'GlobalAdminController@businesses');
    // Products
    Route::get('/products', 'GlobalAdminController@products');

    Route::get('/products/edit/{id}', 'GlobalAdminController@edit_product');
    Route::post('/products/edit/{id}', 'GlobalAdminController@edit_product_post');

    Route::get('/products/delete/{id}', 'GlobalAdminController@delete_product');

    Route::get('/products/hide/{id}', 'GlobalAdminController@hide_product');
    Route::get('/products/unhide/{id}', 'GlobalAdminController@unhide_product');

    Route::get('/products/disable/{id}', 'GlobalAdminController@disable_product');
    Route::get('/products/enable/{id}', 'GlobalAdminController@enable_product');

    // Forms
    Route::get('/forms', 'GlobalAdminController@forms');

    Route::get('/forms/edit/{id}', 'GlobalAdminController@edit_form');
    Route::post('/forms/edit/{id}', 'GlobalAdminController@edit_form_post');

    Route::get('/forms/delete/{id}', 'GlobalAdminController@delete_form');

    Route::get('/forms/hide/{id}', 'GlobalAdminController@hide_form');
    Route::get('/forms/unhide/{id}', 'GlobalAdminController@unhide_form');

    Route::get('/forms/disable/{id}', 'GlobalAdminController@disable_form');
    Route::get('/forms/enable/{id}', 'GlobalAdminController@enable_form');

    // Delivery Time
    Route::get('/delivery_time', 'GlobalAdminController@delivery_time');

    Route::get('/delivery_time/edit/{id}', 'GlobalAdminController@edit_delivery_time');
    Route::post('/delivery_time/edit/{id}', 'GlobalAdminController@edit_delivery_time_post');

    Route::get('/delivery_time/delete/{id}', 'GlobalAdminController@delete_delivery_time');

    Route::get('/delivery_time/hide/{id}', 'GlobalAdminController@hide_delivery_time');
    Route::get('/delivery_time/unhide/{id}', 'GlobalAdminController@unhide_delivery_time');

    Route::get('/delivery_time/disable/{id}', 'GlobalAdminController@disable_delivery_time');
    Route::get('/delivery_time/enable/{id}', 'GlobalAdminController@enable_delivery_time');

    // Reports - Revenue
    Route::get('/reports/revenue', 'GlobalAdminController@revenue');
    // Reports - Message logs
    Route::get('/reports/message_logs', 'GlobalAdminController@message_logs');
    Route::get('/reports/message_logs/clear', 'GlobalAdminController@clear_message_logs');

    // Stores
    Route::get('/stores', 'GlobalAdminController@stores');

    Route::get('/stores/edit/{id}', 'GlobalAdminController@edit_store');
    Route::post('/stores/edit/{id}', 'GlobalAdminController@edit_store_post');

    Route::get('/stores/delete/{id}', 'GlobalAdminController@delete_store');

    Route::get('/stores/hide/{id}', 'GlobalAdminController@hide_store');
    Route::get('/stores/unhide/{id}', 'GlobalAdminController@unhide_store');

    Route::get('/stores/disable/{id}', 'GlobalAdminController@disable_store');
    Route::get('/stores/enable/{id}', 'GlobalAdminController@enable_store');

    Route::get('/referrals', 'GlobalAdminController@referrals');

});

Route::group(['domain' => '{slug}.orderbank.com.ng'], function() {
    Route::get('/', 'EditorController@view')->name('editor.path');
});
