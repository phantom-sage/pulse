<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function medicines()
    {
        return $this->hasMany('App\Models\Medicine');
    }

    public function locations()
    {
        return $this->hasMany('App\Models\Location');
    }

    /**
     * owner of the pharmacy.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
