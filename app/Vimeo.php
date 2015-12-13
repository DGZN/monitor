<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vimeo extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'vimeo';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['deliveryID', 'name', 'description', 'content_rating', 'rentActive', 'rentPeriod', 'rentPrice', 'buyActive', 'buyPrice', 'mainVideo', 'trailerVideo', 'poster', 'genres', 'tags'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];
}
