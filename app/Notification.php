<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    
    protected $fillable = array('sensor_id', 'sensor_status', 'contact_method', 'reason');
}
