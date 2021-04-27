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
Route::fallback(function () {
    return response()->json(['message' => 'Not Found!'], 404);
})->name('404');

Route::post('user/register', 'API\RegisterController@register');
Route::post('user/login', 'API\LoginController@login');


Route::get('users', 'API\UserController@index');
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::apiResource('documents', 'API\DocumentController');
    Route::post('users/update', 'API\UserController@update');
    Route::post('users/change-password', 'API\UserController@updatePass');
    Route::post('sentences/{sentence}/comments', 'API\CommentController@store');
    Route::delete('/comments/{id}', 'API\CommentController@delete');
    Route::apiResource('sentences', 'API\SentenceController');
    Route::get('sentences/{sentence}/{comment_category_id}', 'API\SentenceController@sentence_comments');
    Route::post('users/upgrade', 'API\UpgradeController@upgrade');
    Route::get('user', 'API\UserController@me');
    Route::apiResource('videos', 'API\VideoController');
    // CUSTOMER DEVICES ROUTES
    Route::prefix('devices')->name('devices.')->group(function () {
        $c = 'API\CustomerDeviceController@';

        // GET
        Route::get('', $c.'index')->name('list');

        // POST
        Route::post('', $c.'toggle')->name('toggle');

        // PUT
        Route::put('', $c.'createOrNothing')->name('store');
    });

    Route::apiResource('backend/documents', 'DocumentAPIController');
    Route::apiResource('backend/process-document', 'ProcessDocumentAPIController');
    Route::post('document/image-upload', 'ImageController@store');
});

Route::apiResource('terms', 'API\TermsController');
Route::get('videos', 'API\VideoController@index');
Route::get('filters', 'API\FilterController@index');

Route::get('settings', 'API\SettingsController@index');