<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInstance extends Model
{
    use HasFactory;

    protected $table = "events";

    protected $fillable = [
        'date',
        'eventDescription',
        'isItRecurringYearly'
    ];

    public function scopeSearchDate($query, $ignoreYearFromQuery, $searchDate) {
        if($ignoreYearFromQuery == false) {
            return ($searchDate != null) ? $query->whereDate('date', '=', $searchDate) : $query;
        } elseif ($ignoreYearFromQuery == true && $searchDate != "") {
            $month = date_format(date_create($searchDate), 'm');
            $day = date_format(date_create($searchDate), 'd');
            return $query->whereMonth('date', $month)
             ->whereDay('date', $day);
         }
    }

    public function scopeSearch($query, $search) {
        return $query->where('eventDescription', 'like', '%' . $search . '%');
    }

    public function scopeTimeInterval($query, $ignoreYearFromQuery, $startDate, $endDate) {

        if ($ignoreYearFromQuery == true) {

            if($startDate && $endDate) {
                $rangeStartMonth = date_format(date_create($startDate), 'm');
                $rangeStartDay = date_format(date_create($startDate), 'd');
                $rangeEndMonth = date_format(date_create($endDate), 'm');
                $rangeEndDay = date_format(date_create($endDate), 'd');
                $startDateNoYear = DateTime::createFromFormat('m-d', $rangeStartMonth . "-" . $rangeStartDay);
                $endDateNoYear = DateTime::createFromFormat('m-d', $rangeEndMonth . "-" . $rangeEndDay);

                if($startDateNoYear <= $endDateNoYear) {  // if start date is less or equal end date we take all dates over the range between them

                    if($rangeStartMonth == $rangeEndMonth) { // if startDate and endDate are on the same month, we must take all days in between range
                        $query->
                            whereMonth('date', '=', $rangeStartMonth)->
                            whereDay('date', '>=', date_format(date_create($startDate), 'd'))->
                            whereDay('date', '<=', date_format(date_create($endDate), 'd'));
                    } else {
                        $query->
                            whereMonth('date', '>', date_format(date_create($startDate), 'm'))-> // take all months between start and end date, if any
                            whereMonth('date', '<', date_format(date_create($endDate), 'm'))->
                            orWhereMonth('date', '=', date_format(date_create($startDate), 'm'))-> // since startDate is after endDate, in the corner case they should be both in the same month we take e.g. all days > 20 and all days < 15
                            whereDay('date', '>=', date_format(date_create($startDate), 'd'))->
                            orWhereMonth('date', '=', date_format(date_create($endDate), 'm'))->
                            whereDay('date', '<=', date_format(date_create($endDate), 'd'));
                    }

                }

            }

            else {
                return $query;
            }

        }

        else { // date query when checkbox is not checked
            if($startDate && $endDate) {
             $query->
                whereDate('date', '>=', date_format(date_create($startDate), 'Y-m-d'))->
                whereDate('date', '<=', date_format(date_create($endDate), 'Y-m-d'));
            } else {
                return $query;
            }
        }
    }


    public function scopeStartDate($query, $startDate, $endDate) {

        return ($startDate != null) ? $query->
            whereMonth('date', '>=', date_format(date_create($startDate), 'm'))->
            whereDay('date', '>=', date_format(date_create($startDate), 'd'))->
            orWhereMonth('date', '>', date_format(date_create($startDate), 'm'))
            : $query;

    }

    public function scopeEndDate($query, $endDate) {

        return ($endDate != null) ? $query->
            whereMonth('date', '<=', date_format(date_create($endDate), 'm'))->
            whereDay('date', '<=', date_format(date_create($endDate), 'd'))->
            orWhereMonth('date', '<', date_format(date_create($endDate), 'm'))
            : $query;
    }

    public function yearly() {

        return $this->isItRecurringYearly;
    }

}
