

<?php

if ($operation == "create") {
    if (isset($_GET["item"]) && isset($_GET["date"]) && isset($_GET["hour"]) && isset($_GET["quantity"])) {
        $item = mysqli_real_escape_string($con , stripcslashes($_GET["item"]));
        $date = mysqli_real_escape_string($con , stripcslashes($_GET["date"]));
        $hour = mysqli_real_escape_string($con , stripcslashes($_GET["hour"]));
        $quantity = mysqli_real_escape_string($con , stripcslashes($_GET["quantity"]));
        //+username
        $course = (isset($_GET["course"]) ? mysqli_real_escape_string($con , stripcslashes($_GET["course"])) : "");
        $description = (isset($_GET["description"]) ? mysqli_real_escape_string($con , stripcslashes($_GET["description"])) : "");
        
        $repeatUsername = false;
        $repeatUsernameItems = 0;

        if ($date < date('Y-m-d')) {
            $jsonArray['status'] = 'error';
            $jsonArray['message'] = 'Fecha incorrecta: la fecha debe de ser superior al día actual';
            
        } elseif (!in_array($hour, $hours)) {
            $jsonArray['status'] = 'error';
            $jsonArray['message'] = 'Hora incorrecta: hora fuera del rango real';
           
        } elseif (!is_numeric($quantity)) {
            $jsonArray['status'] = 'error';
            $jsonArray['message'] = 'La cantidad de items no es un número';

        } else {
            $quantity = intval($quantity);
            $query = "SELECT * FROM reserves 
                        WHERE item = '" . $item . "'
                            AND date = '" . $date . "' 
                            AND hour = '" . $hour . "'";

            $queryResult = mysqli_query($con, $query);
            $quantityReserved = 0;
            $dataOld = array();

            while ($row = mysqli_fetch_array($queryResult)) {
                $dataOld [] = array(
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

                $quantityReserved += $row['quantity'];
                if ($row['username'] == $username) {
                    $repeatUsername = true;
                    $repeatUsernameItems = $row['quantity'];
                }
            }

            $jsonArray['data_old'] = $dataOld;


            // There is a limit of items
            if (($quantityReserved + $quantity) <= $itemsToReserveNumbers[$item]) {

                $query = "";
                if ($repeatUsername) {
                    $quantity += $repeatUsernameItems;
                    $jsonArray['operation_real'] = "Actualización de número de items del profesorado";
                    
                    $query = "UPDATE reserves SET 
                                    quantity = " . $quantity .  ",
                                    course = '" . $course .  "',
                                    description = '" . $description .  "',
                                    reserve_modification = now()
                                WHERE item = '" . $item .  "'
                                    AND date = '" . $date . "' 
                                    AND hour = " . $hour . "
                                    AND username = '" . $username . "'
                                ";

                } else {
                    $jsonArray['operation_real'] = "Reserva de items del profesorado";
                    $query = "INSERT INTO 
                                    reserves (item, date, hour, quantity, username, course, description)
                                VALUES (
                                    '" . $item . "',
                                    '" . $date . "',
                                    " . $hour .  ",
                                    " . $quantity . ",
                                    '" . $username . "',
                                    '" . $course . "',
                                    '" . $description . "'
                                )";

                }

                $queryDone = mysqli_query($con, $query);
                if ($queryDone) {
                    $dataCreated [] = array(
                        'item' => $item,
                        'date' => $date,
                        'hour' => $hour,
                        'quantity' => $quantity,
                        'username' => $username,
                        'course' => $course,
                        'description' => $description
                    );

                    $jsonArray['data_created'] = $dataCreated;
                    $dbChanged = true;

                } else {
                    $jsonArray['status'] = 'error';
                    $jsonArray['message'] = 'Problema al insertar datos en la BD';
                    $jsonArray['query'] = $query;
                }

            } else {
                $jsonArray['status'] = 'error';
                $jsonArray['message'] = 'Número de items a reservar superior al disponible. quantity reservada excesiva.';
                $jsonArray['quantity_reserved'] = $quantityReserved;
                $jsonArray['quantity_requested'] = $quantity;
            }
        }
        
        $jsonArray['item_key'] = $item;
        $jsonArray['item_value'] = $itemsToReserve[$item];
        $jsonArray['item_numbers'] = $itemsToReserveNumbers[$item];

    } else {
        $jsonArray['status'] = 'error';
        $jsonArray['message'] = 'Fecha, hora o cantidad no indicadas en la creacion';

    }
}
