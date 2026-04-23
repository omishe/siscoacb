<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration of House</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <?php
    session_start();

    if (isset($_SESSION["usuario"])) {
        //header("Location:dashboard.php");
    }
    ?>

    <div class="container">
        <div class="form-container">
            <p class="title_main">Sistema de control SISCOACB</p>
            <div class="inner-container">
                <form action="" method="POST" class="form">
                    <h1 class="login-title">Home Registration</h1>
                    <div class="input-group">
                        <label for="nombre">Nombre de la casa: </label>
                        <input type="text" name="nombre" id="nombre" placeholder="nombre de la casa" required>
                    </div>
                    <div class="input-group">
                        <label for="direccion">Dirección de la casa: </label>
                        <input type="text" name="direccion" id="direccion" placeholder="direccion" required>
                    </div>
                    <div class="input-group">
                        <label for="Habitantes">Número de habitantes: </label>
                        <input type="text" name="habitantes" id="Habitantes" placeholder="habitantes" required>
                    </div>
                    <div class="input-group">
                        <label for="Usuario_idUsuario">ID de usuario: </label>
                        <input type="text" name="usuario_idUsuario" id="Usuario_idUsuario"
                            placeholder="Usuario_idUsuario" disabled value="<?php echo $_SESSION["idUsuario"]; ?>">
                    </div>
                    <input type="button" name="submit" id="submit" value="Register" class=" login-button" />
                    <input type="hidden" name="optionLbl" id="optionLbl" value="InsertHome">
                </form>

            </div>
            <div class="account-field">
                <p>Volver al dashboard: <a href="dashboard.php">Dashboard</a> | Logout: <a href="logout.php">Aquí</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        let submitBtn = document.querySelector('#submit');
        let nombreLbl = document.querySelector('#nombre');
        let direccionLbl = document.querySelector('#direccion');
        let habitantesLbl = document.querySelector('#Habitantes');
        let usuario_idUsuarioLbl = document.querySelector('#Usuario_idUsuario');
        let optionLbl = document.querySelector('#optionLbl');

        submitBtn.addEventListener('click', function () {

            fetch('http://localhost/siscoacb-api/api/controllers/casa.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'nombre': nombreLbl.value,
                    'direccion': direccionLbl.value,
                    'bandera': 1,
                    'habitantes': habitantesLbl.value,
                    'usuario_idUsuario': usuario_idUsuarioLbl.value,
                    'option': optionLbl.value,
                })
            }).then(response => response.json())
                .then(result => {
                    console.log(result)
                    let valueJSON = JSON.parse(result)
                    if (valueJSON.value) {
                        location.href = "http://localhost/siscoacb-api/authentication/dashboard.php";
                    }
                })
                .catch(error => console.error('Error: ', error));

        });

    </script>
</body>

</html>