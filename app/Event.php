<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['id', 'happen_at', 'name', 'summary', 'url', 'type', 'location_name', 'location_gps'];

    protected $casts = ['happen_at' => 'datetime'];
}
