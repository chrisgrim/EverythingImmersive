<?php

namespace App\Filters;

class EventFilter extends Filter
{
    /**
     * Registered Event filters to operate upon
     * Use your events table column as array inside this var
     * 
     * @var array
     */
    protected $filters = ['eventTitle'];

    /**
     * Filter query by the given eventTitle
     * 
     * @param string title
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function eventTitle($eventTitle)
    {
        if($eventTitle){
            return $this->builder->where('eventTitle','LIKE',"%$eventTitle%");
        }
        return $this->builder;
    }
}