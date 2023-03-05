

        <div class="cal1 select-item">
            <div class="select-item-to-reserve">
                Contenido a reservar:

                <div class="clndr">
                    <div class="clndr-controls">
                        <table class="clndr-table" border="0" cellspacing="0" cellpadding="0">
                            <tr class="select-item-tr">

<?php
foreach ($itemsToReserve as $key=>$value) {
    echo "<td class='day calendar-day-clickable select-item-td item-" . $key . "' id='item-" . $key . "' onclick='change_item_to_show(\"" . $key . "\")'>";
    echo "<div class='day-contents select-items'>";
    echo "<strong>" . $value . "</strong><br>";
    if ($itemsToReserveNumbers[$key] > 1) {
        echo $itemsToReserveNumbers[$key] . " " . mb_strtolower($value) . ".";
    }
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