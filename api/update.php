

<?php

if ($operation == "update") {
    if (isset($_GET["id"]) && isset($_GET["quantity"]) && isset($_GET["course"]) && isset($_GET["description"])) {

        $id = mysqli_real_escape_string($con , stripcslashes($_GET["id"]));
        //+item
        //+date
        //+hour
        $quantity = mysqli_real_escape_string($con , stripcslashes($_GET["quantity"]));
        $course = mysqli_real_escape_string($con , stripcslashes($_GET["course"]));
        $description = mysqli_real_escape_string($con , stripcslashes($_GET["description"]));

        $jsonArray['id'] = $id;

        if (!is_numeric($id)) {
                
            $jsonArray['status'] = 'error';
            $jsonArray['message'] = 'El ID del item no es numérico';

        } else {

            $quantity = intval($quantity);
            $query = "SELECT * FROM reserves WHERE id = " . $id . " LIMIT 1";
            $queryResult = mysqli_query($con, $query);

            $dataOld = array();
            if ($row = mysqli_fetch_array($queryResult)) {

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
                
                $quantityPrevious = $row['quantity'];
                $item = $row['item'];
                $date = $row['date'];
                $hour = $row['hour'];
                $sameUsername = ($row['username'] == $username) ? true : false;
             
                $jsonArray['data_old'] = $dataOld;

                // Only administrators or owners of the reservations can delete or update the reservation
                if ((!$sameUsername) && ($userTypeAdmin != $userType)) {
                    $jsonArray['status'] = 'error';
                    $jsonArray['message'] = 'No es posible actualizar la reserva porque usted no fue la persona que realizó dicha reserva';

                } else {
                    
                    // Updated can be done (by the moment)
                    $query = "SELECT quantity FROM reserves 
                                WHERE item = '" . $item . "'
                                    AND date = '" . $date . "' 
                                    AND hour = '" . $hour . "'";
                    $queryResult = mysqli_query($con, $query);

                    $quantityAll = 0;
                    while ($row = mysqli_fetch_array($queryResult))
                        $quantityAll += $row['quantity'];

                    $quantityRemovingCurrentReserve = $quantityAll - $quantityPrevious;

                    if (($quantityRemovingCurrentReserve + $quantity) <= $itemsToReserveNumbers[$item]) {
                        $jsonArray['operation_real'] = "Actualización de reserva del profesorado";
                    
                        $query = "UPDATE reserves SET 
                                        quantity = " . $quantity .  ",
                                        course = '" . $course .  "',
                                        description = '" . $description .  "',
                                        reserve_modification = now()
                                    WHERE id = " . $id;

                        $queryDone = mysqli_query($con, $query);
                        if ($queryDone) {
                            $dataUpdated [] = array(
                                'id' => $id,
                                'item' => $item,
                                'date' => $date,
                                'hour' => $hour,
                                'quantity' => $quantity,
                                'username' => $username,
                                'course' => $course,
                                'description' => $description
                            );
    
                            $jsonArray['data-updated'] = $dataUpdated;
                            $dbChanged = true;

                        } else {
                            $jsonArray['status'] = 'error';
                            $jsonArray['message'] = 'Problema al actualizar datos en la BD';
                            $jsonArray['query'] = $query;
                        }


                    } else {
                        //Delete not done (errors)
                        $jsonArray['status'] = 'error';
                        $jsonArray['message'] = 'La quantity de items a seleccionar es mayor que la disponible';
                        $jsonArray['quantity'] = $quantity;
                    }
                }
                $jsonArray['item_key'] = $item;
                $jsonArray['item_value'] = $itemsToReserve[$item];
                $jsonArray['item_numbers'] = $itemsToReserveNumbers[$item];

            } else {
                $jsonArray['status'] = 'error';
                $jsonArray['message'] = 'No es posible actualizar la reserva porque no se encuentra el ID de dicha reserva en la base de datos';

            }
        }

    } else {
        $jsonArray['status'] = 'error';
        $jsonArray['message'] = 'No se ha indicado ID, quantity, course o description de la reserva a actualizar';

    }
}
