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

  /**
   * Returns delivery object.
   *
   * @return {string} void
   */
  public function vimeo()
  {
      return $this->hasOne('App\Vimeo', 'deliveryID', 'id');
  }

  /**
   * Returns delivery status.
   *
   * @return {string} void
   */
  public function getStatus()
  {
    switch ($this->status) {
      case '2':
        return 'Uploading';
        break;
      case '3':
        return 'Delivered';
        break;
      default:
        return 'Pending';
        break;
    }
  }
}
