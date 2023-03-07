

<?php

// Starting in September and finishing in June
const NUMFIRSTMONTHOFCALENDAR = 9;  
const NUMLASTMONTHOFCALENDAR = 6;

// First and last day in Spanish calendar
const WEEKFIRSTDAY = "Monday";  
const WEEKLASTDAY = "Sunday";

// Months in Spanish
$monthsSpanish = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

// Days of week in Spanish
$daysOfWeekSpanish = array('domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado');


// IMPORTANT: Update every schoolar year
// List of bank holidays
$daysBankHolidays = array (
    "2022-09-29","2022-10-12","2022-11-01","2022-12-05","2022-12-06",
    "2022-12-07","2022-12-08","2022-12-26","2022-12-27","2022-12-28",
    "2022-12-29","2022-12-30","2023-01-02","2023-01-03","2023-01-04",
    "2023-01-05","2023-01-06","2023-02-27","2023-02-28","2023-03-16",
    "2023-04-03","2023-04-04","2023-04-05","2023-04-06","2023-04-07",
    "2023-05-01","2023-09-29","2023-10-12","2023-11-01","2023-12-06",
    "2023-12-07","2023-12-08","2023-12-25","2023-12-26","2023-12-27",
    "2023-12-28","2023-12-29","2024-01-01","2024-01-02","2024-01-03",
    "2024-01-04","2024-01-05"
);

// Items to reserve
$itemsToReserve = array (
    "portatiles" => "Portátiles",
    "tablets" => "Tablets",
    "salondeactos" => "Salón de actos"
);

$itemsToReserveNumbers = array (
    "portatiles" => 20,
    "tablets" => 30,
    "salondeactos" => 1
);

$numPortatiles = 20;
$numTablets = 30;

// Hours everyday in the normal calendar
$hours = array (1, 2, 3, 4, 5, 6);

// Types for crud
$operationCrud = array ("create", "read", "update", "delete", "createUser");

$userTypeAdmin = "administración";
$userTypeTeacher = "profesorado";
