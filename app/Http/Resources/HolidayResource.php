<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HolidayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'start' => $this->start,
            'end' => $this->end->add('1','days'),
            'date'=>$this->is_multiple?$this->start->format('dS M').'-'.$this->end->format('dS M'):$this->start->format('dS M'),
            'color'=> 'black',                 
            'textColor'=> 'white'
        ];
    }
}
