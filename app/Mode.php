<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Trip;

class Mode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['modeType'];
    
    public $timestamps = false;
    
    /**
     * Get the trip that owns the mode.
     */
    public function trip()
    {
        return $this->hasMany(Trip::class);
    }
}
