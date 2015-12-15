<?php

namespace App;

use Carbon\Carbon;
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
   * Returns delivery by dipID.
   *
   * @return {string} void
   */
  public function byDipId($id)
  {
      return $this::where('dipID', '=', $id)->first();
  }

  /**
   * Returns delivery progress.
   *
   * @return {string} void
   */
  public function progress()
  {
      $events  = $this->event->where('type', 'progress-event');
      $started = new Carbon($events->first()->created_at);
      $last    = new Carbon($events->last()->created_at);
      $difference = $started->diff($last);
      $duration = implode([$difference->h, $difference->i, $difference->s], ':');
      $lastEvent = json_decode($events->last()['payload']);
      return ['progress' => $lastEvent->progress, 'duration' => $duration];
  }

  /**
   * Returns vimeo object.
   *
   * @return {string} void
   */
  public function vimeo()
  {
      return $this->hasOne('App\Vimeo', 'deliveryID', 'id');
  }

  /**
   * Returns event object.
   *
   * @return {string} void
   */
  public function event()
  {
      return $this->hasMany('App\Event', 'deliveryID', 'id');
  }

  /**
   * Returns delivery class.
   *
   * @return {string} void
   */
  public function getClass()
  {
    switch ($this->status) {
      case '2':
        return '';
        break;
      case '3':
        return 'bg-info';
        break;
      case '4':
        return 'bg-success';
        break;
      default:
        return 'Pending';
        break;
    }
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
        return 'Processing';
        break;
      case '3':
        return 'Uploading';
        break;
      case '4':
        return 'Delivered';
        break;
      default:
        return 'Pending';
        break;
    }
  }
}
