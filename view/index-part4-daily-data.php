

            <div class="cal1 daily-data-cal">
                <div class="clndr daily-data">
                    <div class="clndr-controls">
                        <div class="month-header-left">Datos diarios:</div>
                        <div class="month-header-center daily-date-selected"></div>
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
                        <tr class="header-days">
                            <td class="header-day">8:00 - 9:00</td>
                            <td class="header-day">9:00 - 10:00</td>
                            <td class="header-day">10:00 - 11:00</td>
                        </tr>
                        <tr>
                            <td class='day daily-data-td daily-1'></td>
                            <td class='day daily-data-td daily-2'></td>
                            <td class='day daily-data-td daily-3'></td>
                        </tr>
                        <tr class="header-days">
                            <td class="header-day">11:30 - 12:30</td>
                            <td class="header-day">12:30 - 13:30</td>
                            <td class="header-day">13:30 - 14:30</td>
                        </tr>
                        <tr>
                            <td class='day daily-data-td daily-4'>a</td>
                            <td class='day daily-data-td daily-5'>a</td>
                            <td class='day daily-data-td daily-6'>a</td>
                        </tr>
                    </table>

                </div>
            </div>
