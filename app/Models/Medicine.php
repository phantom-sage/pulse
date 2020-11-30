<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'trade_name',
        'scientist_name',
        'amount',
        'weight',
        'status',
    ];

    public function pharmacy()
    {
        return $this->belongsTo('App\Models\Pharmacy');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
