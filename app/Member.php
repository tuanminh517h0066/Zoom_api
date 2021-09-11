<?php

namespace App;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
  	protected $table = 'members';
  	use SoftDeletes;

  	use Notifiable;

  	/**
  	 * The attributes that are mass assignable.
  	 *
  	 * @var array
  	 */
  	protected $fillable = [
  	    'name', 'email', 'password',
  	];

  	/**
  	 * The attributes that should be hidden for arrays.
  	 *
  	 * @var array
  	 */
  	protected $hidden = [
  	    'password', 'remember_token',
  	];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * knowHows hasMany KnowHowLike
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     * */
    public function PracticeReport()
    {
        return $this->hasMany(\App\PracticeReport::class, 'member_id');
    }

    public function Location()
    {
        return $this->belongsTo(\App\Location::class, 'location');
    }

    public function MemberNotificationSetting()
    {
        return $this->hasOne(\App\MemberNotificationSetting::class, 'member_id');
    }

	/**
     * Get full name attribute
     * */

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
    
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = self::normalizeEmail($value);
    }
    
    /*public function setPasswordAttribute($password)
    {
        if (!is_null($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }*/

    public static function normalizeEmail($value)
    {
        return trim(strtolower($value));
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\PasswordReset($token));
    }
}
