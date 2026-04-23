<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de mis alertas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php
    session_start();

    session_start();

    if (isset($_SESSION["usuario"])) {
        //header("Location:dashboard.php");
    }

    ?>

    <div class="container">

        <div class="form-container-alert">
            <p class="title_main">Sistema de control SISCOACB</p>
            <div class="days-inner-container">
                <form action="" method="POST" class="form">
                    <h1 class="login-title">Configuración de mis alertas</h1>
                    <br />
                    <p>Me gustaria recibir mis alertas los días:</p>
                    <div class="input-group-days">

                        <label for="prefDay">Domingo</label>
                        <input type="checkbox" name="prefDay" value="sunday">
                        <label for="prefDay">Lunes</label>
                        <input type="checkbox" name="prefDay" value="monday">
                        <label for="prefDay">Martes</label>
                        <input type="checkbox" name="prefDay" value="tuesday">
                        <label for="prefDay">Miércoles</label>
                        <input type="checkbox" name="prefDay" value="wednesday">
                        <label for="prefDay">Jueves</label>
                        <input type="checkbox" name="prefDay" value="thursday">
                        <label for="prefDay">Viernes</label>
                        <input type="checkbox" name="prefDay" value="friday">
                        <label for="prefDay">Sábado</label>
                        <input type="checkbox" name="prefDay" value="saturday">

                    </div>

                    <br />
                    <div class="input-group-days">

                        <label for="hours">Cada hora(s):</label>
                        <input type="number" id="hours" name="hours" min="1" max="24" step="1" value="1">

                    </div>

                </form>
                <div>
                    <input type="hidden" name="optionLbl" id="optionLbl" value="GetUser">
                    <input type="button" name="submit" id="submit" value="Guardar" class=" login-button" />
                </div>
            </div>
            <div class="account-field">
                <p>Volver al dashboard: <a href="dashboard.php">Dashboard</a> | Logout: <a href="logout.php">Aquí</a>
                </p>
            </div>

        </div>
    </div>
    <script>
        /* let submitBtn = document.querySelector('#submit');
         let usuarioLbl = document.querySelector('#usuario');
         let passwordLbl = document.querySelector('#password');
         let optionLbl = document.querySelector('#optionLbl');
 
         submitBtn.addEventListener('click', function () {
 
             fetch('http://localhost/siscoacb-api/api/controllers/usuario.php', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json'
                 },
                 body: JSON.stringify({
                     'usuario': usuarioLbl.value,
                     'password': passwordLbl.value,
                     'option': optionLbl.value,
                 })
             }).then(response => response.json())
                 .then(result => {
                     console.log("Llega aqui")
                     let valueJSON = JSON.parse(result)
                     if (valueJSON.value) {
                         location.href = "http://localhost/siscoacb-api/authentication/dashboard.php";
                     }
                 })
                 .catch(error => console.error('Error: ', error));
         });*/

    </script>
</body>

</html>