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
        <input type="hidden" id="alturaContenedor1" value="<?php echo $_SESSION['alturaContenedor1']; ?>" />
        <input type="hidden" id="idContenedor2" value="<?php echo $_SESSION['idContenedor2']; ?>" />
        <input type="hidden" id="nombreContenedor2" value="<?php echo $_SESSION['nombreContenedor2']; ?>" />
        <input type="hidden" id="alturaContenedor2" value="<?php echo $_SESSION['alturaContenedor2']; ?>" />
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
                            <span id="percentContainer1">80%</span>
                        </h2>
                        <div id="animContainer1" class="contenedor-carga">
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
                            <span id="percentContainer2">20%</span>
                        </h2>
                        <div id="animContainer2" class="contenedor-carga">
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
                //console.log("Termino la primera", result)

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
                    // Usamos el id de los contenedores para obtener los sensores
                    //console.log("Termino la segunda", result)

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

                    // Asignamos la altura correspondiente en centimetros al contenedor 1
                    let animContainer1 = document.querySelector("#animContainer1");
                    animContainer1.dataset.altura = result[0].altura;

                    if (result.length <= 1) {
                        console.log("Le fata un tinaco")
                        return
                    }

                    // Usamos el id del segundo contenedor para obtener su sensor y nombre
                    let idContenedor2Value = result[1].idContenedor;
                    let nomContainer2 = document.querySelector("#nomContainer2");
                    nomContainer2.innerHTML = result[1].nombre;

                    // Asignamos la altura correspondiente en centimetros al contenedor 2
                    let animContainer2 = document.querySelector("#animContainer2");
                    animContainer2.dataset.altura = result[1].altura;

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
                        //console.log("Termino la tercera", result)
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
                            //console.log("Termino la cuarta", result)

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

                            // Asignamos el correspondiente volumen al contenedor 1
                            let animContainer1 = document.querySelector("#animContainer1");
                            animContainer1.dataset.volumen = result[0].volumen;

                            postData(url = "http://localhost/siscoacb-api/api/controllers/medicion.php", data = {
                                "option": "GetMeditionBySensorId",
                                "idSensor": idSensor2Value
                            }).then((result) => {
                                //console.log("Termino la quinta", result)

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

                                // Asignamos el correspondiente volumen al contenedor 1
                                let animContainer2 = document.querySelector("#animContainer2");
                                animContainer2.dataset.volumen = result[0].volumen;

                                postData(url = "http://localhost/siscoacb-api/api/controllers/medicion.php", data = {
                                    "option": "GetWaterContainerLevel",
                                    "idSensor": idSensor1Value
                                }).then((result) => {
                                    // Guardamos el promedio en la etiqueta del contenedor 1
                                    animContainer1.dataset.promedio = result[0].promedio;
                                    //Configuramos la animacion del contenedor
                                    setAnimationContainer(animContainer1, 1);

                                    postData(url = "http://localhost/siscoacb-api/api/controllers/medicion.php", data = {
                                        "option": "GetWaterContainerLevel",
                                        "idSensor": idSensor2Value
                                    }).then((result) => {
                                        // Guardamos el promedio en la etiqueta del contenedor 2
                                        animContainer2.dataset.promedio = result[0].promedio;
                                        //Configuramos la animacion del contenedor
                                        setAnimationContainer(animContainer2, 2);
                                    })
                                })

                            })
                        })

                    })
                })
            });

        });

        // Funcion que calcula el porcentaje de llenado del liquido segun el contenedor
        function setAnimationContainer(animContainer, numIdContainer) {
            // obtenemos los datos necesario que ya estan guardados en el DOM

            let liquidHeightAverage = animContainer.dataset.promedio;
            //console.log("Mi promedio es de: ", liquidHeightAverage)

            let containerHeight = animContainer.dataset.altura;
            //console.log("La altura del contenedor: ", containerHeight)

            let liquidHeightPercentage = parseInt((liquidHeightAverage / containerHeight) * 100);

            //console.log("variables promedio: ", liquidHeightAverage, containerHeight, liquidHeightPercentage)

            let sheet = document.styleSheets[0];

            if (numIdContainer == 1) {
                // Modificamos el valor css de la animacion del llenado al porcentaje asignado
                sheet.insertRule(`@keyframes llenar { from { height: 0% } to { height: ${liquidHeightPercentage}%} }`, sheet.cssRules.length);
                //nomContainer1.innerHTML = `<span>${liquidHeightPercentage}</span>`;

                let percentContainer1 = document.querySelector("#percentContainer1");
                percentContainer1.innerHTML = `<span>${liquidHeightPercentage}%</span>`;
            }

            if (numIdContainer == 2) {
                sheet.insertRule(`@keyframes llenar-pileta { from { height: 0% } to { height: ${liquidHeightPercentage}%} }`, sheet.cssRules.length);
                //nomContainer2.innerHTML = `<span>${liquidHeightPercentage}</span>`;

                let percentContainer2 = document.querySelector("#percentContainer2");
                percentContainer2.innerHTML = `<span>${liquidHeightPercentage}%</span>`;
            }

        }

        // Funcion que realiza todas las peticiones de datos

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



        //******** Scripts de la grafica de dona *******/

        // asiganamos eventos a los contenedores para conocer el valor de su sensor

        let selectedSensor = 0;
        let fullfilledContainer = 0;

        let animContainer1 = document.querySelector("#animContainer1");
        animContainer1.addEventListener('click', (event) => {
            let idSensor1 = document.querySelector("#idSensor1");
            selectedSensor = idSensor1.value;
            fullfilledContainer = parseFloat(animContainer1.dataset.altura);
        });

        let animContainer2 = document.querySelector("#animContainer2");
        animContainer2.addEventListener('click', (event) => {
            let idSensor2 = document.querySelector("#idSensor2");
            selectedSensor = idSensor2.value;
            fullfilledContainer = parseFloat(animContainer2.dataset.altura);
        });

        // funcion que responde al evento de seleccion del chart
        function getChartData(tipoDeLista) {
            console.log(selectedSensor)
            console.log("Tanque lleno: ", fullfilledContainer)
            if (selectedSensor > 0) {
                switch (tipoDeLista) {
                    case "hour":
                        postData(url = "http://localhost/siscoacb-api/api/controllers/medicion.php", data = {
                            "option": "GetRecent24HrsValues",
                            "idSensor": selectedSensor
                        }).then((result) => {
                            hourDataProccess(result);
                        })
                        break;

                    default:
                        break;
                }
            }
        }

        let hoursDonoutGraphicArray = [];
        let heightsDonoutGraphicArray = [];
        let consumptionsDonoutGraphicArray = [];
        let selectedHour = 0;
        let consumAcum = 0;

        // funcion para procesar los datos de grafica de dona por horas
        function hourDataProccess(data) {
            if (data.length <= 0) {
                return;
            } else {
                let counter = 0;
                hoursDonoutGraphicArray = [];
                consumptionsDonoutGraphicArray = [];
                heightsDonoutGraphicArray = [];
                selectedHour = 0;
                // Iteramos en cada elemento devuelto por el servidor
                data.forEach(element => {
                    let date = element.fecha;
                    let cmLevel = parseFloat(element.nivelCm);
                    let hour = date.substring(date.indexOf(" ")).trim();
                    let myHourStr = hour.substring(0, hour.lastIndexOf(":"));

                    let myHourInt = parseInt(hour.substring(0, hour.indexOf(":")));
                    //Aquí procesamos los datos restando o regresando a la altura del contenedor lleno

                    // verificamos que el array de consumo no este vacio para poder hacer la comparaciones
                    if (!consumptionsDonoutGraphicArray.length <= 0) {

                        // hacemos la resta del valor previo con el actual
                        let previousLevel = heightsDonoutGraphicArray[counter - 1];
                        console.log('prevLevel', previousLevel)
                        let myConsumption = previousLevel - cmLevel;

                        // Revisamos si la resta es igual o menor a cero y le asignamos la altura del contenedor ideal lleno
                        if (myConsumption < 0) {
                            myConsumption = fullfilledContainer;
                        }

                        consumAcum += myConsumption;

                        console.log('acum::: ', consumAcum)

                        if (selectedHour != myHourInt) {
                            let consumptionStrFormat = myHourStr + " " + consumAcum + "L.";
                            /*if(myConsumption == fullfilledContainer){
                               consumptionStrFormat = myHourStr + " Recarga."
                           }*/
                            hoursDonoutGraphicArray.push(consumptionStrFormat); // labels
                            heightsDonoutGraphicArray.push(cmLevel); //alturas
                            consumptionsDonoutGraphicArray.push(consumAcum); // consumos

                        } else {
                            consumAcum = 0;
                        }
                    } else {
                        let consumptionStrFormat = myHourStr + " " + cmLevel + "L.";
                        hoursDonoutGraphicArray.push(consumptionStrFormat);
                        heightsDonoutGraphicArray.push(cmLevel)

                        consumptionsDonoutGraphicArray.push(cmLevel);
                        selectedHour = myHourInt;
                    }

                    selectedHour = myHourInt;
                    consumAcum = 0;
                    counter++;
                    //let hourArray = hour.split(":");
                    //let timestamp = new Date(hour[0], hour[1], hour[2]);
                    //let timestamp = Date.parse(date)
                    //console.log("Mi hora es:", hour, "Mi horaInt es:", myHourInt, "y el nivel de mi agua es:", cmLevel);
                    //console.log("My timestamp es: ", timestamp);

                });
            }
            myChart.data.labels = hoursDonoutGraphicArray;
            myChart.data.datasets[0].data = consumptionsDonoutGraphicArray;
            myChart.update();

            console.log(hoursDonoutGraphicArray)
            console.log(heightsDonoutGraphicArray);
            console.log(consumptionsDonoutGraphicArray)

        }

        // llamado al tipo de vista de consumo

        let waterComsuption = document.querySelector("#waterComsuption");

        let chartLabels = [
            '00'
        ];

        let chartDataValues = [
            '1'
        ];

        let chartColors = [
            '#A3044C',
            '#8EC5FF',
            '#101828',
            '#015F78',
            '#F6339A',
            '#31D492',
            '#5D0EC0',
            '#0D542B',
            '#E7180B',
            '#10598A',
            '#7B3306',
            '#162456',
            '#2AA63E',
            '#2B7FFF',
            '#8B0836',
            '#38D5BE',
            '#FFDF20',
            '#460809',
            '#E4E4E7',
            '#ED6AFF',
            '#4F39F6',
            '#D8F999',
            '#1E2939',
            '#FFF085'
        ]

        waterComsuption.addEventListener("change", function (event) {

            let tipoDeLista = event.target.value;

            switch (tipoDeLista) {
                case 'hour':
                    getChartData(tipoDeLista)
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
                        '217',
                        '42',
                        '150',
                        '186',
                        '241',
                        '58',
                        '104'
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
                backgroundColor: chartColors,

            }
        });

    </script>
</body>

</html>