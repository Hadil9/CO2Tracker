<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['engineType'];
    
    public $timestamps = false;
    
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
