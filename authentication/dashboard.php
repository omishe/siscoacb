<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location:login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboar</title>
</head>

<body>
    <h1>Dashboard</h1>
    <h2>Bienvenido: <?php echo $_SESSION['usuario']; ?></h2>
    <h3>Nombre de la casa: <?php if (isset($_SESSION['idCasa'])) {
        echo $_SESSION['idCasa'];
    } ?></h3>


    <p>Registrar casa: <a href="casa.php">Click aquí</a></p>
    <p>Registrar contenedor: <a href="contenedor.php">Click aquí</a></p>
        <div>
   <canvas id="grafica"></canvas>
    </div>
    <p>Salir de la sesión</p>
    <div>Logout: <a href="logout.php">Aquí</a></div>


    <script>
        window.addEventListener("load", function () {
            // Hacemos un llamado a la raspberry

            postData(url = "http://localhost/siscoacb-api/api/controllers/casa.php", data = {"option":"GetAll"});
            getUserData();
        });


        async function postData(url = "", data = {}) {
            try {
                const response = await fetch(url, {
                    method: "POST", // Specify the HTTP method
                    headers: {
                        "Content-Type": "application/json", // Inform the server about the data format
                    },
                    body: JSON.stringify(data), // Convert JS object to JSON string
                });

                if (!response.ok) {
                    // Fetch doesn't throw errors for 4xx/5xx status codes; check manually
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json(); // Wait for the response body to be parsed
                
                console.log(result);
                
                return result;
            } catch (error) {
                console.error("Error sending POST data:", error); // Handle network errors or server issues
            }
        }

        async function getUserData() {
            try {
                // Execution pauses here until the fetch completes
                const response = await fetch('https://example.com');

                // Execution pauses here until JSON is parsed
                const data = await response.json();

                console.log(data);
            } catch (error) {
                // Handles any error from the awaited promises
                console.error("Failed to fetch data:", error);
            }
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>

    <script>
        // Obtener una referencia al elemento canvas del DOM
const $grafica = document.querySelector("#grafica");
// Las etiquetas son las que van en el eje X. 
const etiquetas = ["Enero", "Febrero", "Marzo", "Abril"]
// Podemos tener varios conjuntos de datos. Comencemos con uno
const datosVentas2020 = {
    label: "Ventas por mes",
    data: [5000, 1500, 8000, 5102], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
    borderWidth: 1,// Ancho del borde
};
new Chart($grafica, {
    type: 'line',// Tipo de gráfica
    data: {
        labels: etiquetas,
        datasets: [
            datosVentas2020,
            // Aquí más datos...
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
        },
    }
});

    </script>
</body>

</html>