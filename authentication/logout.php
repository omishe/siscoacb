<?php
session_start();
$_SESSION['idUsuario'] = null;
$_SESSION['usuario'] = null;
$_SESSION['idCasa'] = null;
$_SESSION['nombreCasa'] = null;
$_SESSION['idContenedor1'] = null;
$_SESSION['nombreContenedor1'] = null;
$_SESSION['alturaContenedor1'] = null;
$_SESSION['idContenedor2'] = null;
$_SESSION['nombreContenedor2'] = null;
$_SESSION['alturaContenedor2'] = null;
$_SESSION['idSensor1'] = null;
$_SESSION['idSensor2'] = null;
$_SESSION = null;
session_destroy();

header("Location:login.php");

exit();
?>