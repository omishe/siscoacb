<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Container</title>
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
                    <h1 class="login-title">Container Registration</h1>
                    <div class="input-group">
                        <label for="nombre">Nombre del contenedor: </label>
                        <input type="text" name="nombre" id="nombre" placeholder="nombre del contenedor" required><br />
                    </div>
                    <div class="input-group">
                        <label for="altura">Altura del contenedor (cm): </label>
                        <input type="text" name="altura" id="altura" placeholder="Altura del contenedor (cm)" required><br />
                    </div>
                    <div class="input-group">
                        <label for="radio">Radio del contenedor (cm): </label>
                        <input type="text" name="radio" id="radio" placeholder="Radio del contenedor (cm)" required><br />
                    </div>
                    <div class="input-group">
                        <label for="casa_idCasa">ID de la casa: </label>
                        <input type="text" name="casa_idCasa" id="casa_idCasa" placeholder="ID de la casa"
                            value="<?php echo $_SESSION["idCasa"]; ?>" disabled><br />
                    </div>
                    <input type="button" name="submit" id="submit" value="Register" class=" login-button" />
                    <input type="hidden" name="optionLbl" id="optionLbl" value="InsertContainer">
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
        let alturaLbl = document.querySelector('#altura');
        let radioLbl = document.querySelector('#radio');
        let casa_idCasaLbl = document.querySelector('#casa_idCasa');
        let optionLbl = document.querySelector('#optionLbl');

        submitBtn.addEventListener('click', function () {


            fetch('http://localhost/siscoacb-api/api/controllers/contenedor.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'nombre': nombreLbl.value,
                    'altura': parseFloat(alturaLbl.value),
                    'radio': parseFloat(radioLbl.value),
                    'bandera': 1,
                    'casa_idCasa': casa_idCasaLbl.value,
                    'option': optionLbl.value,
                })
            }).then(response => response.json())
                .then(result => {
                    console.log(result)
                    let valueJSON = JSON.parse(result)
                    if (valueJSON.value) {
                        location.href = "http://localhost/siscoacb-api/authentication/login.php";
                    }
                })
                .catch(error => console.error('Error: ', error));

        });

    </script>
</body>

</html>