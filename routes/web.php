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

Route::RESOURCE('/categories', 'CategoryController');
Route::RESOURCE('/events', 'EventsController');
Route::GET('/', 'EventsController@index');



Route::GET('/contact', 'ContactController@create')->name('create');
Route::POST('/contactstore', 'ContactController@store')->name('store_contact');


Auth::routes();

// Likes Button
Route::POST('favorite/{event}/favorites', 'FavoritesController@store');
Route::DELETE('favorite/{event}/favorites', 'FavoritesController@destroy');

// Profile 

Route::RESOURCE('/user', 'ProfilesController');


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
Route::GET('/create-your-event/{event}/description', 'CreatingEventsController@createDescription');
Route::PATCH('/create-your-event/{event}/description', 'CreatingEventsController@updateDescription');
Route::GET('/create-your-event/{event}/description', 'CreatingEventsController@createDescription');
Route::PATCH('/create-your-event/{event}/description', 'CreatingEventsController@updateDescription');
Route::GET('/create-your-event/{event}/expect', 'CreatingEventsController@createExpect');
Route::PATCH('/create-your-event/{event}/expect', 'CreatingEventsController@updateExpect');
Route::GET('/create-your-event/{event}/title', 'CreatingEventsController@createTitle');
Route::PATCH('/create-your-event/{event}/title', 'CreatingEventsController@updateTitle');
Route::GET('/create-your-event/{event}/images', 'CreatingEventsController@createImages');
Route::PATCH('/create-your-event/{event}/images', 'CreatingEventsController@storeImages');
Route::GET('/create-your-event/{event}/thanks', 'CreatingEventsController@thanks');




