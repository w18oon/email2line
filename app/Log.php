<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['gmail_message_id', 'line_notify_flag'];

    public function mapping()
    {
        return $this->belongsTo('App\Mapping');
    }
}
