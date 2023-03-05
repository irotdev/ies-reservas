

<?php

if ($operation == "delete") {
    if (isset($_GET["id"])) {
        $id = mysqli_real_escape_string($con , stripcslashes($_GET["id"]));
        $jsonArray['id'] = $id;

        if (!is_numeric($id)) {
                
            $jsonArray['status'] = 'error';
            $jsonArray['message'] = 'El ID del item no es numérico';

        } else {

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
                
                $sameUsername = ($row['username'] == $username) ? true : false;
                $jsonArray['data_old'] = $dataOld;

                // Only administrators or owners of the reservations can delete or update the reservation
                if ((!$sameUsername) && ($userTypeAdmin != $userType)) {
                    $jsonArray['status'] = 'error';
                    $jsonArray['message'] = 'No es posible cancelar la reserva porque usted no fue la persona que realizó dicha reserva';

                } else {
                    // Deleted can be done
                    $jsonArray['operation_real'] = "Eliminación de una de las reservas";
                    $query = "DELETE FROM reserves WHERE id = " . $id . " ";
                    $queryDone = mysqli_query($con, $query);

                    if ($queryDone) {
                        // Delete done
                        $jsonArray['id'] = $id;
                        $dbChanged = true;

                    } else {
                        //Delete not done (errors)
                        $jsonArray['status'] = 'error';
                        $jsonArray['message'] = 'Problema al eliminar una reserva de la BD';
                        $jsonArray['query'] = $query;
                    }
                }

            } else {
                $jsonArray['status'] = 'error';
                $jsonArray['message'] = 'No es posible eliminar la reserva porque no se encuentra el ID de dicha reserva en la base de datos';

            }
        }

    } else {
        $jsonArray['status'] = 'error';
        $jsonArray['message'] = 'No se ha indicado el ID de la reserva a eliminar';

    }
}
