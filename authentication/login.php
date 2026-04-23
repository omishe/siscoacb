<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <?php
    session_start();

    if (isset($_SESSION["usuario"])) {
        header("Location:dashboard.php");
    }

    if (isset($_POST["usuario"])) {
        // obtenemos los datos de la base de datos
    
        if ($result) {
            $_SESSION["usuario"] = $username;
            header("Location: dashboard.php");
        }
    }

    ?>

    <div class="container">

        <div class="form-container">
            <p class="title_main">Sistema de control SISCOACB</p>
            <div class="inner-container">
                <form action="" method="POST" class="form">
                    <h1 class="login-title">Login</h1>
                    <div class="input-group">
                        <label for="usuario">Usuario: </label>
                        <input type="text" name="usuario" id="usuario" placeholder="usuario" required><br />
                    </div>
                    <div>
                        <label for="usuario">Password: </label>
                        <input type="password" name="password" id="password" placeholder="contraseña" required><br />
                    </div>

                    <input type="hidden" name="optionLbl" id="optionLbl" value="GetUser">
                    <input type="button" name="submit" id="submit" value="Login" class=" login-button" />
                </form>
            </div>
            <div class="account-field">
                <p class="link">Not registered an account yet? <a href="registration.php">Register here</a></p>
            </div>

        </div>
    </div>
    <script>
        let submitBtn = document.querySelector('#submit');
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
        });

    </script>
</body>

</html>