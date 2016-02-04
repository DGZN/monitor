<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use App\Delivery;
use App\Vimeo;
use App\Event;
use App\Http\Requests;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Delivery::where('status', '<=', 5)->with('vimeo')->get();
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
    public function store(StoreDeliveryRequest $request)
    {
        return Delivery::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Delivery::find($id);
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
      $delivery = (new Delivery)->find($id)->update($request->all());
      if ($request->get('events')) {
        Event::where('deliveryID','=',$id)->delete();
        $delivery->activeTask = 'Pending';
        $delivery->save();
      }
      return Delivery::find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = (new Delivery)->find($id);
        if (!$delivery) {
            return;
        }
        $vimeo    = $delivery->vimeo;
        Vimeo::destroy($vimeo['id']);
        Event::where('deliveryID','=',$id)->delete();
        return Delivery::destroy($delivery['id']);
    }
}
