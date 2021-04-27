<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $expiry = $this->transactions->where('expiry_time', '>' , Carbon::now())->where('user_id','=',$this->id)->where('expiry_time','=',$this->transactions->max('expiry_time'));

        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'date_of_birth' => $this->date_of_birth,
            'country' => $this->country,
            'company' => $this->company,
            'mobile_number' => $this->mobile_number,
            'user_number' => $this->user_number,
            'email' => $this->email,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'is_upgraded' => boolval($expiry->count()),
            'expiry_time' => $expiry->count() ?  $expiry->first()->expiry_time : null
        ];
    }
}
