<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>

<body>

<?php
   session_start();

    if (isset($_SESSION["usuario"])) {
        header("Location:dashboard.php");
    }
?>

    <form action="" method="POST" class="form">
        <h1 class="login-title">Registration</h1>
        <input type="text" name="usuario" id="usuario" placeholder="usuario" required><br />
        <input type="text" name="password" id="password" placeholder="contraseña" required><br />
        <input type="text" name="nombre" id="nombre" placeholder="nombre" required><br />
        <input type="text" name="apellidoPat" id="apellidoPat" placeholder="apellido paterno" required><br />
        <input type="text" name="apellidoMat" id="apellidoMat" placeholder="apellido materno" required><br />
        <input type="text" name="email" id="email" placeholder="email" required><br />
        <input type="button" name="submit" id="submit" value="Register" class=" login-button" />
        <input type="hidden" name="optionLbl" id="optionLbl" value="InsertUser">
    </form>
    <p class="link">Already have an account? <a href="login.php">Login here</a></p>

    <script>
        let submitBtn = document.querySelector('#submit');
        let usuarioLbl = document.querySelector('#usuario');
        let passwordLbl = document.querySelector('#password');
        let nombreLbl = document.querySelector('#nombre');
        let apellidoPatLbl = document.querySelector('#apellidoPat');
        let apellidoMatLbl = document.querySelector('#apellidoMat');
        let emailLbl = document.querySelector('#email');
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
                    'nombre': nombreLbl.value,
                    'apellidoPat': apellidoPatLbl.value,
                    'apellidoMat': apellidoMatLbl.value,
                    'email': emailLbl.value,
                    'option': optionLbl.value,
                })
            }).then(response => response.json())
                .then(result => {
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