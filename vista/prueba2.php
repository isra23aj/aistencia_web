<?php
date_default_timezone_set("America/La_Paz");
include "../modelo/conexion.php";

$saludo="hola mundo";
$hora = date("G");
$minutos = date("i");

//echo ("$hora:$minutos");

$ent_am = $conexion->query(" select hora_entrada_am FROM cargo where id_cargo=1"); 
$entradaAM = $ent_am->fetch_object()->hora_entrada_am;

$sal_am = $conexion->query(" select hora_salida_am FROM cargo where id_cargo=1"); 
$salidaAM = $sal_am->fetch_object()->hora_salida_am;

//$ent_pm = $conexion->query(" select hora_entrada_pm FROM cargo where id_cargo=1"); 
//$entradaPM = $ent_pm->fetch_object()->hora_entrada_pm;
$ent_pm = $conexion->query(" select cargo.hora_entrada_pm FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=12"); 
$entradaPM = $ent_pm->fetch_object()->hora_entrada_pm;

$consultaEntradaPM = $conexion->query(" select entrada_pm from asistencia where id_empleado=12 order by id_asistencia desc limit 1 ");
$consultaEntPM = $consultaEntradaPM->fetch_object()->entrada_pm;


$sal_pm = $conexion->query(" select hora_salida_pm FROM cargo where id_cargo=1"); 
$salidaPM = $sal_pm->fetch_object()->hora_salida_pm;

//$hab_am = $conexion->query(" select habilitar_am FROM cargo where id_cargo=1"); 
//$habilitarAM = $hab_am->fetch_object()->habilitar_am;
$hab_am = $conexion->query(" select cargo.habilitar_am FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado= 12"); 
$habilitarAM = $hab_am->fetch_object()->habilitar_am;             


$hab_pm = $conexion->query(" select habilitar_pm FROM cargo where id_cargo=1"); 
$habilitarPM = $hab_pm->fetch_object()->habilitar_pm;

//$lim_am = $conexion->query(" select limite_salam FROM cargo where id_cargo=1"); 
//$limAM = $lim_am->fetch_object()->limite_salam;
$lim_am = $conexion->query(" select cargo.limite_salam FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado= 12"); 
$limAM = $lim_am->fetch_object()->limite_salam;

$lim_pm = $conexion->query(" select limite_salpm FROM cargo where id_cargo=1"); 
$limPM = $lim_pm->fetch_object()->limite_salpm;

$tole = $conexion->query(" select tolerancia FROM cargo where id_cargo=1"); 
$tolerancia = $tole->fetch_object()->tolerancia;
$toleranciaPM=date($tolerancia);
//$toleranciaPM= $entradaPM + $toleranciaPM;

$consultaFecha = $conexion->query(" select entrada from asistencia where id_empleado=12 order by id_asistencia desc limit 1 ");
$fechaBD = $consultaFecha->fetch_object()->entrada;

$marca=date("H:i");
$fecha=date("Y-m-d H:i:s");

echo("Entrada AM: $entradaAM");
echo "<br>";
echo("Salida AM: $salidaAM");
echo "<br>";
echo("Habilitar AM: $habilitarAM");
echo "<br>";
echo "<br>";
echo("Entrada PM: $entradaPM");
echo "<br>";
echo("Salida PM: $salidaPM");
echo "<br>";
echo("Habilitar PM: $habilitarPM");
echo "<br>";
echo "<br>";
echo("Hora Actual: $marca");
echo "<br>";
echo("Min Tolerancia: $tolerancia");
echo "<br>";
//$entAM = date("H:i", "08:00");
//$tole = date("H:i",$entAM+$tolerancia);
//echo "<br>";
//echo("Hora Tolerancia: $tole");

/*$seg_horaPM=strtotime($entradaPM);
$seg_minAnadir=$tolerancia*60;
$horaTolPM=date("H:i",$seg_horaPM+$seg_minAnadir);
echo("Hora Tolerancia PM: $horaTolPM");
echo "<br>";
echo("Tolerancia: $tolerancia");
echo "<br>";
if ($marca <= $horaTolPM) {
    if ($consultaEntPM == null) //VERIFICA SI LA ENTRADA ESTA CON DATOS, SI NO ES ASI ACTUALIZA LA TABLA CON LA HORA
{
    echo("holi, la ultima entrada esta vacia");
}

}
*/


/*if ($marca >= $limAM) {
    echo("Turno de la TARDE!!");
    if ($marca>= $habilitarPM and $marca<=$limPM) {
        echo "<br>";
        echo("Continua!!!");
    } else {
        echo "<br>";
        echo("HabilitarPM");
        echo "<br>";
        echo("El sistema no se encuentra habilitado...");
        echo "<br>";
        echo("El sistema no se encuentra habilitado...");
    }
}
else{
    echo("Turno de la MAÑANA!!");
    
    if ($marca>= $habilitarPM and $marca<=$limPM) {
        echo "<br>";
        echo("Continua!!!");
    } else {
        echo "<br>";
        echo("El sistema no se encuentra habilitado...");
    }
    
}*/




/* ADICIONA MINUTOS A UNA HORA DETERMINADA
$horaInicial="08:50";
$minutoAnadir=$tolerancia;
$segundos_horaInicial=strtotime($entradaAM);
$segundos_minutoAnadir=$tolerancia*60;
echo "<br>".$segundos_minutoAnadir;
$nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
echo "<br>".$nuevaHora;*/





           
                
                
                        


?>





<?php
if (!empty($_POST["btnmarcar"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query(" select count(*) as 'total' from empleado where dni='$dni' ");
        $id = $conexion->query(" select id_empleado from empleado where dni='$dni' ");
        $id_empleado = $id->fetch_object()->id_empleado;

        $lim_am = $conexion->query(" select cargo.limite_salam FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
        $limiteampm = $lim_am->fetch_object()->limite_salam;
        
        $hora=date("H:i");

        if($hora <= $limiteampm){
            echo ("bienvenido al turno de la MAÑANA");
        }
        else {
            echo ("bienvenido al turno de la TARDE");
        }


    } else { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Error",
            type: "error",
            text: "Ingrese su Código de Ingreso",
            styling: "bootstrap3"
        })
    })
</script>
<?php } ?>

<script>
    //Esto es para que ya no mande alerta de volver a ingresar (duplicado) cuando se recarga la pagina
    setTimeout(() => {
        window.history.replaceState(null, null, window.location.pathname);
    }, 0);
</script>

<?php }
?>






































<?php
//'$cargo'

//VALIDAR QUE EL SISTEMA ESTA HABILITADO
    /*$cargo = $conexion->query(" select cargo.nombre FROM empleado INNER JOIN cargo ON empleado.cargo = cargo.id_cargo where dni=7528085"); 
    $nombreCargo = $cargo->fetch_object()->nombre;
    $hora = $conexion->query(" select min_habilitado from cargo where nombre='$nombreCargo' ");
    $horaHabilitado = $hora->fetch_object()->min_habilitado;
    $entrada= date("G:i");
    echo ("hora actual es: $entrada");

    echo "<br>";
    echo "<br>";
    echo("La hora habilitada para el sistema es: $horaHabilitado");
    
    if ($entrada > $horaHabilitado) {
        echo "<br>";
        echo "<br>";
        echo "Bienvenido";
    } else {
        echo "<br>";
        echo "<br>";
        echo "El Sistema aún no esta habilitado";
    }*/



   /* $tolerancia = $conexion->query(" select cargo.tolerancia FROM empleado INNER JOIN cargo ON empleado.cargo = cargo.id_cargo where dni=7528085 ");
    $minTolerancia = $tolerancia ->fetch_object()->tolerancia;
    $entradaAm = $conexion->query(" select hora_entrada_am from cargo where nombre='cirujano' ");
    $horaEntrada = $entradaAm ->fetch_object()->hora_entrada_am;
    $entrada=date("G:i");
    $minutos= date("i");

    echo "<br>";
    echo "<br>";
    echo("Usted esta entrando a horas: $entrada");echo "<br>";
    echo("Los minutos de tolerancia de su cargo es: $minTolerancia minutos");echo "<br>";
    echo("La hora de entrada de su cargo es: $horaEntrada");

    $tole= "$horaEntrada".":"."$minTolerancia"; echo "<br>";
    //echo ("$tole");
    
    if ($minutos > $minTolerancia)
    $difHora=$minutos - $minTolerancia;
    //echo ("Diferencia de minutos es:$difHora");
 

    
    if ($entrada <= $tole) {
        echo "<br>";
        echo "<br>";
        echo "Bienvenido";
    } else {
        if ($difHora <= 1) {
            echo "<br>";
            echo "<br>";
            echo "Usted llegó $difHora minuto tarde. Bienvenido ";
        } else {
            echo "<br>";
            echo "<br>";
            echo "Usted llegó $difHora minutos tarde. Bienvenido ";
        }
        }*/

    /*$tolerancia = $conexion->query(" select tolerancia from cargo where nombre='cirujano' ");
    $minTolerancia = $tolerancia ->fetch_object()->tolerancia;
    $entradaAm = $conexion->query(" select hora_entrada_am from cargo where nombre='cirujano' ");
    $horaEntrada = $entradaAm ->fetch_object()->hora_entrada_am;

    $entrada= "8:17";
    echo "<br>";
    echo "<br>";
    echo("Usted esta entrando a horas: $entrada");echo "<br>";
    echo("Los minutos de tolerancia de su cargo es: $minTolerancia");echo "<br>";
    echo("La hora de entrada de su cargo es: $horaEntrada");

    $tole= "$horaEntrada".":"."$minTolerancia"; echo "<br>";
    //echo ("$tole");
    
    if (17 > $minTolerancia)
    $difHora=17 - $minTolerancia;
    //echo ("Diferencia de minutos es:$difHora");
 

    
    if ($entrada <= $tole) {
        echo "<br>";
        echo "<br>";
        echo "Bienvenido";
    } else {
        if ($difHora <= 1) {
            echo "<br>";
            echo "<br>";
            echo "Usted llegó $difHora minuto tarde. Bienvenido ";
        } else {
            echo "<br>";
            echo "<br>";
            echo "Usted llegó $difHora minutos tarde. Bienvenido ";
        }
        

    }
    
    */








    /*$cargo = $conexion->query(" select cargo.nombre FROM empleado INNER JOIN cargo ON empleado.cargo = cargo.id_cargo where dni=7528085"); 
    $nombreCargo = $cargo->fetch_object()->nombre;
   
    $horas = $conexion->query(" select tolerancia from cargo where nombre='$nombreCargo' ");
    $tolerancia = $horas->fetch_object()->tolerancia;
   
    $entradaAM = $conexion->query(" select cargo.hora_entrada_am FROM empleado INNER JOIN cargo ON empleado.cargo = cargo.id_cargo where dni=7528085");
    $horaEntradaAM = $entradaAM->fetch_object()->hora_entrada_am;

    $entrada=date("G");


    $horaTol= $horaEntradaAM;
    //$horaEntradaAM="7:10";
    //  echo ($horaEntradaAM);
    //if($horaEntradaAM<"10:00")

    //echo "<br>";
    //echo "<br>";
    //$a="hola";
    $b="0".$horaEntradaAM;
    //echo($b);
    echo "<br>";
    echo "<br>";
    
    if($horaEntradaAM>="10:00"){
        //echo("$b");
        echo "<br>";
        echo("despues de las 10");
        $hor=intval(substr($horaEntradaAM,0,2));
        $min=intval(substr($horaEntradaAM,3,4));
        //if ($b < "10:00") 
    } else {
        echo("$b");   
        echo "<br>";
        echo("hola");   
        echo "<br>";
        echo("antes de las 10");
        $hor=intval(substr($horaEntradaAM,0,2));
        $min=intval(substr($horaEntradaAM,3,4));
    } */

    // if ($b<="10:00"){       
    //     //$b="0".$horaEntradaAM;
    //     //echo($b);
    //     $hor=intval(substr($b,0,2));
    //     $min=intval(substr($b,3,4));
    //     echo("antes de las 10");}


    // if ($horaEntradaAM < "10:00") {
    //     echo ("antes de las 10");
    // } else {
    //     echo ("despues de las 10");
    // }
    
    

    //$horaTol->modify('+1 hours');
    //echo gettype($hor);
    //echo "<br>";
    //echo "<br>";
   // echo("Hora Tol: $hor".":"."$min");
    //echo "<br>";
    //echo "<br>";
    //$horatole=time();
    //echo "<br>";
 //   $suma=$min+$tolerancia;
    //echo ("$suma");
    //echo "<br>";
    //echo "<br>";
    //echo ("Hora tole $horatole");
    
    
    // $mifecha = new DateTime(); 
    // $mifecha->modify('+1 hours'); 
    // $mifecha->modify('+0 minute '); 
    // $mifecha->modify('+0 second'); 
    // echo $mifecha->format('d-m-Y H:i:s');
    
 /*   echo "<br>";
    echo "<br>";
    echo("La hora entrada del cargo $nombreCargo es: $horaEntradaAM");
    echo "<br>";
    echo "<br>";
    echo("La tolerancia del cargo $nombreCargo es: $tolerancia minutos");
    echo "<br>";
    echo "<br>";
    echo("La tolerancia del cargo $nombreCargo es hasta horas:".$hor.":".$suma);
    //echo("La horaTOL es: $horaTol2");

    
    if ($entrada <= $horaTol) {
        echo "<br>";
        echo "<br>";
        echo "MARCASTE EN HORA";
    } else {
        echo "<br>";
        echo "<br>";
        echo "MARCASTE FUERA DE HORARIO";
    }

*/


/*
$consultaSalida = $conexion->query(" select cargo.hora_salida_am from empleado inner join cargo on empleado.cargo = cargo.id_cargo where dni= 7528085");
                    $horaSalida = $consultaSalida->fetch_object()->hora_salida_am;
                    $marcarS=date("H:i");

echo ("Hora Marcado: $marcarS");
echo "<br>";
echo "<br>";
echo ("Hora Salida: $horaSalida");

if ($marcarS>=$horaSalida) {
    echo "<br>";
    echo "<br>";
    echo ("Hasta luego");
} else {
    echo "<br>";
    echo "<br>";
    echo ("Aún no puede marcar su salida");
}*/



?>





