<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'home_latitude', 
        'home_longitude', 
        'school_latitude', 
        'school_longitude',
        'created_at', 
        'engine_id', 
        'program_id',
        'fuel_consumption'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all engine types
     * 
     * @return
     */
    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }
    
    /**
     * Get all programs
     * 
     * @return
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    
    /**
     * Get all of the trips for the user.
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
