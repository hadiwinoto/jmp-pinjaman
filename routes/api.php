<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::post('/products', 'ProductController@store');
Route::get('/products', 'ProductController@index');
Route::get('/prices', 'ProductController@prices');

Route::get('/customer', 'ProductController@index');
Route::post('/customer', 'CustomerController@store');
Route::get('/customer/{id}', 'CustomerController@show');
Route::put('/customer/{id}', 'CustomerController@update');
Route::delete('/customer/{id}', 'CustomerController@destroy');

Route::get('/menus', 'MenusController@index');

Route::post('/register', [App\Http\Controllers\AuthenticationController::class, 'store']);
Route::get('/user', [App\Http\Controllers\AuthenticationController::class, 'user']);

Route::post('/login', [App\Http\Controllers\AuthenticationController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('logout', [App\Http\Controllers\AuthenticationController::class, 'logout']);
});


Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', [App\Http\Controllers\ForgotPasswordController::class, 'create']);
    Route::get('find/{token}', [App\Http\Controllers\ForgotPasswordController::class, 'find']);
    Route::post('reset', [App\Http\Controllers\ForgotPasswordController::class, 'reset']);
});

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 'client-id',
        'redirect_uri' => 'http://example.com/callback',
        'response_type' => 'code',
        'scope' => 'place-orders check-status',
    ]);
    return redirect('http://your-app.com/oauth/authorize?' . $query);
});
