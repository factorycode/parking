<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visitorSetting extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Property()
    {
        return $this->belongsTo('App\Models\Property');
    }

}
