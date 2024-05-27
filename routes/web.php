<?php

use App\Http\Controllers\admin\CuisineController;
use App\Http\Middleware\CheckStatus;
use Illuminate\Support\Facades\Route;
use App\Models\admin\Appurl;

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

Route::get('/', function () {
    return redirect('login');
});
Route::get('/app.html', function () {
    $data['geturldata'] = Appurl::first();
    return view('welcome', $data);
});
Route::get('/cc', function () {
    Artisan::call('cache:clear');
    echo '<script>alert("cache clear Success")</script>';
});
Route::get('/ccc', function () {
    Artisan::call('config:cache');
    echo '<script>alert("config cache Success")</script>';
});
Route::get('/cccc', function () {
    Artisan::call('config:clear');
    echo '<script>alert("config clear Success")</script>';
});

// for test cronjob run or not on server
Route::namespace('App\Http\Controllers\Cronjob')->group(function () {
    Route::get('user-tableready', 'CronJobController@usertableReady');
    Route::get('checkResturentsubscription', 'CronJobController@checkResturentsubscription');
    Route::get('sendOrderNotification', 'CronJobController@sendOrderNotification');
    Route::get('sendDateNotification', 'CronJobController@sendDateNotification');
    Route::get('tableOneDayNotification', 'CronJobController@tableOneDayNotification');
    Route::get('tableFiveHoursNotification', 'CronJobController@tableFiveHoursNotification');
});

Route::get('privacy-policy', 'App\Http\Controllers\admin\FoodCmsController@index')->name('privacy-policy');
Route::get('cookies', 'App\Http\Controllers\admin\FoodCmsController@list')->name('cookies');
Route::get('terms-conditions', 'App\Http\Controllers\admin\FoodCmsController@terms')->name('terms-conditions');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['namespace' => 'App\Http\Controllers\Auth'], function ($admins) {
    Route::get('/register-owner', 'LoginController@register_owner')->name('register-owner');
    Route::post('/check_owner_register_email', 'LoginController@check_owner_register_email')->name('check_owner_register_email');
    Route::post('/check_owner_register_phone', 'LoginController@check_owner_register_phone')->name('check_owner_register_phone');
    Route::post('/check_owner_register_business_number', 'LoginController@check_owner_register_business_number')->name('check_owner_register_business_number');
    Route::post('/verify-register', 'LoginController@verify_register')->name('verify-register');
    Route::post('/verify-login', 'LoginController@verify_login')->name(
        'verify_login'
    );
    Route::post(
        '/forgotverify-email',
        'LoginController@verify_email'
    )->name('forgotverify-email');
    Route::get(
        '/reset_password_view/{id}',
        'LoginController@reset_password_view'
    )->name('reset_password_view');
    Route::post(
        '/reset_password/{id}',
        'LoginController@reset_password'
    )->name('reset_password');
    Route::get(
        '/success-password',
        'LoginController@success_password'
    )->name('success_password');
    $admins->get('logout', 'LoginController@logout')->name('logout');

    //
});
//Admin
Route::middleware(['auth:restaurantportal', 'verified'])->group(function ($route) {
    Route::POST('save-token', 'App\Http\Controllers\admin\ProfileController@saveToken')->name('save-token');
    Route::get('subscription', 'App\Http\Controllers\Auth\LoginController@subscription')->name('subscription');
    Route::get('upgrade-subscription', 'App\Http\Controllers\Auth\LoginController@upgradeSubscription')->name('upgrade-subscription');
    Route::get('cancel-subscription', 'App\Http\Controllers\Auth\LoginController@cancelSubscription')->name('cancel-subscription');
    Route::get('subscription-purchase', 'App\Http\Controllers\Auth\LoginController@subscription_purchase');
    Route::get('makePayment/{businessId}/{businessStripeId}', 'App\Http\Controllers\Auth\LoginController@makePayment')->name('makePayment');
    Route::post('createPaymentSession', 'App\Http\Controllers\Auth\LoginController@createPaymentSession')->name('createPaymentSession');
    Route::get('paymentSuccess/{paymentId}', 'App\Http\Controllers\Auth\LoginController@paymentSuccess')->name('paymentSuccess');
    Route::get('paymentFailed/{paymentId}', 'App\Http\Controllers\Auth\LoginController@paymentFailed')->name('paymentFailed');
    
    Route::middleware(['checkStatus'])->group(function ($adminroute) {
        $adminroute
            ->get('restaurant-dashboard', 'App\Http\Controllers\admin\DashboardController@index')
            ->name('dashboard');
        $adminroute
            ->post('topup-orders', 'App\Http\Controllers\admin\DashboardController@topup_orders')
            ->name('topup-orders');


        $adminroute->get('makepaymentTopup/{businessId}/{businessStripeId}', 'App\Http\Controllers\admin\DashboardController@makepaymentTopup')->name('makepaymentTopup');

        $adminroute->get('paymentSuccessTopup/{paymentId}', 'App\Http\Controllers\admin\DashboardController@paymentSuccessTopup')->name('paymentSuccessTopup');

        $adminroute->get('paymentFailedTopup/{paymentId}}', 'App\Http\Controllers\admin\DashboardController@paymentFailedTopup')->name('paymentFailedTopup');



        $adminroute->post('create-payment-session-topup', 'App\Http\Controllers\admin\DashboardController@createPaymentSessiontopup')->name('create-payment-session-topup');



        $adminroute
            ->get('change-password', 'App\Http\Controllers\admin\DashboardController@change_password')
            ->name('change-password');
        $adminroute
            ->post('update_password', 'App\Http\Controllers\admin\DashboardController@update_password')
            ->name('update_password');
        $adminroute
            ->post('checkResturentpassword', 'App\Http\Controllers\admin\DashboardController@checkResturentpassword')
            ->name('checkResturentpassword');

        $adminroute
            ->get('app-users', 'App\Http\Controllers\admin\DashboardController@appusersList')
            ->name('app-users');
        $adminroute->get('getAppuserlist', 'App\Http\Controllers\admin\DashboardController@getAppuserlist')->name('app-user-data');
        $adminroute->post('strip-key-update', 'App\Http\Controllers\admin\DashboardController@stripKeyUpdate')->name('strip-key-update');
        $adminroute->post('get-monthly-data', 'App\Http\Controllers\admin\DashboardController@getMonthlyData')->name('get-monthly-data');
        $adminroute->resource('food-category', 'App\Http\Controllers\admin\FoodCategoryController');
        $adminroute->get('getFoodCategoryData', 'App\Http\Controllers\admin\FoodCategoryController@getFoodCategoryData')->name('food-data');

        $adminroute->resource('table-number', 'App\Http\Controllers\admin\BookTableController');
        $adminroute->get('getBookTableData', 'App\Http\Controllers\admin\BookTableController@getTableData')->name('book-table-data');

        $adminroute->resource('cuisine', 'App\Http\Controllers\admin\CuisineController');
        $adminroute->get('getCuisineData', 'App\Http\Controllers\admin\CuisineController@getCuisineData')->name('cuisine-data');

        $adminroute->resource('menu-category', 'App\Http\Controllers\admin\MenuCategoryController');
        $adminroute->get('getMenuCategoryData', 'App\Http\Controllers\admin\MenuCategoryController@getMenuCategoryData')->name('menu-category-data');

        $adminroute->resource('food-menu-category', 'App\Http\Controllers\admin\FoodMenuCategoryController');
        $adminroute->get('getFoodMenuCategoryData', 'App\Http\Controllers\admin\FoodMenuCategoryController@getMenuCategoryData')->name('food-category-data');

        $adminroute->resource('food-menu', 'App\Http\Controllers\admin\FoodMenuController');
        $adminroute->get('create-food-menu/{id}', 'App\Http\Controllers\admin\FoodMenuController@createFoodMenu')->name('createFoodMenu');
        $adminroute->get('getFoodMenuData', 'App\Http\Controllers\admin\FoodMenuController@getFoodMenuData')->name('food-menu-data');
        $adminroute->get('get-menu-status', 'App\Http\Controllers\admin\FoodMenuController@updateStatus')->name('menu.updatestatus');

        $adminroute->get('calendar', 'App\Http\Controllers\admin\CalendarController@index')->name('calendar');
        $adminroute->post('calendar-event', 'App\Http\Controllers\admin\CalendarController@calendarEvent')->name('calendar_event');
        $adminroute->get('table-report/{id}', 'App\Http\Controllers\admin\CalendarController@table_report')->name('table_report');
        $adminroute->get('calendar-event-users', 'App\Http\Controllers\admin\CalendarController@calendarEventUsers')->name('calendar_event_users');
        $adminroute->get('calendar-table-list', 'App\Http\Controllers\admin\CalendarController@calendarTableList')->name('calendar-table-list');

        $adminroute->resource('order-report', 'App\Http\Controllers\admin\OrderReportController');
        $adminroute->get('getOrderdata', 'App\Http\Controllers\admin\OrderReportController@getOrderdata')->name('order-data');
        $adminroute->post('changeOrderstatus', 'App\Http\Controllers\admin\OrderReportController@changeOrderstatus')->name('changeOrderstatus');

        $adminroute->post('acceptOrders', 'App\Http\Controllers\admin\OrderReportController@acceptOrders')->name('acceptOrders');
        $adminroute->post('rejectOrderstatus', 'App\Http\Controllers\admin\OrderReportController@rejectOrderstatus')->name('rejectOrderstatus');


        $adminroute->resource('profile', 'App\Http\Controllers\admin\ProfileController');
//        $adminroute->post('save-token', 'App\Http\Controllers\admin\ProfileController@saveToken')->name('save-token');


        $adminroute->post('check_admin_register_mobile', 'App\Http\Controllers\admin\ProfileController@check_admin_register_mobile');
        $adminroute->post('check_admin_register_email', 'App\Http\Controllers\admin\ProfileController@check_admin_register_email');

        $adminroute->resource('delivery-person', 'App\Http\Controllers\admin\DeliveryPersonController');
        $adminroute->get('getDeliverypersondata', 'App\Http\Controllers\admin\DeliveryPersonController@getDeliverypersondata')->name('delivery-person-data');
        $adminroute->post('check_deliveryperson_register_phone', 'App\Http\Controllers\admin\DeliveryPersonController@check_deliveryperson_register_phone')->name('check_deliveryperson_register_phone');
        $adminroute->post('check_deliveryperson_register_email', 'App\Http\Controllers\admin\DeliveryPersonController@check_deliveryperson_register_email')->name('check_deliveryperson_register_email');
        $adminroute->post('getDeliveryperson', 'App\Http\Controllers\admin\DeliveryPersonController@getDeliveryperson')->name('getDeliveryperson');
        $adminroute->post('addDeliverypersons', 'App\Http\Controllers\admin\DeliveryPersonController@addDeliverypersons')->name('getDeliveryperson');

        $adminroute->resource('discount', 'App\Http\Controllers\admin\DiscountController');
        $adminroute->get('getDiscountdata', 'App\Http\Controllers\admin\DiscountController@getDiscountdata')->name('discount-data');
        $adminroute->post('check_discount_name', 'App\Http\Controllers\admin\DiscountController@check_discount_name')->name('check_discount_name');
        $adminroute->post('check_discount_code', 'App\Http\Controllers\admin\DiscountController@check_discount_code')->name('check_discount_code');

        $adminroute->get('subscription-details', 'App\Http\Controllers\admin\SubscriptionController@index')->name('subscription-details');
        $adminroute->get('notifications', 'App\Http\Controllers\admin\NotificationController@index')->name('notifications');

        $adminroute->get('week-time-set', 'App\Http\Controllers\admin\WeekTImeSettingController@index')->name('weekTimeSet');
        $adminroute->post('add-weekly-schedule', 'App\Http\Controllers\admin\WeekTImeSettingController@store')->name('add-weekly-schedule');
        $adminroute->get('video-details', 'App\Http\Controllers\admin\FoodVideoController@index')->name('video-details');
        $adminroute->get('/details-video/{id}', 'App\Http\Controllers\admin\FoodVideoController@viewDetails')->name('details-video');
    });
});
