<?php

namespace App\Models;

use App\Models\Admins;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table="sensors";
    protected $fillable = ['location', 'long', 'lat','status','admins_id'];

    public function admin(){
        $this->belongsTo(Admins::class);
    }

}
