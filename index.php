<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Bienvenida</title>
    <! con link se esta llamando al css especificando su ruta>
    <!-- <link rel="stylesheet" href="public/estilos/estilos.css"> -->
    <link rel="stylesheet" href="public/estilos/estiloss.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400&display=swap" rel="stylesheet">

    <!-- pNotify -->
    <link href="public/pnotify/css/pnotify.css" rel="stylesheet" />
        <link href="public/pnotify/css/pnotify.buttons.css" rel="stylesheet" />
        <link href="public/pnotify/css/custom.min.css" rel="stylesheet" />
    <!-- pnotify -->
        <script src="public/pnotify/js/jquery.min.js">
        </script>
        <script src="public/pnotify/js/pnotify.js">
        </script>
        <script src="public/pnotify/js/pnotify.buttons.js">
        </script>
</head>
<body>
<?php 
date_default_timezone_set("America/La_Paz");
?>
    <h1>Bienvenido, Registre su Asistencia</h1>
    <h2 id="fecha"><?= date("d/m/Y, H:i:s") ?> </h2>
<?php 
include "modelo/conexion.php";
include "controlador/controlador_registrar_asistencia.php";
?>


    <div class="container">
        <a class="acceso" href="vista/login/login.php">Ingresar al Sistema</a>
        <p class="dni">Ingrese su CI y presione ENTER para Registrar</p>
        <form action="" method="POST">
            <input type="number" placeholder="CI del Empleado" name="txtdni" id="txtdni">
            <div  class="botones">
                <button  hidden id="registro" class="entrada"type="submit" name="btnregistro" value="ok">MARCAR</button>
                <!-- <button  id="salida" class="salida"type="submit" name="btnsalida" value="ok">Salida</button>
                <button  id="entrada" class="entrada"type="submit" name="btnentrada" value="ok">Entrada</button> -->
            </div>
        </form>
    </div>

        <!--Muestra en pantalla la fecha y hora actual del sistema -->
    <script>      
        setInterval(() => {
            let fecha=new Date();
            let fechaHora=fecha.toLocaleString();
            document.getElementById("fecha").textContent=fechaHora;
        }, 5);    
    </script>

        <!-- metodo para validar que solo se introduzca numeros de 8 digitos de largo -->
        <script>
            let dni=document.getElementById("txtdni");
            dni.addEventListener("input",function(){
                if (this.value.length > 9) {
                    this.value=this.value.slice(0,9);
                }
            })


            //evento para entrada y salida
            /*document.addEventListener("keyup",function(){
                if (event.code=="ArrowLeft") {
                    document.getElementById("salida").click()
                } else {
                    if(event.code=="ArrowRight"){
                        document.getElementById("entrada").click()
                    }
                }
            })*/
        </script>

</body>
</html>