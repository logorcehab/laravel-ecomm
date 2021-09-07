<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\Customer;
use App\Http\Controllers\API\APIController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/customer', [ APIController::class, 'index']);
Route::post('/customer/otp/{phone}', function (Request $request, String $phone) {
    if ($request->input('verification')) {
        //
        $customer = Customer::where([['phone_number', $phone],['customer_id', $request->input('verification')]])->first();
        $customer->is_verified = true;
        $customer->save();
        return response()->json($customer, 200); 
    }
    return response()->json(array(error=>'Please enter number'), 404);
});