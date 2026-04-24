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
    <form>
        <input type="hidden" id="idUsuario" value="<?php echo $_SESSION['idUsuario']; ?>" />
        <input type="hidden" id="usuario" value="<?php echo $_SESSION['usuario']; ?>" />
        <input type="hidden" id="idCasa" value="<?php echo $_SESSION['idCasa']; ?>" />
        <input type="hidden" id="nombreCasa" value="<?php echo $_SESSION['nombreCasa']; ?>" />
        <input type="hidden" id="idContenedor1" value="<?php echo $_SESSION['idContenedor1']; ?>" />
        <input type="hidden" id="nombreContenedor1" value="<?php echo $_SESSION['nombreContenedor1']; ?>" />
        <input type="hidden" id="idContenedor2" value="<?php echo $_SESSION['idContenedor2']; ?>" />
        <input type="hidden" id="nombreContenedor2" value="<?php echo $_SESSION['nombreContenedor2']; ?>" />
        <input type="hidden" id="idSensor1" value="<?php echo '' . $_SESSION['idSensor1']; ?>" />
        <input type="hidden" id="idSensor2" value="<?php echo '' . $_SESSION['idSensor2']; ?>" />
    </form>
    <div class="container">
        <div class="dashboard-container">
            <h1 class="title_main">Dashboard</h1>
            <div class="dashboard-inner-container">

                <div class="user_titles">
                    <h2>Bienvenido:
                        <?php echo $_SESSION['usuario']; ?>
                    </h2>
                    <h3>Nombre de la casa:
                        <span id="nomCasa">
                            <?php if (isset($_SESSION['idCasa'])) {
                                echo $_SESSION['idCasa'];
                            } else {
                                echo "Sin casa registrada";
                            } ?>
                        </span>
                    </h3>
                </div>


                <div class="container-register">
                    <p>Registrar casa: <a id="registrarCasaBtn" href="casa.php">Click aquí</a></p>
                    <p>Registrar contenedor: <a id="registrarContenedorBtn" href="contenedor.php">Click aquí</a></p>
                </div>

                <div class="container-graficas">
                    <div class="container-contenedor">
                        <h2 class="container-charge-percent">Porcentaje de llenado de:<br />
                            <span id="nomContainer1"><?php echo $_SESSION["nombreContenedor1"]; ?></span>
                            <span>80%</span>
                        </h2>
                        <div class="contenedor-carga">
                            <div class="relleno"></div>
                        </div>
                        <div class="container-recent-measures">
                            <div class="recent-measure recent-measures-titles">
                                <span># Medición</span>
                                <span>Fecha</span>
                                <span>Nivel en cm</span>
                            </div>
                            <div id="recent_measures1">

                            </div>

                        </div>
                    </div>
                    <div class="container-contenedor">
                        <h2 class="container-charge-percent">Porcentaje de llenado de:<br />
                            <span id="nomContainer2"><?php echo $_SESSION["nombreContenedor2"]; ?></span>
                            <span>20%</span></h2>
                        <div class="contenedor-carga">
                            <div class="relleno-pileta"></div>
                        </div>
                        <div class="container-recent-measures">
                            <div class="recent-measure recent-measures-titles">
                                <span># Medición</span>
                                <span>Fecha</span>
                                <span>Nivel en cm</span>
                            </div>
                            <div id="recent_measures2">

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

    <script>
        window.addEventListener("load", function () {
            // Hacemos un llamado a la raspberry

            // Usamos el id del usuario para obtener la priemra casa registrada
            const userId = document.querySelector("#idUsuario").value;
            //console.log('El id del usuario es: ', idUsuario)

            postData(url = "http://localhost/siscoacb-api/api/controllers/casa.php", data = {
                "option": "GetHomeByUserId",
                "userId": userId
            }).then((result) => {
                console.log("Termino la primera", result)

                if (result.length <= 0) {
                    console.log("No ha registrado aun ninguna casa")
                    return
                }


                // Configuramos los elementos referentes a la casa del usuario
                let nomCasa = document.querySelector('#nomCasa');
                nomCasa.textContent = result[0].nombre;
                let = registrarCasaBtn = document.querySelector("#registrarCasaBtn");
                registrarCasaBtn.style.pointerEvents = 'none';
                registrarCasaBtn.style.color = 'gray';
                registrarCasaBtn.style.cursor = 'default';

                // Usamos el id de la casa para obtener los contenedores
                const houseId = result[0].idCasa;

                postData(url = "http://localhost/siscoacb-api/api/controllers/contenedor.php", data = {
                    "option": "GetContentsByHouseId",
                    "houseId": houseId
                }).then((result) => {
                    console.log("Termino la segunda", result)

                    if (result.length <= 0) {
                        console.log("No ha registrado aun ningun tinaco")
                        return
                    }

                    // Configuramos los elementos de los contenedores
                    let = registrarCasaBtn = document.querySelector("#registrarContenedorBtn");

                    // Usamos el id del primer contenedor para obtener su sensor y nombre
                    let idContenedor1Value = result[0].idContenedor;
                    let nomContainer1 = document.querySelector("#nomContainer1");
                    nomContainer1.innerHTML = result[0].nombre;

                    if (result.length <= 1) {
                        console.log("Le fata un tinaco")
                        return
                    }

                    // Usamos el id del segundo contenedor para obtener su sensor y nombre
                    let idContenedor2Value = result[1].idContenedor;
                    let nomContainer2 = document.querySelector("#nomContainer2");
                    nomContainer2.innerHTML = result[1].nombre;

                    // Aquí desabilitamos el botón de registro de contenedores cuando ya son 2

                    if (result.length >= 2) {

                        registrarCasaBtn.style.pointerEvents = 'none';
                        registrarCasaBtn.style.color = 'gray';
                        registrarCasaBtn.style.cursor = 'default';
                    }

                    postData(url = "http://localhost/siscoacb-api/api/controllers/sensor.php", data = {
                        "option": "GetSensorByContentId",
                        "contentId1": idContenedor1Value,
                        "contentId2": idContenedor2Value
                    }).then((result) => {
                        console.log("Termino la tercera", result)
                        // Usamos los id de los sensores para traer los tres registros más recientes en orden descendnte

                        if (result.length <= 0) {
                            console.log("No ha registrado aun ningun sensor")
                            return
                        }

                        let idSensor1Value = result[0].idSensor;
                        let idSensor2Value = result[1].idSensor;

                        postData(url = "http://localhost/siscoacb-api/api/controllers/medicion.php", data = {
                            "option": "GetMeditionBySensorId",
                            "idSensor": idSensor1Value
                        }).then((result) => {
                            console.log("Termino la cuarta", result)

                            // Entramos en los datos del sensor 1
                            myStr = "";
                            for (let i = 0; i < result.length; i++) {
                                let myDiv = document.createElement('div');
                                myDiv.className = "recent-measure";

                                let myObject = result[i];
                                let myStr = '<span>' + myObject.idMedicion + '</span><span>' + myObject.fecha + '</span><span>' + myObject.nivelCm + '</span>';

                                myDiv.innerHTML = myStr;

                                recent_measures1.appendChild(myDiv);
                                myStr = "";
                            }

                            postData(url = "http://localhost/siscoacb-api/api/controllers/medicion.php", data = {
                                "option": "GetMeditionBySensorId",
                                "idSensor": idSensor2Value
                            }).then((result) => {
                                console.log("Termino la quinta", result)

                                // Entramos en los datos del sensor 2
                                myStr = "";
                                for (let i = 0; i < result.length; i++) {
                                    let myDiv = document.createElement('div');
                                    myDiv.className = "recent-measure";

                                    let myObject = result[i];
                                    let myStr = '<span>' + myObject.idMedicion + '</span><span>' + myObject.fecha + '</span><span>' + myObject.nivelCm + '</span>';

                                    myDiv.innerHTML = myStr;

                                    recent_measures2.appendChild(myDiv);
                                    myStr = "";
                                }

                            });
                        })


                    })
                })
            });

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

                return result;
            } catch (error) {
                console.error("Error sending POST data:", error); // Handle network errors or server issues
            }
        }

        /*async function getUserData() {

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
        }*/


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