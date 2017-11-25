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

Route::get('/', 'EventsController@index')->name('events.index');

Auth::routes();

Route::get('/home', 'UsersController@index')->name('home');

Route::get('/booking/create', 'BookingsController@create')->name('bookings.create');
Route::post('/booking', 'BookingsController@store')->name('bookings.store');

Route::get('/cancel-subscription', 'SubscriptionsController@destroy')->name('subscriptions.destroy');

Route::get('/event/{slug}', 'EventsController@show')->name('events.show');

Route::get('/subscribe', 'SubscriptionsController@index')->name('subscriptions.index');
Route::post('/subscribe', 'SubscriptionsController@store')->name('subscriptions.store');

Route::group(['prefix' => 'admin', 'middleware' => 'adminOnly'], function() {
    Route::get('bookings', 'Admin\BookingsController@index')->name('admin.bookings.index');

    Route::resource('events', 'Admin\EventsController', [
        'except' => 'show',
        'as'     => 'admin'
    ]);

    Route::get('payments', 'Admin\PaymentsController@index')->name('admin.payments.index');

    Route::get('users', 'Admin\UsersController@index')->name('admin.users.index');
});
