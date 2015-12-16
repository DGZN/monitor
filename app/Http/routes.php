<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api/v1'], function()
{
  Route::resource('/deliveries/vimeo', 'VimeoController');
  Route::resource('/deliveries/events', 'EventController');
  Route::get('/deliveries/{id}/progress', function($id){
    return App\Delivery::find($id)->progress();
  });
  Route::resource('/deliveries', 'DeliveryController');
});

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function ()
{

  Route::get('deliveries', function() {
    return view('deliveries.dashboard', [
      'deliveries' => App\Delivery::all()
    ]);
  });

  Route::get('deliveries/{id}', function($id){
    $delivery = App\Delivery::find($id);
    $events = [];
    if (!is_null($delivery->event)) {
        $events = $delivery->event->toArray();
    }
    return view('deliveries.details', [
      'delivery' => $delivery,
      'events'   => $events
    ]);
  });

  Route::get('/', function() {
    return redirect('/admin/deliveries');
  });

});
