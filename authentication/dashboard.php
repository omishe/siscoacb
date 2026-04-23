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
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- <script src="js/chart.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <div class="dashboard-container">
            <h1 class="title_main">Dashboard</h1>
            <div class="dashboard-inner-container">

                <div class="user_titles">
                    <h2>Bienvenido:
                        <?php echo $_SESSION['usuario']; ?>
                    </h2>
                    <h3>Nombre de la casa:
                        <?php if (isset($_SESSION['idCasa'])) {
                            echo $_SESSION['idCasa'];
                        } else {
                            echo "Sin casa registrada";
                        } ?>
                    </h3>
                </div>


                <div class="container-register">
                    <p>Registrar casa: <a href="casa.php">Click aquí</a></p>
                    <p>Registrar contenedor: <a href="contenedor.php">Click aquí</a></p>
                </div>

                <div class="container-graficas">
                    <div class="container-contenedor">
                        <h2 class="container-charge-percent">Porcentaje de llenado del contenedor: 80%</h2>
                        <div class="contenedor-carga">
                            <div class="relleno"></div>
                        </div>
                        <div class="container-recent-measures">
                            <div class="recent-measure recent-measures-titles">
                                <span># Medición</span>
                                <span>Fecha</span>
                                <span>Nivel en cm</span>
                            </div>
                            <div class="recent-measure">
                                <span>1</span>
                                <span>2026-04-20 12:17:06</span>
                                <span>266.6</span>
                            </div>
                            <div class="recent-measure">
                                <span>2</span>
                                <span>2026-04-20 13:17:06</span>
                                <span>270.0</span>
                            </div>
                            <div class="recent-measure">
                                <span>3</span>
                                <span>2026-04-20 11:17:06</span>
                                <span>260.6</span>
                            </div>
                        </div>
                    </div>
                    <div class="container-contenedor">
                        <h2 class="container-charge-percent">Porcentaje de llenado de la pileta: 20%</h2>
                        <div class="contenedor-carga">
                            <div class="relleno-pileta"></div>
                        </div>
                        <div class="container-recent-measures">
                            <div class="recent-measure recent-measures-titles">
                                <span># Medición</span>
                                <span>Fecha</span>
                                <span>Nivel en cm</span>
                            </div>
                            <div class="recent-measure">
                                <span>1</span>
                                <span>2026-04-20 12:17:06</span>
                                <span>66.6</span>
                            </div>
                            <div class="recent-measure">
                                <span>2</span>
                                <span>2026-04-20 13:17:06</span>
                                <span>70.0</span>
                            </div>
                            <div class="recent-measure">
                                <span>3</span>
                                <span>2026-04-20 11:17:06</span>
                                <span>60.6</span>
                            </div>
                        </div>
                    </div>
                    <div class="grafica-consumo">
                        <form>
                            <div>
                                <label for="waterComsuption">Ver consumo por:</label>
                                <select name="waterComsuption" id="waterComsuption">
                                    <option selected value="hour">Hora</option>
                                    <option value="day">Día</option>
                                    <option value="month">Mes</option>
                                </select>
                            </div>
                        </form>
                        <canvas id="grafica"></canvas>
                    </div>
                </div>

                <div class="container-no-service">
                    <p>Días sin servicio: <span class="no-service-days-green">0</span></a>
                </div>

                <div class="container-logout">
                    <span>Configurar mis alertas <a href="alertas.php">Aquí</a></span>
                    <span>Salir de la sesión <a href="logout.php">Aquí</a></span>
                </div>
            </div>

        </div>
    </div>
    </div>
    <form>
        <input type="hidden" id="idUsuario" value="<?php echo $_SESSION['idUsuario']; ?>">
    </form>
    <script>
        window.addEventListener("load", function () {
            // Hacemos un llamado a la raspberry

            const idUsuario = document.querySelector("#idUsuario").value;
            //console.log('El id del usuario es: ', idUsuario)

            postData(url = "http://localhost/siscoacb-api/api/controllers/casa.php", data = { "option": "GetAll" });
            //getUserData();
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

                //console.log(result);

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


        // llamado al tipo de vista de consumo

        let waterComsuption = document.querySelector("#waterComsuption");

        let chartLabels = [
            '00:00',
            '01:00',
            '02:00',
            '03:00',
            '04:00',
            '05:00',
            '06:00',
            '07:00',
            '08:00',
            '09:00',
            '10:00',
            '11:00',
            '12:00',
            '13:00',
            '14:00',
            '15:00',
            '16:00',
            '17:00',
            '18:00',
            '19:00',
            '20:00',
            '21:00',
            '22:00',
            '23:00',
            '24:00'];

        let chartDataValues = [
            '15',
            '04',
            '98',
            '02',
            '09',
            '54',
            '65',
            '20',
            '30',
            '15',
            '60',
            '78',
            '90',
            '66',
            '77',
            '88',
            '36',
            '47',
            '35',
            '36',
            '47',
            '100',
            '69',
            '23',
            '01'];

        waterComsuption.addEventListener("change", function (event) {
            switch (event.target.value) {
                case 'hour':
                    console.log('Solicitaste horas')
                    myChart.data.labels = chartLabels
                    myChart.data.datasets[0].data = chartDataValues;
                    break;
                case 'day':
                    console.log('Solicitaste dias');
                    myChart.data.labels = [
                        'Domingo',
                        'Lunes',
                        'Martes',
                        'Miércoles',
                        'Jueves',
                        'Viernes',
                        'Sábado'];

                    myChart.data.datasets[0].data = [
                        '500',
                        '40',
                        '87',
                        '47',
                        '78',
                        '65',
                        '70'
                    ]

                    break;
                case 'month':
                    console.log('Solicitaste meses');
                    myChart.data.labels = [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Junio',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'];

                    myChart.data.datasets[0].data = [
                        '1040',
                        '900',
                        '1540',
                        '698',
                        '2785',
                        '1987',
                        '2020',
                        '236',
                        '990',
                        '1240',
                        '475',
                        '963'
                    ]
                    break;
            }
            myChart.update();
        });



        const ctx = document.getElementById('grafica');

        let myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Ltrs. consumidos',
                    data: chartDataValues,
                    borderWidth: 1
                }]
            },
            options: {

            }
        });

    </script>
</body>

</html>