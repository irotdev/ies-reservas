


<?php

if (isset($_GET["login"])) {
     $login = mysqli_real_escape_string($con, stripcslashes($_GET["login"]));

     if (($login == "ok") && isset($_SESSION["ies_usuario"])) {
          ?>

<script>
     Swal.fire(
          '¡Bienvenido <?php echo $_SESSION["ies_usuario"]; ?>!',
          'Identificación realizada con éxito',
          'success'
     )
</script>

<?php
     } elseif ($login == "error") {
          ?>

<script>
     Swal.fire(
          '¡Error!',
          'Usuario o contraseña incorrectos',
          'error'
     )
</script>

<?php
     } elseif ($login == "exit") {
          ?>

<script>
     Swal.fire(
          '¡Hasta pronto!',
          'Sesión de usuario finalizada con éxito',
          'info'
     )
</script>

<?php
     }
 }
