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
    protected $filters = ['eventTitle','eventGeneralCost','openingDate'];

    /**
     * ------------------------
     * Remember that the string and the protected method should be same name
     * just to make it readable for you
     * and also you need to name your param like your table name.
     * make it clean :)
     * 
     * The if statement inside the all protected method is check that if the user are requested the query parameter
     * if the query parameter is null, it will not run query filter
     * -------------------------------
     */

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

    /**
     * Filter the query by the given eventGeneralCost
     * 
     * @param int|string $eventGeneralCost
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function eventGeneralCost($eventGeneralCost)
    {
        if($eventGeneralCost){
            return $this->builder->where('eventGeneralCost','>=',$eventGeneralCost);
        }
        return $this->builder;
    }

    /**
     * Filter the query by the given opening date
     * 
     * @param string $openingDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function openingDate($openingDate)
    {
        if($openingDate){
            /**
             * check if user is also searching the closing date
             * then the query should run where openingDate greater or equal from request 'openingDate' value
             * and where closingDate less or equal from 'closingDate' value
             */
            if($this->request->has('closingDate')){
                return $this->builder->where(function($q) use($openingDate){
                    return $q->whereDate('openingDate','>=',$openingDate)->whereDate('closingDate','<=',$this->request->closingDate);
                });
            }
            /**
             * Otherwise, the query run where openingDate equal from request opening date
             * not require request from closing date
             */
            return $this->builder->where('openingDate','=',$openingDate);
        }
        return $this->builder;
    }
}