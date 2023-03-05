

<div class="cal1 login-ok">
    <?php echo $_SESSION["ies_usuario"]  . " (" . $_SESSION["ies_tipo"]  . ")"; ?>
    <button type="submit" class="css-button-sharp-red" onclick="logout('../controller/authentication-exit.php')">Salir</button>
</div>