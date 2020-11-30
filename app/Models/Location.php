<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'address', 'longitude', 'latitude',
    ];

    public function pharmacy()
    {
        return $this->belongsTo('App\Models\Pharmacy');
    }
}
