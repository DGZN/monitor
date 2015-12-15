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
            if (isset($event['payload']['progress'])) {
              $delivery->progress = $event['payload']['progress'];
              $delivery->save();
              $eventType = 'progress-event';
            }
            $event = new Event([
                'type'    => $eventType,
                'message' => $event['payload']['message'],
                'payload' => json_encode($event['payload'])
            ]);
            $delivery->event()->save($event);
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
