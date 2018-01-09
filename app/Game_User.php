<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game_User extends Model
{
   protected $table = 'game_user';

	public function games() {
    	return $this->belongsToMany('App\Game', 'game_user');
	}   

}
