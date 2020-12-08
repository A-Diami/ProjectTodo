<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Todo extends Model
{
    use Notifiable;
  protected $fillable = [
      'name','description','done'
  ];

  public  function user()
  {
      return $this->belongsTo('App\User', 'creator_id');
  }

  /**
   *affecter l'utilisateur à cette tâche
   */
  public function todoAffectedTo()
  {
      return $this->belongsTo('App\User','affectedTo_id');
  }

    /**
     *obtenir l'utilisateur qui a affecté cette tâche
     */
    public function todoAffectedBy()
    {
        return $this->belongsTo('App\User','affectedBy_id');
    }
}
