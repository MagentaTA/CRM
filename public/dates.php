<?php

function date_period_grid($start, $end) {
    $start = new DateTime($start);
    $end = new DateTime($end);

    $interval = $end->diff($start);

    $days = $interval->days;
    $months = $interval->y * 12 + $interval->m;
    $years = intval($end->format('Y')) - intval($start->format('Y'));

    /*    if ($years > 1) {
      $period = new DatePeriod($start, new DateInterval('P1Y'), $years);
      $format = 'Y';
      } elseif ($months > 1) {
      $period = new DatePeriod($start, new DateInterval('P1M'), $months);
      $format = 'm.Y';
      } else { */
    $period = new DatePeriod($start, new DateInterval('P1D'), $days);
    $format = 'Y-m-d';
    /* } */

    $result = [];
    foreach ($period as $date) {
        $result[] = $date->format($format);
    }

    return $result;
}

date_period_grid('2012-07-01', '2015-11-01');
// => ['2012', '2013', '2014', '2015']

date_period_grid('2015-01-01', '2015-11-01');
// => ['01.2015', '02.2015', ..., '11.2015']

$dates_array = date_period_grid('2017-01-01', '2017-10-19');
// => ['01.10.2015', '02.10.2015', ..., '01.11.2015']
$count_diapazon = 0;
foreach ($dates_array as $start_date) {
    $d = new DateTime($start_date);
    $d->modify("+1 day");
    $end_date = $d->format("Y-m-d");
    echo '<div class="dates_diapazon-'.$count_diapazon.'">';
    echo '<span class="start_date">'.$start_date . '</span> - <span class="end_date">'.$end_date.'</span><br />';
    echo '</div>';
    $count_diapazon++;
}