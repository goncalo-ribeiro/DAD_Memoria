<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function winner()
    {
        return $this->belongsTo('App\User', 'winner', 'id');
    }

    public function games_user()//Multiplayer games have 2 entrys the winner and the loser()
    {
        return $this->hasManyThrough('App\User', 'game_user');
    }
}
