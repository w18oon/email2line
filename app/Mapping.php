<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    protected $fillable = ['subject'];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function logs()
    {
        return $this->hasMany('App\Log');
    }
}
