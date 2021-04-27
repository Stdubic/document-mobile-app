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

Auth::routes();
Route::get('upgrade/{jwt}', 'UpgradeBackendController@store');
Route::get('comment-categories', 'CommentBackendController@categories');
Route::middleware(['jwt.auth'])->get('user-upgrade','UserUpgradeController@upgrade');
Route::get('privacy-policy', function () { return view('mobile.privacy-policy'); });
Route::middleware(['auth', 'check_role_permissions'])->group(function () {

	// MISC ROUTES - GET
	Route::get('', 'HomeController@index')->name('home');
	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('tech-info', 'TechInfoController@index')->name('tech-info');


	// SETTINGS ROUTES
	Route::prefix('settings')->name('settings.')->group(function () {
		$c = 'SettingController@';

		// GET
		Route::get('', $c.'edit')->name('edit');

		// PUT
		Route::put('', $c.'update')->name('update');
	});


	// USER ROUTES
	Route::prefix('users')->name('users.')->group(function () {
		$c = 'UserController@';

		// GET
		Route::get('', $c.'index')->name('list');
		Route::get('add', $c.'create')->name('add');
		Route::get('{id}', $c.'edit')->name('edit');

		// POST
		Route::post('', $c.'store')->name('store');

		// PUT
		Route::put('{id}', $c.'update')->name('update');

		// PATCH
		Route::patch('activate', $c.'multiActivate')->name('activate');
		Route::patch('deactivate', $c.'multiDeactivate')->name('deactivate');

		// DELETE
		Route::delete('remove', $c.'multiRemove')->name('remove-multi');
		Route::delete('{id}', $c.'destroy')->name('remove');
	});


	// ROLE ROUTES
	Route::prefix('roles')->name('roles.')->group(function () {
		$c = 'RoleController@';

		// GET
		Route::get('', $c.'index')->name('list');
		Route::get('add', $c.'create')->name('add');
		Route::get('{id}', $c.'edit')->name('edit');

		// POST
		Route::post('', $c.'store')->name('store');

		// PUT
		Route::put('{id}', $c.'update')->name('update');

		// DELETE
		Route::delete('remove', $c.'multiRemove')->name('remove-multi');
		Route::delete('{id}', $c.'destroy')->name('remove');
	});


    // DOCUMENT ROUTES
    Route::prefix('documents')->name('documents.')->group(function () {
        $c = 'DocumentBackendController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');
        Route::get('{id}/sections', $c.'sectionsEdit')->name('sectionsEdit');

        // POST
        Route::post('', $c.'store')->name('store');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // PATCH
        Route::patch('activate', $c.'multiActivate')->name('activate');
        Route::patch('deactivate', $c.'multiDeactivate')->name('deactivate');

        // DELETE
        Route::delete('remove', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });


    // ajax sections with sentences
 //   Route::post("addmore","SectionBackendController@addMorePost");

    //testing purposes
 //   Route::get("addmore","SectionBackendController@addMore");

    // VIDEOS ROUTES
    Route::prefix('videos')->name('videos.')->group(function () {
        $c = 'VideoBackendController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');

        // POST
        Route::post('', $c.'store')->name('store');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // PATCH
        Route::patch('activate', $c.'multiActivate')->name('activate');
        Route::patch('deactivate', $c.'multiDeactivate')->name('deactivate');

        // DELETE
        Route::delete('remove', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });
    // FILTERS ROUTES
    Route::prefix('filters')->name('filters.')->group(function () {
        $c = 'FilterBackendController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');

        // POST
        Route::post('', $c.'store')->name('store');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // DELETE
        Route::delete('remove', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });
    // FILTER OPTIONS ROUTES
    Route::prefix('filteroptions')->name('filteroptions.')->group(function () {
        $c = 'FilterOptionsBackendController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');

        // POST
        Route::post('', $c.'store')->name('store');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // DELETE
        Route::delete('remove', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });
    // CATEGORY ROUTES
    Route::prefix('category')->name('category.')->group(function () {
        $c = 'CategoryBackendController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');

        // POST
        Route::post('', $c.'store')->name('store');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // DELETE
        Route::delete('remove', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });
    // NOTIFICATION GROUP ROUTES
    Route::prefix('notification-groups')->name('notification-groups.')->group(function () {
        $c = 'NotificationGroupController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');

        // POST
        Route::post('', $c.'store')->name('store');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // DELETE
        Route::delete('', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });


    // NOTIFICATION ROUTES
    Route::prefix('notifications')->name('notifications.')->group(function () {
        $c = 'NotificationController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');

        // POST
        Route::post('', $c.'store')->name('store');
        Route::post('fire', $c.'multiFire')->name('fire-multi');
        Route::post('fire/{id}', $c.'fire')->name('fire');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // DELETE
        Route::delete('', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });
    // TRANSACTIONS ROUTES
    Route::prefix('transactions')->name('transactions.')->group(function () {
        $c = 'TransactionBackendController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');

        // POST
        Route::post('', $c.'store')->name('store');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // DELETE
        Route::delete('remove', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });
    // TERMS ROUTES
    Route::prefix('terms')->name('terms.')->group(function () {
        $c = 'TermsBackendController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');

        // POST
        Route::post('', $c.'store')->name('store');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // DELETE
        Route::delete('remove', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });

    // Upgrades ROUTES
    Route::prefix('upgrade')->name('upgrade.')->group(function () {
        $c = 'UpgradeBackendController@';

        // GET
        Route::get('', $c.'index')->name('list');
        Route::get('add', $c.'create')->name('add');
        Route::get('{id}', $c.'edit')->name('edit');

        // POST
        Route::post('', $c.'store')->name('store');

        // PUT
        Route::put('{id}', $c.'update')->name('update');

        // PATCH
        Route::patch('activate', $c.'multiActivate')->name('activate');
        Route::patch('deactivate', $c.'multiDeactivate')->name('deactivate');

        // DELETE
        Route::delete('remove', $c.'multiRemove')->name('remove-multi');
        Route::delete('{id}', $c.'destroy')->name('remove');
    });



});