<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Pharmacy as PharmacyResource;

class Medicine extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'trade_name' => $this->trade_name,
            'scientist_name' => $this->scientist_name,
            'amount' => $this->amount,
            'weight' => $this->weight,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'pharmacy' => new PharmacyResource($this->pharmacy),
        ];
    }
}
