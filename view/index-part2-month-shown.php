

        <div class="cal1 previous">
            <div class="month-to-show">
                Mes mostrado:

                <div class="clndr">
                    <div class="clndr-controls">
                        <table class="clndr-table" border="0" cellspacing="0" cellpadding="0">
                            <tr class='select-month-tr'>

<?php

$thisMonth = date('n'); //1, 2, 3 ... 12
$thisYear = date('Y'); //2022, 2023 ...

// Since september to june
for ($i = 9; $i <= (6 + 12); $i++) {


    //Number of month (1, 2, 3... 12)
    //Number of month  (01, 02, 03... 12)
    // First and last day of the month
    // Month of the current loop in Spanish
    // Year of the the month of the current loop

    $numberOfMonthNormal = getRealNumberOfMonthNormal($i);
    $numberOfMonth2Digits = getRealNumberOfMonth2Digits($i);
    $firstDateOfTheMonth = strtotime(firstDateOfTheMonth($numberOfMonth2Digits));
    $currentMonthInSpanish = $monthsSpanish[$numberOfMonthNormal - 1];
    $currentYear = getYearOfTheMonthAccordingSchoolCalendar($numberOfMonthNormal);


    echo "<td class='day select-month-td ";

    if ($numberOfMonthNormal == $thisMonth) {
        echo " month-actual calendar-day-clickable";
    } elseif (($numberOfMonthNormal < $thisMonth) || ($currentYear < $thisYear)) {
        echo " month-previous calendar-day-clickable";
    } elseif (($numberOfMonthNormal == "7") || ($numberOfMonthNormal == "8")) {
        echo " month-no-work ";
    } else {
        echo " calendar-day-clickable";
    }

    echo " ' id='previous-calendar-month-" . $numberOfMonthNormal . "' ";
    echo " onclick='change_month_to_show(" . $currentYear . ", " . $numberOfMonthNormal . ")' ";
    echo ">";
    echo "<div class='day-contents select-month-div'>";
    echo "<strong>" . $currentMonthInSpanish . "</strong><br>" . $currentYear . "</strong>";
    echo "</div>";
    echo "</td>";


}
?>

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>