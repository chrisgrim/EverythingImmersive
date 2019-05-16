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

Route::GET('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::GET('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::RESOURCE('/categories', 'CategoryController');
Route::RESOURCE('/organizer', 'OrganizerController');
Route::RESOURCE('/events', 'EventsController');
Route::GET('/', 'EventsController@index');



Route::GET('/contact', 'ContactController@create')->name('create');
Route::POST('/contactstore', 'ContactController@store')->name('store_contact');

Route::get('/search', 'SearchController@search');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

// favorites Button
Route::GET('myFavorites/{user}', 'FavoritesController@index');
Route::POST('favorite/{event}/favorites', 'FavoritesController@store');
Route::DELETE('favorite/{event}/favorites', 'FavoritesController@destroy');
Route::GET('favorite/{event}/login', 'FavoritesController@loginToFavorite');

//cities
Route::GET('/cities/{cities}', 'EventsController@cities');

// Profile 
Route::RESOURCE('/user', 'ProfilesController');

//Admin
Route::GET('/website-stats', 'AdminController@index');

//RSS
Route::GET('/RSS/Approve/{event}', 'RssController@index');

// Approved Events Section
Route::Get('/approve-events/events/unapproved/{event}', 'ApproveEventsController@unapprovedReason');
Route::POST('/approve-events/events/sendunapproved/{event}', 'ApproveEventsController@sendUnApproved');
Route::Resource('/approve-events/events', 'ApproveEventsController');

// Event Creation Process Section
Route::GET('/create-your-event/edit', 'CreatingEventsController@editEvents');
Route::Get('/create-your-event/{event}/location', 'CreatingEventsController@createLocation');
Route::PATCH('/create-your-event/{event}/location', 'CreatingEventsController@updateLocation');
Route::Get('/create-your-event/{event}/category', 'CreatingEventsController@createCategory');
Route::PATCH('/create-your-event/{event}/category', 'CreatingEventsController@updateCategory');
Route::Get('/create-your-event/{event}/organizer', 'CreatingEventsController@createOrganizer');
Route::POST('/create-your-event/{event}/organizer', 'CreatingEventsController@storeOrganizer');
Route::Get('/create-your-event/{event}/details', 'CreatingEventsController@createDetails');
Route::PATCH('/create-your-event/{event}/details', 'CreatingEventsController@updateDetails');
Route::Get('/create-your-event/{event}/dates', 'CreatingEventsController@createDates');
Route::PATCH('/create-your-event/{event}/dates', 'CreatingEventsController@updateDates');
Route::GET('/create-your-event/{event}/description', 'CreatingEventsController@createDescription');
Route::PATCH('/create-your-event/{event}/description', 'CreatingEventsController@updateDescription');
Route::GET('/create-your-event/{event}/expect', 'CreatingEventsController@createExpect');
Route::PATCH('/create-your-event/{event}/expect', 'CreatingEventsController@updateExpect');
Route::GET('/create-your-event/{event}/title', 'CreatingEventsController@createTitle');
Route::PATCH('/create-your-event/{event}/title', 'CreatingEventsController@updateTitle');
Route::GET('/create-your-event/{event}/images', 'CreatingEventsController@createImages');
Route::POST('/create-your-event/{event}/images', 'CreatingEventsController@storeImages');
Route::GET('/create-your-event/{event}/thanks', 'CreatingEventsController@thanks');

Route::POST('/eventsFilter/{filter}', 'EventsController@filter');





