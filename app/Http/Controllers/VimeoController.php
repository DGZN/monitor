<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Vimeo;
use App\Delivery;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class VimeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Vimeo::all();
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
        $values = $this->getFieldValues(array_dot($request->all()));
        $delivery = Delivery::create([
          'dipID'  => $values['id'],
          'name'   => $values['name'],
          'status' => 0
        ]);
        $values['deliveryID'] = $delivery->toArray()['id'];
        return Vimeo::create($values);
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

    public function getFieldValues($dot)
    {
      $map = [
        'name'           => 'query.name',
        'description'    => 'query.description',
        'content_rating' => 'query.content_rating',
        'rentActive'     => 'query.rent.active',
        'rentPeriod'     => 'query.rent.period',
        'rentPrice'      => 'query.rent.price.USD',
        'buyActive'      => 'query.buy.active',
        'buyPrice'       => 'query.buy.price.USD',
        'mainVideo'      => 'attributes.path',
        'trailerVideo'   => 'attributes.trailer',
        'poster'         => 'attributes.thumb',
        'genres'         => 'attributes.genres',
        'tags'           => 'attributes.tags',
        'id'             => 'attributes.id'
      ];

      $values = [];

      foreach ($map as $key => $value) {
        array_set($values, $key, array_get($dot, $value));
      }

      return $values;
    }
}
