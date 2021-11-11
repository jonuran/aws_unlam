<?php

use Carbon\Carbon;

function setActive($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

/**
 * check if the date is correct.
 *
 * @return bool
 */
function is_correct_date($year, $month, $day, $hour, $minute, $seconds=0)
{
    if($year > 0)
        if($month >= 1  &&  $month <= 12)
            if($day >=1 && $day <= days_amount($month, $year))
                if($hour >= 0  &&  $hour < 24)
                    if($minute >= 0  &&  $minute <= 60)
                        if($seconds >= 0  &&  $seconds <= 60)
                            return true;

    return false;
}


/**
 * return days amount from a month and a year.
 *
 * @return int
 */

function days_amount($month, $year)
{
    $no_leap_year_array = array(31,28,31,30,31,30,31,31,30,31,30,31);
    $leap_year_array = array(31,29,31,30,31,30,31,31,30,31,30,31);

    if( is_leap_year($year) )
        return $leap_year_array[$month - 1];
    else
        return $no_leap_year_array[$month - 1];
}


/**
 * check if the a year is leap-year.
 *
 * @return bool
 */
function is_leap_year($year)
{
    if( $year % 400 == 0  ||   ($year % 4 == 0 && $year % 100 != 0) )
        return true;
    return false;
}


function normalize_date_time(string $date_time) 
{
    //"03/13/2020 7:19 PM"
    //"03/13/2020 11:19 PM"

    $date = normalize_date(substr($date_time, 0, 10));
    $time = normalize_time( substr($date_time, 11) ); 

    //'2020-03-19 05:19:28'
    return $date.' '.$time;
}

function normalize_date(string $date) 
{
    //"03/13/2020"
    //"03/13/2020"

    $month  = (int)substr($date, 0, 2);
    $day    = (int)substr($date, 3, 2);
    $year   = (int)substr($date, 6, 4);

    //'2020-03-19'
    return $year.'-'.$month.'-'.$day;
}

// "7:19 PM" --true (hora de un digito)
//"11:19 PM" --false (hora de dos digitos)
function normalize_time($time)
{
    if(strlen($time) == \Config::get('constants.date_options.one_digit_hour'))
        $offset = 0;
    else
        $offset = 1;

    $hour   = (int)substr($time, 0, 1 + $offset);
    $minute = (int)substr($time, 2 + $offset, 2);
    $type   = substr($time, 5 + $offset, 2);


    if($type == "AM" && $hour == 12) {
        $hour = 0;
    }

    if($type == "PM" && $hour < 12) {
        $hour+=12;
    }

    //'05:19:00'
    return $hour.':'.$minute.':00';
}

function des_normalize_date_time(string $date)
{
    //2020-04-01 07:55:00
    
    $year   = (int)substr($date, 0, 4);
    $month  = (int)substr($date, 5, 2);
    $day    = (int)substr($date, 8, 2);

    $time = des_normalize_time( substr($date, 11) );

    // 03/28/2020 12:00 PM
    return $month.'/'.$day.'/'.$year.' '.$time;
}


function des_normalize_time(string $time)
{
    $hour   = (int)substr($time, 0, 2);
    $minute = (int)substr($time, 3, 2);
    
    if($hour >= 12) {
        $type = "PM";
        if($hour > 12) {
            $hour-=12;
        }
    }
    else {
        $type = "AM";
    }

    if($hour == 0) {
        $hour = 12;
    }


    // 12:00 PM
    return $hour.':'.$minute.' '.$type;
}

/**
 * get absolute value in minutes between two timestamps.
 *
 * @return int
 */
function gap(string $date1, string $date2)
{
    $d1 = new Carbon($date1);
    $d2 = new Carbon($date2);
    
    $result = $d1->diffInMinutes($d2);

    return $result;
}

/**
 * get short elegant date. //dom. 03 may
 *
 * @return string
 */
function elegant_date(string $date, $hour=true)
{
    $d = new Carbon($date);
    
    $result  = $d->locale('es')->shortDayName.' '.$d->format('d').' ';

    $result .= $d->locale('es')->shortMonthName;

    $result .= $hour ? ' '.$d->format('H:i') : '';

    return $result;
}

/**
 * get long elegant date. //Domingo 03 Mayo 2020
 *
 * @return string
 */
function elegant_date_long(string $date, $hour=true)
{
    $d = new Carbon($date);
    
    $result  = ucfirst( $d->locale('es')->dayName ).' '.$d->format('d').' ';

    $result .= ucfirst( $d->locale('es')->monthName ).' '.$d->format('Y');

    $result .= $hour ? ' '.$d->format('H:i') : '';

    return $result;
}

/**
 * get spanish date. 2020-04-30 23:22:50 => 30-04-2020 23:22
 *
 * @return string
 */
function spanish_date_time(string $date)
{
    return spanish_date( substr($date, 0, 10) ).' '.substr($date, 11, 5);
}

/**
 * get spanish date. 2020-04-30 => 30-04-2020
 *
 * @return string
 */
function spanish_date(string $date)
{
    $d = new Carbon($date);

    return $d->format('d').'-'.$d->format('m').'-'.$d->format('Y');
}

/**
 * get spanish date. 05/29/2020 => 2020-05-29
 *
 * @return string
 */
function english_date(string $date)
{
    $d = new Carbon($date);

    return $d->format('Y').'-'.$d->format('m').'-'.$d->format('d');
}

/**
 * get datepicker date. 2020-04-23 => 04/23/2020
 *
 * @return string
 */
function datepicker_date(string $date)
{
    $d = new Carbon($date);

    return $d->format('m').'-'.$d->format('d').'-'.$d->format('Y');
}


/**
 * get the day name of the date. 2020-05- => domingo
 *
 * @return string
 */
function day_name(string $date)
{
    $d = new Carbon($date);

    return $d->locale('es')->dayName;
}

/**
 * get date with N more months. 23-04-2020 => 23-05-2020
 *
 * @return string
 */
function add_month(string $date, int $months)
{
    $d = new Carbon($date);

    $d->addMonths($months);

    return $d->format('Y').'-'.$d->format('m').'-'.$d->format('d');
}

/**
 * get next payment date
 * 15-04-2020 => 10-05-2020
 * 16-04-2020 => 10-06-2020
 * @return string
 */
function first_payment_date(string $date, &$flag)
{
    $d = new Carbon($date);

    if( $d->format('d') <= 15 ) {
        $d->addMonths(1);
    }
    else {
        $d->addMonths(2);
        $flag = true;
    }

    return $d->format('Y').'-'.$d->format('m').'-10';
}

/**
 * get days count to end to the month
 * 10-10-2020 => 21
 * @return int
 */
function days_to_end_month(string $date)
{
    $d = new Carbon($date);

    return days_amount($d->format('m'), $d->format('Y')) - $d->format('d');
}

function is_today(string $date)
{
    $d = new Carbon($date);
    $dt = Carbon::now();

    return $d->toDateString() == $dt->toDateString();
}

