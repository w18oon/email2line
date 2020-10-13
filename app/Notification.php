<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['gmail_message_id', 'status'];

    public function lookup()
    {
        return $this->belongsTo('App\Lookup');
    }
}
