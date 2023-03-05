

<?php
include('../model/connection.php');

session_start();

$userLogged = "";
$userType = "visitante";

if (isset($_SESSION["ies_usuario"]) && isset($_SESSION["ies_tipo"])) {
    $userLogged = $_SESSION["ies_usuario"];
    $userType = $_SESSION["ies_tipo"];

    // Cheking if it is the unique session
    $query = "SELECT session FROM logins where username = '" . $_SESSION["ies_usuario"] . "' LIMIT 1";
    $queryDone = mysqli_query($con, $query);
    $row = mysqli_fetch_row($queryDone);
    $idSession = $row[0];

    if ($idSession != $_SESSION["ies_id_sesion"]) {
        // Attention: Somebody is duplicating the session on another computer
        session_destroy();
        header("Location: index.php?session=destroy");
    }
}
