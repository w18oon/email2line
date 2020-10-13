<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    protected $fillable = ['subject', 'token', 'remarks'];

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
}
