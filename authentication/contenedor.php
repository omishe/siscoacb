<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Container</title>
</head>

<body>

<?php
   session_start();

    if (isset($_SESSION["usuario"])) {
        //header("Location:dashboard.php");
    }
?>

    <form action="" method="POST" class="form">
        <h1 class="login-title">Container Registration</h1>
        <input type="text" name="nombre" id="nombre" placeholder="nombre" required><br />
        <input type="text" name="altura" id="altura" placeholder="altura" required><br />
        <input type="text" name="radio" id="radio" placeholder="radio" required><br />
        <input type="text" name="casa_idCasa" id="casa_idCasa" placeholder="Casa_idCasa" required><br />
        <input type="button" name="submit" id="submit" value="Register" class=" login-button" />
        <input type="hidden" name="optionLbl" id="optionLbl" value="InsertContainer">
    </form>
    <p class="link">Already have an account? <a href="login.php">Login here</a></p>

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