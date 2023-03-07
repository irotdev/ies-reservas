

<div class="cal1 login-ok">
    <?php echo $_SESSION["ies_usuario"]  . " (" . $_SESSION["ies_tipo"]  . ")"; ?>
    <button type="submit" class="css-button-sharp-red" onclick="logout('../controller/authentication-exit.php')">Salir</button>
</div>

<div class="cal1 register-user">
    <form action="../controller/register-user.php" id="register-user" method="post">

        <div class="input-group">
            <h5>Añadir usuario</h5>
            <div class="input-group-inside">
                <div class="input-parent">
                    <label for="ies_username">(*) Usuario</label>
                    <input type="text" id="ies_username" name="ies_username">
                </div>

                <div class="input-parent">
                    <label for="ies_password">(*) Contraseña</label>
                    <input type="password" id="ies_password" name="ies_password">
                </div>

                <div class="input-parent">
                    <label for="ies_email">Email</label>
                    <input type="text" id="ies_email" name="ies_email">
                </div>

                <div class="input-parent">
                    <label for="ies_username">Nombre</label>
                    <input type="text" id="ies_name" name="ies_name">
                </div>

                <div class="input-parent">
                    <label for="ies_surname">Apellidos</label>
                    <input type="text" id="ies_surname" name="ies_surname">
                </div>

                <div class="input-parent">
                    <label for="ies_departament">Departamento</label>
                    <input type="text" id="ies_departament" name="ies_departament">
                </div>
            </div>

            <div class="input-parent">
                <button type="submit" class="css-button-sharp-red">Entrar</button>
                <button type="submit" class="css-button-sharp-green">Recordar</button>
                <button type="submit" class="css-button-sharp-blue">Registrar</button>
            </div>

        </div>
    </form>
</div>