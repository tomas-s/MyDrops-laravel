<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensors';
    
    protected $primaryKey = 'id'; 
    
    protected $fillable = [
        'id', 'battery', 'state',
    ];
}
