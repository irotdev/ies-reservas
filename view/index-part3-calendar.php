


<?php


        // Every month since september to june
        for ($i = NUMFIRSTMONTHOFCALENDAR; $i <= (NUMLASTMONTHOFCALENDAR + 12); $i++) {

            // IMPORTANT variables for the current month

            // Number of month  (01, 02, 03... 12)
            $numberOfMonth2Digits = getRealNumberOfMonth2Digits($i);

            // Number of month (1, 2, 3... 12)
            $numberOfMonthNormal = getRealNumberOfMonthNormal($i);

            // First and last day of the month
            $firstDateOfTheMonth = strtotime(firstDateOfTheMonth($numberOfMonth2Digits));
            $lastDateOfTheMonth = strtotime(lastDateOfTheMonth($numberOfMonth2Digits));

            // Month of the current loop in Spanish
            $currentMonthInSpanish = $monthsSpanish[$numberOfMonthNormal - 1];

            // Year of the the month of the current loop
            $currentYear = getYearOfTheMonthAccordingSchoolCalendar($numberOfMonthNormal);

            // Starting and finishing date of the month of the current loop
            $startDate = (getFirstDayOfADate($firstDateOfTheMonth));
            $lastDate = (getLastDayOfADate($lastDateOfTheMonth));

            // Number of days to view in the current month of the loop
            $daysOfTheMonthAsAGraph = daysOfTheMonthAsAGraph($startDate, $lastDate);
            
        ?>


            <div class="cal1 month-with-days <?php
    if (date('n') == $numberOfMonthNormal) echo " initial-month-to-show ";

    echo " calendar-month-" . $numberOfMonthNormal; 
            ?>">


                <div class="clndr">
                    <div class="clndr-controls">
                        <div class="month-header-left">Calendario:</div>
                        <div class="month-header-center"><strong><?php echo $currentMonthInSpanish . " " . $currentYear ?></strong></div>
                        <div class="month-header-right">


<?php
foreach ($itemsToReserve as $key=>$value) {
    echo "<span class='select-item-span item-" . $key . " display-none' id='item-" . $key . "'>";
    echo "<strong>" . $value . "</strong>";
    echo "</span>";
}


?>
                        </div>
                    </div>
                    <table class="clndr-table" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr class="header-days">
                                <td class="header-day">L</td>
                                <td class="header-day">M</td>
                                <td class="header-day">X</td>
                                <td class="header-day">J</td>
                                <td class="header-day">V</td>
                                <td class="header-day">S</td>
                                <td class="header-day">D</td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $currentDate = $startDate;

                            for ($j = 1; $j <= $daysOfTheMonthAsAGraph; $j++) {

                                // Day of the week: 1 monday, 2 tuesday, ... 6 saturday, 0 sunday
                                $dayOfTheWeekNumber = $j % 7;

                                // Internal table is showing everyday except Saturdays and Sundays
                                $showInternalTable =  (($dayOfTheWeekNumber == 0) || ($dayOfTheWeekNumber == 6)) ? false : true;
                                
                                // If it is monday, write the <tr>
                                if ($dayOfTheWeekNumber == 1) echo "<tr>";


                                echo "<td class='day calendar-day-" . $currentDate;

                                // This show if the day is past, today or future
                                if (date("Y-m-d") > date("Y-m-d", strtotime($currentDate))) {
                                    echo " past";
                                } elseif (date("Y-m-d") < date("Y-m-d", strtotime($currentDate))) {
                                    echo " future";
                                } else {
                                    echo " today";
                                }

                                // If the day is a bank holiday day
                                if (in_array($currentDate, $daysBankHolidays)) {
                                    echo " bank-holiday";
                                    $showInternalTable = false;
                                }

                                // If the month of the day is not the current calendar month, show a different background color
                                if (date("m", strtotime($currentDate)) < date("m", ($firstDateOfTheMonth))) {
                                    echo " adjacent-month last-month";
                                    $showInternalTable = false;
                                } elseif (date("m", strtotime($currentDate)) > date("m", ($firstDateOfTheMonth))) {
                                    echo " adjacent-month next-month";
                                    $showInternalTable = false;
                                }

                                if ($showInternalTable) echo " calendar-day-clickable calendar-day-clickable-details";


                                echo " calendar-dow-" . $dayOfTheWeekNumber . "'>";
                                echo "<div class='day-of-the-td display-none'>" . date("Y-m-d", strtotime($currentDate)) . "</div>";
                                echo "<div class='day-contents'><strong>" . date('d', strtotime($currentDate)) . "</strong>";


                                if ($showInternalTable) {
                                    echo "<div class='hide-extra-dayOfTheWeekSpanish display-none'>" . $daysOfWeekSpanish[$dayOfTheWeekNumber] . "</div>";
                                    echo "<div class='hide-extra-dayOfTheWeekNumber display-none'>" . $dayOfTheWeekNumber . "</div>";
                                    echo "<div class='hide-extra-dayOfTheMonth display-none'>" . date('d', strtotime($currentDate)) . "</div>";
                                    echo "<div class='hide-extra-monthSpanish display-none'>" . $currentMonthInSpanish . "</div>";
    
                                    foreach ($itemsToReserve as $key => $value) {
                                        echo '<table class="internal-table internal-table-' . $key . ' display-none table-' . $currentDate . '">';
                                        foreach ($hours as $valueHour) {
                                            if (($valueHour == 1) || ($valueHour == 4)) echo '<tr class="internal-tr">';
                                            echo '<td class="internal-td ' . $valueHour . 'hour td-' . $currentDate . '-' . $valueHour . '"></td>';
                                            if (($valueHour == 3) || ($valueHour == 6)) echo '</tr">';
                                        }
                                        echo '</table>';
                                    }
                                }

                                echo "</div>";
                                echo "</td>";

                                // If it is sunday, write the </tr>
                                if ($dayOfTheWeekNumber == 0) echo "</tr>";

                                // Avoid problems with days with change of hour
                                $roundDays = round(strtotime($currentDate) / 86400);

                                //Sum a day to the current date
                                $currentDate = date('Y-m-d', ($roundDays * 86400)  + 86400);
                            }
                            ?>


                        </tbody>
                    </table>
                </div>
            </div>

        <?php

        }
