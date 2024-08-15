<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\MbAdditionalDayController;
use App\Http\Controllers\MbPriceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MbBookingController;
use App\Http\Controllers\MbCompanyController;
use App\Http\Controllers\MbFreeCityController;
use App\Http\Controllers\MbBlockedDatesController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\RoleController;

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

// Admin Routes

Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function(){

    //Users
    Route::get('/mb-users-by-id/{id}', [AuthController::class, 'getSingleUser']);
    Route::delete('/mb-users/{id}', [AuthController::class, 'destroy']);
    Route::put('/mb-users-update/{id}', [AuthController::class, 'update']);

    //Companies
    Route::get('/mb-companies', [MbCompanyController::class, 'index']);
    Route::post('/mb-company-create', [MbCompanyController::class, 'store']);
    Route::delete('/mb-company/{id}', [MbCompanyController::class, 'destroy']);

    //Prices
    Route::get('/mb-prices', [MbPriceController::class, 'index']);

    //Free Cities
    Route::get('/mb-cities', [MbFreeCityController::class, 'index']);
    Route::get('/mb-cities/{id}', [MbFreeCityController::class, 'show']);
    Route::get('/mb-cities-by-company/{id}', [MbFreeCityController::class, 'getAllByCompany']);
    Route::post('/mb-cities-create', [MbFreeCityController::class, 'store']);
    Route::delete('/mb-cities/{id}', [MbFreeCityController::class, 'destroy']);
    Route::put('/mb-cities/{id}', [MbFreeCityController::class, 'update']);

    //Blocked Dates
    Route::get('/mb-blocked-dates', [MbBlockedDatesController::class, 'index']);

    //Coupons
    Route::get('/coupons', [CouponController::class, 'index']);
    Route::delete('/coupons/{id}', [CouponController::class, 'destroy']);
    Route::get('/coupons/{id}', [CouponController::class, 'show']);
    Route::put('/coupons-update/{id}', [CouponController::class, 'update']);

    // Role Routes
    Route::get('/role', [RoleController::class, 'index']);
    Route::get('role/{id}', [RoleController::class, 'show']);
    Route::post('/role-create', [RoleController::class, 'store']);
    Route::put('/role-update/{id}', [RoleController::class, 'update']);
    Route::delete('/role/{id}', [RoleController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:admin|company']], function(){

    //Companies
    Route::get('/mb-companies', [MbCompanyController::class, 'index']);
    Route::post('/mb-company-create', [MbCompanyController::class, 'store']);
    Route::delete('/mb-company/{id}', [MbCompanyController::class, 'destroy']);
    Route::get('/mb-companies/{id}', [MbCompanyController::class, 'show']);
    Route::put('/mb-company/{id}', [MbCompanyController::class, 'update']);
    
    //Users
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [AuthController::class, 'index']);
    Route::post('/mb-users-password-reset', [NewPasswordController::class, 'reset']);

    //Bookings
    Route::resource('/mb-bookings', MbBookingController::class);
    Route::get('/mb-bookings/search/{bookingNumber}', [MbBookingController::class, 'search']);
    Route::post('/mb-bookings-update-status', [MbBookingController::class, 'updateStatus']);
    Route::post('/mb-bookings-day', [MbBookingController::class, 'getBookingsByDay']);
    Route::post('/mb-bookings-month', [MbBookingController::class, 'getBookingsByMonth']);

    Route::post('/mb-bookings-no-transport', [MbBookingController::class, 'getBookingsByMonthNoTransport']);
    Route::get('/mb-bookings-month', [MbBookingController::class, 'month']);
    Route::get('/mb-bookings-no-transport', [MbBookingController::class, 'noTransport']);
    Route::post('/mb-bookings-create-without-email', [MbBookingController::class, 'createBooking']);

});

Route::group(['middleware' => ['auth:sanctum', 'role:company']], function(){

    // Bookings
    Route::put('/mb-bookings-update/{id}', [MbBookingController::class, 'update']);

    //Blocked Dates
    Route::get('/mb-blocked-dates/{id}', [MbBlockedDatesController::class, 'show']);
    Route::post('/mb-blocked-dates-create', [MbBlockedDatesController::class, 'store']);
    Route::delete('/mb-blocked-dates/{id}', [MbBlockedDatesController::class, 'destroy']);
    Route::put('/mb-blocked-dates/{id}', [MbBlockedDatesController::class, 'update']);

    //Prices
    Route::get('/mb-prices', [MbPriceController::class, 'index']);
    Route::get('/mb-prices/{id}', [MbPriceController::class, 'show']);
    Route::post('/mb-prices-create', [MbPriceController::class, 'store']);
    Route::delete('/mb-prices/{id}', [MbPriceController::class, 'destroy']);
    Route::put('/mb-prices/{id}', [MbPriceController::class, 'update']);

    //Free Cities
    Route::get('/mb-cities', [MbFreeCityController::class, 'index']);
    Route::get('/mb-cities/{id}', [MbFreeCityController::class, 'show']);
    Route::get('/mb-cities-by-company/{id}', [MbFreeCityController::class, 'getAllByCompany']);
    Route::post('/mb-cities-create', [MbFreeCityController::class, 'store']);
    Route::delete('/mb-cities/{id}', [MbFreeCityController::class, 'destroy']);
    Route::put('/mb-cities/{id}', [MbFreeCityController::class, 'update']);
});

/**
 * End Private Routes
 */

/**
 * Public Routes
 */

//Widget routes
Route::get('/mb-companies-by-secret/{secret}', [MbCompanyController::class, 'getCompanyBySecret']);
Route::get('/mb-prices-by-company/{id}', [MbPriceController::class, 'getAllByCompany']);
Route::post('/get-day-price', [MbPriceController::class, 'getDayPrice']);
Route::post('/get-package-price', [MbPriceController::class, 'getPackagePrice']);
Route::post('/mb-prices-continue', [MbPriceController::class, 'getContinuePrice']);
Route::post('/mb-bookings-create', [MbBookingController::class, 'store']);
Route::post('/mb-bookings-update-payment', [MbBookingController::class, 'updatePayment']);
Route::get('/mb-bookings-continue/{id}', [MbBookingController::class, 'getContinueBooking']);
Route::post('/mb-additional-days-create', [MbAdditionalDayController::class, 'store']);
Route::get('/mb-additional-days-by-booking-id/{id}', [MbAdditionalDayController::class, 'getAllByBookingId']);
Route::post('/mb-bookings-payment-canceled', [MbBookingController::class, 'sendCancelEmail']);
Route::post('/coupons-create', [CouponController::class, 'store']);

//Blocked Dates
Route::get('/mb-blocked-dates-by-company/{id}', [MbBlockedDatesController::class, 'getAllByCompany']);

//Dashboard Routes
Route::get('/mb-companies-by-user/{id}', [MbCompanyController::class, 'getCompanyByUser']);

//User Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/generate-reset-token', [ForgotPasswordController::class, 'generateToken']);
Route::post('/forgot-password/{token}', [ForgotPasswordController::class, 'sendResetEmail']);
Route::post('/reset-password/{token}', [ResetPasswordController::class, 'reset']);

Route::get('/mb-bookings/{id}', [MbBookingController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', [MbBookingController::class, 'test']);

// Check Coupons
Route::post('/check-coupon', [CouponController::class, 'checkCoupon']);

/**
 * End Public Routes
 */


