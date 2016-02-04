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
    return App\Delivery::find($id)->progress;
  });
  Route::get('/deliveries/archived', function(){
    return App\Delivery::where('status', 6)->with('vimeo')->get();
  });
  Route::post('/deliveries/validate/{name}', function($name){
    $delivery = App\Delivery::where('dipID', $name)->get();
    if (count($delivery) && $delivery[0]->status > 2) {
      return ['status' => false];
    }
    return ['status' => true];
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

  Route::get('deliveries/archived', function() {
    return view('deliveries.archived', [
      'deliveries' => App\Delivery::where('status', 6)->get()
    ]);
  });

  Route::get('deliveries', function() {
    return view('deliveries.dashboard', [
      'deliveries' => App\Delivery::where('status', '<=', 5)->with('vimeo')->get()
    ]);
  });

  Route::get('deliveries/{id}', function($id){
    $delivery = App\Delivery::find($id);
    $events = [];
    if (!is_null($delivery->event)) {
        $events = $delivery->event->toArray();
    }
    foreach ($events as $event) {
      if ($event['message'] == 'Started processing: task list') {
        $list = (Array) $event['payload'];
        $list = json_decode($list[0]);
      }
    }
    $tasks = buildTaskList($list, $events);
    return view('deliveries.details', [
      'delivery' => $delivery,
      'events'   => $events,
      'tasks'    => $tasks
    ]);
  });


  Route::get('/', function() {
    return redirect('/admin/deliveries');
  });

});

function buildTaskList($list, $events) {
  $tasks = [];
  foreach ($list as $item) {
    if ($item) {
      $item->status = '';
      $item->error = null;
      $item->response = null;
      $tasks[actionName($item->action)] = (Array) $item;
    }
  }
  foreach ($events as $event) {
    $payload = json_decode($event['payload']);
    if (isset($payload->status) && $payload->status == 1) {
      $task = $tasks[actionName($payload->action)];
      $task['status'] = 'checked';
      if (isset($payload->task->response))
        $task['response'] = $payload->task->response;
      $tasks[actionName($payload->action)] = $task;
    }
    if ($event['type'] == 'delivery-error') {
      $error = explode(':', $event['payload']);
      $task = $tasks[actionName($event['message'])];
      $task['error'] = $event['payload'];
      if (count($error)>1)
        $task['error'] = str_replace('"','', str_replace('}', '', $error[2]));
      $task['action'] = $task['action'];
      $tasks[actionName($event['message'])] = $task;
    }
  }
  foreach ($tasks as $i => $task) {
    if (isset($task['response'])) {
      $response = $tasks[$i]['response'];
      if (isset($response->onDemandPage)) {
        $tasks[$i]['link'] = $response->onDemandPage;
      }
      if (isset($response->featureData->link)) {
        $tasks[$i]['link'] = $response->featureData->link;
      }
      if (isset($response->trailerData->link)) {
        $tasks[$i]['link'] = $response->trailerData->link;
      }
    }
  }
  return $tasks;
}

function actionName($str) {
  switch ($str) {
    case 'onDemandPage':
      return 'Create onDemand Page';
      break;
    case 'genres':
      return 'Set Genres';
      break;
    case 'uploadFeature':
      return 'Upload Feature';
      break;
    case 'uploadTrailer':
      return 'Upload Trailer';
      break;
    case 'poster':
      return 'Set Poster';
      break;
    case 'thumb':
      return 'Set Thumbnail';
      break;
    case 'trailerThumb':
      return 'Set Trailer Thumbnail';
      break;
    case 'texttrack':
      return 'Set Text Track';
      break;
    default:
      return ucfirst($str);
      break;
  }
}
