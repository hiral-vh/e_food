<?php
																																																																																																																																																																																

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V2\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'v2',
], function () {
    Route::get('test', [UserController::class, 'test']);
    Route::get('country-list', [UserController::class, 'countryList']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('forgot-password', [UserController::class, 'forgot_password']);
    Route::post('verify-OTP', [UserController::class, 'verifyOTP']);
    Route::post('set-new-password', [UserController::class, 'set_new_password']);
    Route::get('cuisine-data', [UserController::class, 'cuisine_data']);
    Route::get('faq-data', [UserController::class, 'faq_data']);
    Route::get('cms-data', [UserController::class, 'cms_data']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
		Route::get('testnotification', [UserController::class, 'testnotification']);
        Route::post('user-dashboard', [UserController::class, 'user_dashboard']);
        Route::post('save-restaurant', [UserController::class, 'save_restaurant']);
        Route::post('filter-restaurant', [UserController::class, 'filter_restaurant']);
        Route::post('venue-list', [UserController::class, 'venue_list']);
        Route::post('restaurant-table-list', [UserController::class, 'restaurant_table_list']);
        Route::post('restaurant-table-duration-list', [UserController::class, 'restaurant_table_duration_list']);
        Route::post('user-book-table', [UserController::class, 'user_book_table']);
        Route::get('food-category-menu', [UserController::class, 'food_category_menu']);
        Route::post('restaurant-detail', [UserController::class, 'restaurant_detail']);
        Route::post('menu-detail', [UserController::class, 'menu_detail']);
        Route::post('add-to-cart', [UserController::class, 'add_to_cart']);
        Route::get('view-cart', [UserController::class, 'view_cart']);
        Route::post('book-order', [UserController::class, 'book_order']);
        Route::post('add-delievery-address', [UserController::class, 'add_delievery_address']);
        Route::post('add-payment-details', [UserController::class, 'add_payment_details']);
        Route::get('card-list', [UserController::class, 'card_list']);
        Route::get('user-delivery-address-payment-list', [UserController::class, 'user_delivery_address_payment_list']);
        Route::post('user-order-book-table', [UserController::class, 'user_order_book_table']);
        Route::get('user-current-order', [UserController::class, 'user_current_order']);
        Route::post('user-current-order-detail', [UserController::class, 'user_current_order_detail']);
        Route::get('my-bookings', [UserController::class, 'my_bookings']);
        Route::post('cancel-booking', [UserController::class, 'cancel_booking']);
        Route::post('edit-booking', [UserController::class, 'edit_booking']);
        Route::post('update-booking', [UserController::class, 'update_booking']);
        Route::get('my-profile', [UserController::class, 'my_profile']);
        Route::post('update-my-profile', [UserController::class, 'update_my_profile']);
        Route::post('update-device-token', [UserController::class, 'update_device_token']);
        Route::get('notification-list', [UserController::class, 'notification_list']);
        Route::post('user-seated', [UserController::class, 'user_seated']);
        Route::post('update-email-address', [UserController::class, 'update_email_address']);
        Route::post('update-password', [UserController::class, 'update_password']);
        Route::post('my-saved-places', [UserController::class, 'my_saved_places']);
        Route::get('order-history', [UserController::class, 'order_history']);
        Route::post('order-detail', [UserController::class, 'order_detail']);
        Route::post('help-support', [UserController::class, 'help_support']);
        Route::post('user-addcart', [UserController::class, 'user_addcart']);
        Route::post('update-card-default-flag', [UserController::class, 'update_card_default_flag']);
        Route::post('check-promocode', [UserController::class, 'check_promocode']);
        Route::post('remove-cart', [UserController::class, 'remove_cart']);
    });
});
