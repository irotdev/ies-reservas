<!DOCTYPE html>


<?php
include_once("../model/constants.php");
include_once("../controller/functions.php");
include_once("../controller/authentication-check.php");
?>


<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>IES Mar Serena- RESERVAS</title>
    <link rel="stylesheet" href="../assets/css/minimal.css"> <?php //https://sweetalert2.github.io/?ref=vanillalist ?>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="../assets/js/sweetalert2.min.js"></script> <?php //https://sweetalert2.github.io/?ref=vanillalist ?>
    <script src="../assets/js/jquery.min.js"></script>
</head>

<body>

    <div class="hide-internal-data display-none">
        <div id="hide-date-from"></div>
        <div id="hide-date-to"></div>
        <div id="hide-item"></div>
        <div id="hide-year"></div>
        <div id="hide-month"></div>
        <div id="hide-day"></div>
    </div>

    <div class="container">


<?php
include_once("../controller/login-check.php");
include_once("../view/" . (!isset($_SESSION["ies_usuario"]) ? "login-no.php" : "login-yes.php")); 

// Content to reserve (part1)
include_once("../view/index-part1-content-to-reserve.php");

// Month shown (part2)
include_once("../view/index-part2-month-shown.php");

// Calendar (part3)
include_once("../view/index-part3-calendar.php");

// Daily data (part4)
include_once("../view/index-part4-daily-data.php");
?>


    </div>

    <script src="../assets/js/javascript.js"></script>
    <script>
        // Hide months except the initial one (today), load current day, and load an item
        $(".month-with-days").addClass("display-none");
        $(".initial-month-to-show").removeClass("display-none");
        let today = new Date();
        change_month_to_show(today.getFullYear(), today.getMonth()+1, false);
        change_item_to_show("portatiles");
    </script>
</body>
</html>


<?php
include_once("../controller/connection-close.php");
