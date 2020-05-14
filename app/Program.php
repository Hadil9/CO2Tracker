<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['programType'];
    
    public $timestamps = false;
    
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
