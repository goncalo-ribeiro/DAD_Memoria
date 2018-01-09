<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'email', 'password', 'blocked', 'reason_blocked', 'reason_reactivated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_token'
    ];

    public function games()
    {
        return $this->belongsToMany('App\Game');
    }

    //o argumento $nickname devia ter outro nome, pois caso a função não encontre o utilizador com o nickname tenta faze-lo com email
    //devia ser chamado de $loginCredential
    public function findForPassport($nickname) {
        $user = $this->where('nickname', $nickname)->first();
        if (is_null($user)) {
            $user = $this->where('email', $nickname)->first();
        }
        return $user;
    }


    /*spublic function games_user()
    {
        return $this->hasManyThrough('App\Game');
        ->withPivot('game_user', 'game_id')
    }*/

}
