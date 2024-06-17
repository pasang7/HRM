<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TravelResource extends JsonResource
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
            'title' => $this->user->name.' | '.$this->program_name,
            'start' => $this->from,
            'end' => $this->to->add('1','days'),
            'date'=>$this->from->format('dS M').'-'.$this->to->format('dS M'),
            'color'=> 'blue',                 
            'textColor'=> 'white'
        ];
    }
}
