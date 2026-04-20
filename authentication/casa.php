<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration of House</title>
</head>

<body>

<?php
   session_start();

    if (isset($_SESSION["usuario"])) {
        //header("Location:dashboard.php");
    }
?>

    <form action="" method="POST" class="form">
        <h1 class="login-title">Home Registration</h1>
        <input type="text" name="nombre" id="nombre" placeholder="nombre" required><br />
        <input type="text" name="direccion" id="direccion" placeholder="direccion" required><br />
        <input type="text" name="Habitantes" id="Habitantes" placeholder="Habitantes" required><br />
        <input type="text" name="Usuario_idUsuario" id="Usuario_idUsuario" placeholder="Usuario_idUsuario" required><br />
        <input type="button" name="submit" id="submit" value="Register" class=" login-button" />
        <input type="hidden" name="optionLbl" id="optionLbl" value="InsertHome">
    </form>
    <p class="link">Already have an account? <a href="login.php">Login here</a></p>

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
                        location.href = "http://localhost/siscoacb-api/authentication/login.php";
                    }
                })
                .catch(error => console.error('Error: ', error));

        });

    </script>
</body>

</html>