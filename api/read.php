

<?php

if ($operation == "read") {

    $id = (isset($_GET["id"])) ? mysqli_real_escape_string($con , stripcslashes($_GET["id"])) : "";
    $item = (isset($_GET["item"])) ? mysqli_real_escape_string($con , stripcslashes($_GET["item"])) : "";
    $dateFrom = (isset($_GET["date_from"])) ? mysqli_real_escape_string($con , stripcslashes($_GET["date_from"])) : "";
    $dateTo = (isset($_GET["date_to"])) ? mysqli_real_escape_string($con , stripcslashes($_GET["date_to"])) : "";
    $usernameAsked = (isset($_GET["username_asked"])) ? mysqli_real_escape_string($con , stripcslashes($_GET["username_asked"])) : "";

    // For do the sum of quantities of reserves for the month calendar (part3)
    $monthlyData = (isset($_GET["monthly_data"])) ? true : false;


    if ($id != "") {
        // Reading only a reservation (by id)
        $query = "SELECT * FROM reserves WHERE id = " . $id;

    } elseif ($item != "") {

        if ($monthlyData) {
            // Reading the list of a type of items (tablets, laptops, ...) for the part3 (monthly calendar)
            $query = "SELECT item, date, hour, sum(quantity) AS quantity FROM reserves WHERE item = '" . $item . "'";
            if ($dateFrom != "") $query .= " AND date >= '" . $dateFrom . "'";
            if ($dateTo != "") $query .= " AND date <= '" . $dateTo . "'";
            if ($usernameAsked != "") $query .= "AND username = '" . $usernameAsked . "'";
            $query .= " GROUP BY date, hour ORDER BY date, hour";

        } else {
            // Reading the list of a type of items (tablets, laptops, ...) for the part4 (daily data)
            $query = "SELECT * FROM reserves WHERE item = '" . $item . "'";
            if ($dateFrom != "") $query .= " AND date >= '" . $dateFrom . "'";
            if ($dateTo != "") $query .= " AND date <= '" . $dateTo . "'";
            if ($usernameAsked != "") $query .= "AND username = '" . $usernameAsked . "'";
            $query .= " ORDER BY date, hour";
        }

        $jsonArray['item_key'] = $item;
        $jsonArray['item_value'] = $itemsToReserve[$item];
        $jsonArray['item_numbers'] = $itemsToReserveNumbers[$item];
    }

    if ($query != "") {
        $queryResult = mysqli_query($con, $query);

        
        $data = array();

        if ($monthlyData) {
            while ($row = mysqli_fetch_array($queryResult)) {
                $data [] = array(
                    'item' => $row['item'],
                    'date' => $row['date'],
                    'hour' => $row['hour'],
                    'quantity' => $row['quantity']
                );
            }
        } else {
            while ($row = mysqli_fetch_array($queryResult)) {
                $data [] = array(
                    'id' => $row['id'],
                    'item' => $row['item'],
                    'date' => $row['date'],
                    'hour' => $row['hour'],
                    'quantity' => $row['quantity'],
                    'username' => $row['username'],
                    'course' => $row['course'],
                    'description' => $row['description'],
                    'reserve_date' => $row['reserve_date'],
                    'reserve_modification' => $row['reserve_modification']
                );
            }
        }
        
        $jsonArray['data'] = $data;


    } else {
        $jsonArray['status'] = 'error';
        $jsonArray['message'] = 'No se han introducido datos a mostrar: tipo de item o id de reserva';

    }
}
