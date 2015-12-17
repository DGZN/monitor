<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Vimeo;
use App\Delivery;
use App\Http\Requests;
use App\Http\Requests\StoreVimeoRequest;
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
    public function store(StoreVimeoRequest $request)
    {
        $values = $this->getFieldValues($request->all());
        $delivery = Delivery::firstOrCreate([
            'dipID' => $values['id'],
            'name'  => $values['name']
        ]);
        $delivery->status = isset($delivery->status) ?  $delivery->status : 0;
        $vimeo = new Vimeo($values);
        $delivery->vimeo()->save($vimeo);
        return $delivery->vimeo;
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
      $dot = array_dot($dot);
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
        'featureThumb'   => 'attributes.thumb',
        'trailerThumb'   => 'attributes.trailerThumb',
        'captions'       => 'attributes.subtitle',
        'regions'        => 'attributes.regions',
        'availDate'      => 'attributes.available',
        'genres'         => 'attributes.genres',
        'tags'           => 'attributes.tags',
        'id'             => 'attributes.id'
      ];

      $values = [];

      foreach ($map as $key => $value) {
        $_value = array_get($dot, $value);
        if (is_null($_value)) $_value = '';
        array_set($values, $key, $_value);
      }

      return $values;
    }
}
