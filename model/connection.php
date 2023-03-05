


<?php


// DB connection constants

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','iesmarserena_reservas');

$con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (@mysqli_connect_errno()) die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
mysqli_set_charset($con, "utf8");
