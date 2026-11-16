<?php

use Illuminate\Http\Request;
use Modules\ClientHub\Http\Controllers\BookingController;
use Modules\ClientHub\Http\Controllers\InvoiceController;
use Modules\ClientHub\Http\Controllers\JobRequestController;
use Modules\ClientHub\Http\Controllers\LinkedVenderController;
use Modules\ClientHub\Http\Controllers\LoginController;
use Modules\ClientHub\Http\Controllers\ProfileController;
use Modules\ClientHub\Http\Controllers\QuotationController;
use Modules\ClientHub\Http\Controllers\QuotationItemController;
use Modules\ClientHub\Http\Controllers\ServiceController;
use Modules\ClientHub\Http\Controllers\ProviderDiscoveryController;
use Modules\ClientHub\Http\Controllers\VehicleController;
use Modules\ClientHub\Http\Controllers\VehicleDocumentController;
use Modules\Vender\Http\Controllers\QueueController;

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

Route::middleware('auth:api')->get('/$LOWER_NAME$', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['cors']], function () {

    Route::prefix('client')->middleware('throttle:100,1,login')->group(function () {

        Route::post('login', [LoginController::class, 'login']);
        Route::post('providers/search', [ProviderDiscoveryController::class, 'index']);
        Route::get('providers/filters', [ProviderDiscoveryController::class, 'filters']);
        Route::get('providers/{id}', [ProviderDiscoveryController::class, 'show'])->whereNumber('id');
        Route::post('user/delete', [LoginController::class, 'inActive']);

        Route::post('register', [LoginController::class, 'register']);
        Route::post('send/email/otp', [LoginController::class, 'sendOtp']);
        Route::post('verify/otp', [LoginController::class, 'verifyOtp']);
        Route::post('forgot-password/send-otp', [LoginController::class, 'sendOtp']);
        Route::post('forgot-password/verify-otp', [LoginController::class, 'verifyOtp']);
        Route::post('forgot-password/reset', [LoginController::class, 'resetPassword']);
        Route::post('reset/password', [LoginController::class, 'resetPassword']);
        Route::match(['get', 'post'], 'vehicle/lookup', [VehicleController::class, 'lookupVehicle']);
        Route::get('vehicle/lookup/{vrm}', [VehicleController::class, 'lookupVehicle']);
        Route::match(['get', 'post'], 'vehicles/lookup', [VehicleController::class, 'lookupVehicle']);
        Route::get('vehicles/lookup/{vrm}', [VehicleController::class, 'lookupVehicle']);
        Route::match(['get', 'post'], 'vehicle/reference-data', [VehicleController::class, 'getReferenceData']);
        Route::match(['get', 'post'], 'vehicles/reference-data', [VehicleController::class, 'getReferenceData']);
        Route::match(['get', 'post'], 'vehicle/models', [VehicleController::class, 'getModelsByMake']);
        Route::match(['get', 'post'], 'vehicles/models', [VehicleController::class, 'getModelsByMake']);

        Route::get('vehicles/{vehicle}/documents/{document}/file', [VehicleDocumentController::class, 'file'])
            ->middleware('signed')->name('client.vehicle-documents.file');

        Route::middleware('auth:sanctum')->group(function () {

            Route::get('favorites', [ProviderDiscoveryController::class, 'favorites']);
            Route::post('favorites', [ProviderDiscoveryController::class, 'addFavorite']);
            Route::delete('favorites/{id}', [ProviderDiscoveryController::class, 'removeFavorite'])->whereNumber('id');
            Route::get('favorites/{id}/status', [ProviderDiscoveryController::class, 'favoriteStatus'])->whereNumber('id');

            Route::get('vehicles/{vehicle}/documents', [VehicleDocumentController::class, 'index']);
            Route::post('vehicles/{vehicle}/documents', [VehicleDocumentController::class, 'store']);
            Route::put('vehicles/{vehicle}/documents/{document}', [VehicleDocumentController::class, 'update']);
            Route::delete('vehicles/{vehicle}/documents/{document}', [VehicleDocumentController::class, 'destroy']);
            Route::post('vehicles/{vehicle}/documents/{document}/access', [VehicleDocumentController::class, 'access']);

            Route::post('change/password', [LoginController::class, 'updatePassword']);
            Route::post('fetch/services', [ServiceController::class, 'fetchServices']);
            Route::post('fetch/service/vise/vender', [ServiceController::class, 'fetchByServicesID']);
            Route::post('fetch/all/services', [ServiceController::class, 'fetchAllServices']);
            Route::post('fetch/service/categories', [ServiceController::class, 'fetchCategories']);
            Route::post('fetch/service/all/categories', [ServiceController::class, 'fetchAllCategories']);
            Route::post('delete/account', [LoginController::class, 'deleteAccount']);
             Route::post('fetch/profile', [ProfileController::class, 'getProfile']);
             Route::post('fetch/single/profile', [ProfileController::class, 'fetchProfile']);
             Route::post('update/token', [ProfileController::class, 'updateToken']);
             Route::post('profile/update', [ProfileController::class, 'updateProfile']);
             Route::post('update/lat/long', [ProfileController::class, 'updateLatLong']);
             Route::post('set/location', [ProfileController::class, 'updateLatLong']);
             Route::post('set-location', [ProfileController::class, 'updateLatLong']);
             Route::post('location/update', [ProfileController::class, 'updateLatLong']);
             Route::post('email/change/send-otp', [ProfileController::class, 'sendEmailChangeOtp']);
             Route::post('email/change/verify-otp', [ProfileController::class, 'verifyEmailChangeOtp']);
             Route::post('mobile/change/send-otp', [ProfileController::class, 'sendMobileChangeOtp']);
             Route::post('mobile/change/verify-otp', [ProfileController::class, 'verifyMobileChangeOtp']);



            Route::post('vehicle/detail/save', [VehicleController::class, 'saveVehicleDetail']);
            Route::post('vehicle/detail/update', [VehicleController::class, 'updateVehicleDetail']);
            Route::post('vehicle/detail', [VehicleController::class, 'getVehicleDetail']);
            Route::post('vehicle/detail/search', [VehicleController::class, 'searchVehicleDetail']);
            Route::post('vehicle/delete', [VehicleController::class, 'vehicleDelete']);
            Route::get('vehicles', [VehicleController::class, 'getVehicleDetail']);
            Route::get('vehicles/{id}', [VehicleController::class, 'getSingleVehicle']);
            Route::post('vehicles/add', [VehicleController::class, 'saveVehicleDetail']);
            Route::post('vehicles/update', [VehicleController::class, 'updateVehicleDetail']);
            Route::post('vehicles/delete', [VehicleController::class, 'vehicleDelete']);
            Route::post('vehicles/{id}/set-default', [VehicleController::class, 'setDefaultVehicle']);
            Route::post('vehicles/{id}/refresh-checks', [VehicleController::class, 'refreshVehicleChecks']);
            Route::post('vehicle/{id}/set-default', [VehicleController::class, 'setDefaultVehicle']);
            Route::post('vehicle/{id}/refresh-checks', [VehicleController::class, 'refreshVehicleChecks']);

            Route::post('quotation/save', [QuotationController::class, 'saveQuotation']);
            Route::post('quotation/confirm', [QuotationController::class, 'confirmQuotation']);

            Route::post('find/quotation', [QuotationController::class, 'getSingleQuotation']);
            Route::post('fetch/quotation', [QuotationController::class, 'getQuotationDetail']);

            Route::post('reject/quotation', [QuotationController::class, 'rejectQuotation']);
            Route::post('accept/quotation', [QuotationController::class, 'acceptQuotation']);
            Route::post('quotation/status', [QuotationController::class, 'statusQuotation']);



            Route::post('service/provider/link', [LinkedVenderController::class, 'linkVender']);
            Route::post('service/provider/fetch', [LinkedVenderController::class, 'fetchLinkVender']);

            /************  Job Request  ***************/

            Route::post('job/request/save', [QuotationItemController::class, 'saveJobRequest']);
            Route::post('job/request/update', [QuotationItemController::class, 'updateJobRequest']);
            Route::post('fetch/single/job/request', [QuotationItemController::class, 'getSingleJobRequest']);
            Route::post('delete/job/request', [QuotationItemController::class, 'deleteJobRequest']);


            //

            Route::post('booking/save', [BookingController::class, 'saveBooking']);

            Route::post('find/booking', [BookingController::class, 'getSingleBooking']);
            Route::post('booking/confirm', [BookingController::class, 'confirmBooking']);
            Route::post('past/booking', [BookingController::class, 'getPastBooking']);

            Route::post('fetch/booking', [BookingController::class, 'getBookingDetail']);
            Route::post('status/booking', [BookingController::class, 'statusBooking']);


            Route::post('job/request/booking/save', [JobRequestController::class, 'saveJobRequest']);
            Route::post('job/request/booking/update', [JobRequestController::class, 'updateJobRequest']);
            Route::post('fetch/single/job/request/booking', [JobRequestController::class, 'getSingleJobRequest']);
            Route::post('delete/job/request/booking', [JobRequestController::class, 'deleteJobRequest']);

            Route::post('invoice/fetch', [InvoiceController::class, 'getInvoices']);
            Route::post('get/single/invoice', [InvoiceController::class, 'fetchSingleInvoice']);
            Route::post('get/single/invoice/pdf', [InvoiceController::class, 'fetchInvoicePdf']);
            Route::post('pay/invoice', [InvoiceController::class, 'payInvoice']);


        });




    });




});

Route::post('create-payment-intent', [InvoiceController::class, 'paymentIntent']);
