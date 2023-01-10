<?php
date_default_timezone_set("America/La_Paz");
include "../modelo/conexion.php";

$saludo="hola mundo";
$hora = date("G");
$minutos = date("i");
$hoy = date("Y-m-d");

$marca= date("H:i");

$id_empleado = 13;

//$hab = $conexion->query(" SELECT parametroc.habilitar FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado WHERE id_empleado=$id_empleado "); 
//$habilitar = $hab->fetch_object()->habilitar;

$areaa = $conexion->query(" SELECT empleado.area FROM empleado where id_empleado=$id_empleado"); 
$area = $areaa->fetch_object()->area;

echo("Area nro: $area");
?>


