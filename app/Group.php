<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'token'];

    public function mappings()
    {
        return $this->hasMany('App\Mapping');
    }
}
