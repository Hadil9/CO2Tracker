<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Mode;

class Trip extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'mode_id', 
        'co2emission', 
        'fromlatitude', 
        'fromlongitude', 
        'tolatitude', 
        'tolongitude', 
        'distance',
        'traveltime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class);
    }
}
