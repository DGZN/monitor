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
  protected $fillable = [
      'deliveryID',
      'client',
      'name',
      'description',
      'content_rating',
      'rentActive',
      'rentPeriod',
      'rentPrice',
      'buyActive',
      'buyPrice',
      'mainVideo',
      'trailerVideo',
      'poster',
      'genres',
      'tags',
      'featureThumb',
      'trailerThumb',
      'captions'    ,
      'regions'     ,
      'availDate'
  ];

  /**
   * The validation rules.
   *
   * @var array
   */
  protected $rules = [
      'name'  => 'unique:vimeo'
  ];
  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];

  /**
   * Returns formatted genres.
   *
   * @return {string} void
   */
  public function genres()
  {
      return str_replace(',',', ', $this->genres);
  }

  /**
   * Returns formatted tags.
   *
   * @return {string} void
   */
  public function tags()
  {
      return str_replace(',',', ', $this->tags);
  }
}
