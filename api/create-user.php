

<?php

if ($operation == "createUser") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $addUsername = mysqli_real_escape_string($con , stripcslashes($_POST["username"]));
        $addName = (isset($_POST["name"]) ? mysqli_real_escape_string($con , stripcslashes($_POST["name"])) : "");
        $addSurname = (isset($_POST["surname"]) ? mysqli_real_escape_string($con , stripcslashes($_POST["surname"])) : "");
        $addEmail = (isset($_POST["email"]) ? mysqli_real_escape_string($con , stripcslashes($_POST["email"])) : "");
        $addPassword = mysqli_real_escape_string($con , stripcslashes($_POST["password"]));
        $addUserType = (isset($_POST["user_type"]) ? mysqli_real_escape_string($con , stripcslashes($_POST["user_type"])) : "");
        $addDepartment = (isset($_POST["department"]) ? mysqli_real_escape_string($con , stripcslashes($_POST["department"])) : "--DESCONOCIDO--");


        // TODO IF USER EXISTS --> ERROR
        // TODO IF PASSWORD IS EMPTY --> ERROR
        // TODO IF DEPARTMENT IS NOT A REAL DEPARTMENT --> WRITE AS "--DESCONOCIDO--"
        // TODO CREATE A VARIABLE AS "DEFAULT DEPARTMENT" AND WRITE AS "--DESCONOCIDO--"
        // TODO ELSE --> ADD USER --> SHOW CONFIRMATION IN NEW PAGE


    } else {
        $jsonArray['status'] = 'error';
        $jsonArray['message'] = 'Usuario y/o contraseña nuevos no definidos';

    }
}
