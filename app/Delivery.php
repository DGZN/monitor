<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'deliveries';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['dipID', 'name', 'status', 'parentID'];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = [];
}
