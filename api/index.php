

<?php
header('Content-Type: application/json');

session_start();

include('../model/connection.php');
include('../model/constants.php');

$jsonArray = array();
$item = "";
$operation = "";
$login = false;
$dbChanged = false;
$username = "";
$userType = "";
$idSession = "";

if (isset($_SESSION["ies_usuario"]) && isset($_SESSION["ies_tipo"])) {
    $query = mysqli_query($con,"SELECT session, user_type FROM logins where username = '" . $_SESSION["ies_usuario"] . "' LIMIT 1");
    $row = mysqli_fetch_row($query);
    $idSession = $row[0];
    if ($idSession == $_SESSION["ies_id_sesion"]) $login = true;
}

if (isset($_GET["operation"])) {
    $operation = mysqli_real_escape_string($con , stripcslashes($_GET["operation"]));
    if (!in_array($operation, $operationCrud)) {
        $jsonArray['status'] = 'error';
        $jsonArray['message'] = 'Operación incorrecta';

    } else {
        $jsonArray['status'] = 'ok';
        $jsonArray['message'] = 'Instrucción ejecutada con éxito';


        // Some operations need to an identification of the user
        if (($operation == "create") || ($operation == "delete") || ($operation == "update")) {
            if (isset($_SESSION["ies_usuario"]) && isset($_SESSION["ies_tipo"])) {

                if ($idSession != $_SESSION["ies_id_sesion"]) {
                    $jsonArray['status'] = 'error';
                    $jsonArray['message'] = 'Sesión de usuario incorrecta';
                } else {
                    $username = $_SESSION["ies_usuario"];
                    $userType = $row[1];

                    // To create new reservations
                    include('../api/create.php');
                    include('../api/delete.php');
                    include('../api/update.php');

                    if ($userType == $userTypeAdmin) include('../api/create-user.php');
                }

            } elseif  ($operation == "createUser") {

            } else {
                $jsonArray['status'] = 'error';
                $jsonArray['message'] = 'Usuario no identificado. Es necesario estar identificado para realizar reservas.';
            }

        } elseif ($operation == "read") {
            include('../api/read.php');
                    
        }
    }

} else {
    $jsonArray['status'] = 'error';
    $jsonArray['operation'] = 'incorrect';
    $jsonArray['message'] = 'Sin parámetros';
}


if ($login) {
    $jsonArray['username'] = $username;
    $jsonArray['user_type'] = $userType;
}

$jsonArray['operation'] = $operation;
$jsonArray['login'] = $login;
$jsonArray['db_changed'] = $dbChanged;

// Coding to json format
$json = json_encode($jsonArray);

echo $json;
