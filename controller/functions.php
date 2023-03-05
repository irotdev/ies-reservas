

<?php

// Today
$today = date('Y-m-d');

// First day of the calendar & last day of the calendar
$calendarIni = (date('n') >= 9 ? date('Y')      : date('Y') - 1)    . "-09-01";
$calendarEnd = (date('n') >= 9 ? date('Y') + 1  : date('Y'))        . "-06-30"; 



// Get the date of the first day of a date
// e.g.  with 2023/04/05 --> 2023/04/03
function getFirstDayOfADate($date) {
    if (date("l", $date) == "Monday") return date("Y-m-d", $date);
    return date('Y-m-d', strtotime('last ' . WEEKFIRSTDAY, ($date)));
}



// Get the date of the last day of a date
// e.g.  with 2023/04/05 --> 2023/04/09
function getLastDayOfADate($date) {
    if (date("l", $date) == "Sunday") return date("Y-m-d", $date);
    return date('Y-m-d', strtotime('next ' . WEEKLASTDAY, ($date)));
}



// Get the month as 01, 02, 03... 11, 12.
function getRealNumberOfMonth2Digits($number) {
    $number = getRealNumberOfMonthNormal($number);
    if (strlen($number) == 1) $number = "0" . $number;
    return $number;
}



// Get the month as 1, 2, 3... 11, 12.
function getRealNumberOfMonthNormal($number) {
    if ($number > 12) $number = $number - 12;
    return $number;
}



// Get the year according to the month of the current calendar.
// If you ask for the month '3' and you are in the 2022-2023 year, the year is 2023
// If you ask for the month '11' and you are in the 2022-2023 year, the year is 2022
function getYearOfTheMonthAccordingSchoolCalendar($month) {
    if ($month <= 8) return (date('m') <= 8) ? date('Y') : date('Y') + 1; 
    return (date('m') <= 8) ? date('Y') - 1 : date('Y');
}



// Get the fist day of the month according to the current calendar.
// If you ask for the month '3' and you are in the 2022-2023 year, the day is 2023-03-01
// If you ask for the month '11' and you are in the 2022-2023 year, the day is 2022-11-01
function firstDateOfTheMonth($month) {
    return getYearOfTheMonthAccordingSchoolCalendar($month) . "-" . getRealNumberOfMonth2Digits($month) . "-01";
}


// Get the last day of the month according to the current calendar.
// If you ask for the month '3' and you are in the 2022-2023 year, the day is 2023-03-31
// If you ask for the month '11' and you are in the 2022-2023 year, the day is 2022-11-30
function lastDateOfTheMonth($month) {
    $date = firstDateOfTheMonth($month);
    return date("Y-m-t", strtotime($date));
}



// Get the number of days of the month + the necesary for the graph
function daysOfTheMonthAsAGraph($startDate, $lastDate) {
    return round((strtotime($lastDate) - strtotime($startDate) + 86400) / 86400);
}



// Use to debug to console as in javascript
function debugToConsole($output) {
    if (is_array($output)) $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
