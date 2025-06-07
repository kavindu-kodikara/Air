<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AQI extends Model
{
    use HasFactory;

    protected $table = 'aqi_data';

    protected $fillable = [
        'city',
        'latitude',
        'longitude',
        'aqi_level',
    ];
}
