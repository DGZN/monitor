<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\Delivery;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = $request->get('event');
        $delivery = (new Delivery)->byDipId($event['dipID']);
        if ($delivery) {
            $eventType = 'delivery-event';
            if (isset($event['event']['task'])) {
              $delivery->activeTask = $event['event']['task']['action'];
              $payload = json_encode($event['event']);
            } elseif (isset($event['event']['error'])) {
              $eventType = 'delivery-error';
              $payload = $event['event']['error'];
              $delivery->status = 5;
              $delivery->save();
            } else {
              $payload = json_encode($event['event']['list']);
            }
            if (isset($event['event']['progress'])) {
              $delivery->progress = $event['event']['progress'];
              $delivery->status = 3;
              $delivery->save();
              $eventType = 'progress-event';
            }
            if ($event['event']['message'] == 'Completed action: texttrack') {
              if ($delivery->status<5) {
                $delivery->status = 4;
                $delivery->save();
              }
            }
            $event = new Event([
                'type'    => $eventType,
                'message' => $event['event']['message'],
                'payload' => $payload
            ]);
            $delivery->event()->save($event);
            $delivery->save();
        }
        return $delivery;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
