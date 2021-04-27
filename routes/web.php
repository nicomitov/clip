<?php

/*
|--------------------------------------------------------------------------
| Web RouteServiceProvider
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

// REGISTRATION
if (!config('app.allow_registration', false)) {
    Route::any('/register', function() {
        return redirect('/');
    });
}

// MIDDLEWARE VERIFIED
Route::middleware(['verified'])->group(function () {

    // home
    Route::get('/', 'HomeController@index')->name('home');

    // users
    Route::resource('users', 'UserController', ['except' => 'show']);

    // users: update status
    Route::patch('users/{user}/update_status', 'UserController@updateStatus')
        ->name('users.update_status');

    // topics
    Route::resource('topics', 'TopicController', ['except' => 'show']);

    // topics: status
    Route::get('topics/status/{status}', 'TopicController@topicsByStatus')
        ->name('topics.status');

    // clients
    Route::resource('clients', 'ClientController');

    // clients: by subscription type
    Route::get('clients/subscription/{subscription_type}', 'ClientController@clientsBySubscriptionType')
        ->name('clients.by_subscription');

    // clients: by status
    Route::get('clients/status/{status}', 'ClientController@clientsByStatus')
        ->name('clients.status');

    // clients: update status
    Route::patch('clients/{client}/update_status', 'ClientController@updateStatus')
        ->name('clients.update_status');

    // clients: responses
    Route::get('clients/get_emails/{id}', 'ClientController@getEmails')
        ->name('clients.get_emails');
    Route::get('clients/get_comment/{client}', 'ClientController@getComment')
        ->name('clients.get_emails');

    // subscriptions
    Route::resource('subscriptions', 'SubscriptionController');

    // subscriptions by type
    Route::get('subscription/type/{subscription_type}', 'SubscriptionController@subscriptionsByType')
        ->name('subscriptions.by_type');

    // subscriptions: status
    Route::get('subscriptions/status/{status}', 'SubscriptionController@subscriptionsByStatus')
        ->name('subscriptions.status');

    // logs
    Route::get('logs', 'ActivityController@index')->name('logs.index');
    Route::get('logs/name/{name}', 'ActivityController@logsByName')->name('logs.by_name');
    Route::delete('logs/delete', 'ActivityController@deleteAll')->name('activity.destroy');

    // notifications
    Route::resource('notifications', 'NotificationController');

    // notifications: read_all
    Route::delete('notifications/read_all', 'NotificationController@markAllAsRead')
        ->name('notifications.read_all');

    // notifications: delete_all
    Route::delete('notifications/delete_all', 'NotificationController@deleteAll')
        ->name('notifications.delete_all');

    // pages
    Route::resource('pages', 'PageController', ['except' => ['index' ,'show']]);

    Route::get('{page}', 'PageController@show')
        ->name('pages.show')
        ->where('page', '([A-Za-z0-9\-\/]+)');

}); // END MIDDLEWARE VERIFIED
