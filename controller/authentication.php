

<?php
include('../model/connection.php');

session_start();

if (isset($_POST["ies_username"]) && isset($_POST["ies_password"])) {
    $username = $_POST["ies_username"];
    $password = $_POST["ies_password"];

    // to prevent from mysqli injection, and avoid typical problem of teachers: capital letters
    $username = strtolower(mysqli_real_escape_string($con , stripcslashes($username)));
    $password = strtolower(mysqli_real_escape_string($con , stripcslashes($password)));

    $sql = "SELECT * FROM logins where username = '$username' AND password = '$password'" ;
    $result = mysqli_query($con , $sql);
    $row = mysqli_fetch_array($result , MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $messages[] = "Identificación de alumno realizada con éxito.";
        $_SESSION["ies_usuario"] = $username;
        $_SESSION["ies_id_sesion"] = "id" . mt_rand(0,999999);
        $_SESSION["ies_tipo"] = "profesorado";

        $sql = "UPDATE logins SET session='" . $_SESSION["ies_id_sesion"] . "' WHERE username='$username'";
        $query = mysqli_query($con, $sql);

        $sql = "INSERT INTO session (username, session) VALUES ('" . $username . "', '" . $_SESSION["ies_id_sesion"] . "')";
        $query = mysqli_query($con, $sql);
        
        include_once("../controller/connection-close.php");
        header("Location: ../view/index.php?login=ok");

    } else {
        
        include_once("../controller/connection-close.php");
        header("Location: ../view/index.php?login=error");
    }
}
