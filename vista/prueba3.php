<?php
if (!empty($_POST["btnentrada"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query(" select count(*) as 'total' from empleado where dni='$dni' ");
        $id = $conexion->query(" select id_empleado from empleado where dni='$dni' ");
        $id_empleado = $id->fetch_object()->id_empleado;
        
        //verifica si el CI ingresado esta registrado
        if ($consulta->fetch_object()->total > 0) {
            $cargo = $conexion->query(" select cargo.nombre FROM empleado INNER JOIN cargo ON empleado.cargo = cargo.id_cargo where dni=$dni");
            $nombreCargo = $cargo->fetch_object()->nombre;
            $hora = $conexion->query(" select cargo.habilitar_am FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado  ");
            $horaHabilitado = $hora->fetch_object()->habilitar_am;
            $lim_am = $conexion->query(" select limite_salam from cargo where nombre='$nombreCargo' ");
            $limAM = $lim_am->fetch_object()->limite_salam;
            $consultaFecha = $conexion->query(" select entrada from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1 ");
            $fechaBD = $consultaFecha->fetch_object()->entrada;

            $entrada = date("H:i");
            $marca = date("H:i");
            $fecha = date("Y-m-d h:i:s");
            //verifica si marca en el turno de la mañana o de la tarde
            if ($marca >= $limAM) { 
                $hab_pm = $conexion->query(" select cargo.habilitar_pm FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                $habilitarPM = $hab_pm->fetch_object()->habilitar_pm;
                $lim_pm = $conexion->query(" select cargo.limite_salpm FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                $limPM = $lim_pm->fetch_object()->limite_salpm;
                
                
                //verifica si se esta marcando despues de la hora habilitada y antes de la hora limite de salida
                if($marca>= $habilitarPM and $marca<=$limPM){
                    $ent_pm = $conexion->query(" select cargo.hora_entrada_pm FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado");
                    $entradaPM = $ent_am->fetch_object()->hora_entrada_pm; 
                    $tole = $conexion->query(" select cargo.tolerancia FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado");
                    $tolerancia = $tole->fetch_object()->tolerancia;
                    $consultaEntradaPM = $conexion->query(" select entrada_pm from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1 ");
                    $consultaEntPM = $consultaEntradaPM->fetch_object()->entrada_pm;
                    
                    $seg_horaPM=strtotime($entradaPM);
                    $seg_minAnadir=$tolerancia*60;
                    $horaTolPM=date("H:i",$seg_horaPM+$seg_minAnadir);
                    
                    //SE VERIFICA SI MARCA  ANTES DE LA HORA DE TOLERANCIA
                    if ($marca <= $horaTolPM) {
                        if ($consultaEntPM == null) {//VERIFICA SI LA ENTRADA ESTA CON DATOS, SI NO ES ASI ACTUALIZA LA TABLA CON LA HORA?>
                            <script>
                                $(function notificacion() {
                                    new PNotify({
                                        title: "Error",
                                        type: "error",
                                        text: "Debe registrar su entrada",
                                        styling: "bootstrap3"
                                    })
                                })
                            </script>
                            <?php 
                        } else{
                            $sqlActPM = $conexion->query(" update asistencia set entrada_pm ='$fecha' where id_empleado=$id_empleado and entrada='$fechaBD' ");
                            if ($sqlACtPM == true) {?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Correcto",
                                                type: "alert",
                                                //text: "Bienvenido, MARCÓ FUERA DE HORARIO < ?="HoraTOL:".$horaTol."$.Entrada:".$entrada." $.Tolerancia:". $tolerancia." Hora EntradaAM:".$horaEntradaAM ?>",
                                                text: "Bienvenido a su Turno de la Tarde",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                            } else {
                                ?><script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "Incorrecto",
                                    type: "error",
                                    text: "Error al registrar su entrada",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                        <?php 
                            }
                            
                        }
                        
                    } else {
                        if ($entradaPM != null) {?>
                            <script>
                                $(function notificacion() {
                                    new PNotify({
                                        title: "Error",
                                        type: "error",
                                        text: "Ya se Registró su Entrada de la Tarde",
                                        styling: "bootstrap3"
                                    })
                                })
                            </script>
                            <?php 
                        } else {
                            $sqlActPM = $conexion->query(" update asistencia set entrada_pm ='$marca' where id_empleado=$id_empleado and entrada='$fechaBD' ");
                            if ($sqlACtPM == true) {?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Correcto",
                                                type: "alert",
                                                //text: "Bienvenido, MARCÓ FUERA DE HORARIO < ?="HoraTOL:".$horaTol."$.Entrada:".$entrada." $.Tolerancia:". $tolerancia." Hora EntradaAM:".$horaEntradaAM ?>",
                                                text: "Bienvenido a su Turno de la Tarde, marcó con retraso.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                            } else {
                                ?><script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "Incorrecto",
                                    type: "error",
                                    text: "Error al registrar su entrada.Turno TARDE",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                        <?php 
                            }
                            
                        }
                    }
                    
                } else{?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "Error",
                                type: "error",
                                text: "El sistema no se encuentra habilitado, no se registrará. TURNO TARDE <?=" Hora Marca:".$marca." HabPM:".$habilitarPM. " LimPM:".$limPM?>",
                                //text: "El sistema no se encuentra habilitado, no se registrará.",
                                styling: "bootstrap3"
                            })
                        })
                    </script>
                    <?php }
                                
            } 

            else { //DE AQUI PARA ADELANTE ES EJECUTAR SI INGRESA EN EL HORARIO DE LA MAÑANA...OJO SE ESTA HACIENDO ESTO
                $hab_am = $conexion->query(" select cargo.habilitar_am FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                $habilitarAM = $hab_am->fetch_object()->habilitar_am;
                $lim_am = $conexion->query(" select cargo.limite_salam FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                $limAM = $lim_am->fetch_object()->limite_salam;


                //CORREGIR DE AQUI PARA ADELANTE
                //CORREGIR DE AQUI PARA ADELANTE
                //CORREGIR DE AQUI PARA ADELANTE
                //CORREGIR DE AQUI PARA ADELANTE
                //CORREGIR DE AQUI PARA ADELANTE

                $ent_am = $conexion->query(" select cargo.hora_entrada_am FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado");
                $entradaAM = $ent_am->fetch_object()->hora_entrada_am; 
                if ($marca>= $habilitarAM and $marca<=$limAM) {
                    //$seg_horaAM=strtotime($entradaAM);
                    //$seg_minAnadir=$tolerancia*60;
                    //$horaTolAM=date("H:i",$seg_horaAM+$seg_minAnadir);
                    $tole = $conexion->query(" select cargo.tolerancia FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado");
                    $tolerancia = $tole->fetch_object()->tolerancia;
                    $seg_horaAM=strtotime($entradaAM);
                    $seg_minAnadir=$tolerancia*60;
                    $horaTolAM=date("H:i",$seg_horaAM+$seg_minAnadir);


                    $consultaFecha = $conexion->query(" select entrada from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1 ");
                    $fechaBD = $consultaFecha->fetch_object()->entrada;
                    
                    //SE VERIFICA SI MARCA  ANTES DE LA HORA DE TOLERANCIA
                    if ($marca <= $horaTolAM) {
                        if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) {//VERIFICA SI LA ENTRADA ESTA CON DATOS, SI NO ES ASI ACTUALIZA LA TABLA CON LA HORA?>
                            <script>
                                $(function notificacion() {
                                    new PNotify({
                                        title: "Error",
                                        type: "error",
                                        text: "Ya se Registró su Entrada de la Mañana",
                                        styling: "bootstrap3"
                                    })
                                })
                            </script>
                            <?php 
                        } else {
                            $sqlActAM = $conexion->query(" insert into asistencia (id_empleado,entrada) values ($id_empleado,'$fecha')");
                            //$sqlActAM = $conexion->query(" select * from asistencia");
                            if ($sqlActAM == true) { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Correcto",
                                            type: "success",
                                            //text: "Bienvenido al turno de la MAÑANA < ?="HoraTOL:".$horaTolAM." Tolerancia:".$tolerancia." Hora am:".$seg_horaAM." EntradaAM:".$entradaAM?>",
                                            text: "Bienvenido al turno de la MAÑANA",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php
                                                } else { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Incorrecto",
                                            type: "error",
                                            text: "Error al registrar su entrada",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php }
                        }
                        
                    } else {
                        if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) {?>
                            <script>
                                $(function notificacion() {
                                    new PNotify({
                                        title: "Error",
                                        type: "error",
                                        text: "Ya se Registró su Entrada de la Mañana.",
                                        styling: "bootstrap3"
                                    })
                                })
                            </script>
                            <?php 
                        } else {
                            $sqlActAM = $conexion->query(" insert into asistencia (id_empleado,entrada) values ($id_empleado,'$fecha')");
                            //$sqlActAM = $conexion->query(" select * from asistencia");
                            if ($sqlActAM == true) { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Correcto",
                                            type: "alert",
                                            //text: "Bienvenido, MARCÓ FUERA DE HORARIO < ?="HoraTOL:".$horaTol."$.Entrada:".$entrada." $.Tolerancia:". $tolerancia." Hora EntradaAM:".$horaEntradaAM ?>",
                                            text: "Bienvenido, MARCÓ FUERA DE HORARIO",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php
                                                } else { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Incorrecto",
                                            type: "error",
                                            text: "Error al registrar su entrada",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php }
                            
                        }
                    }
                    
                } else {
                    ?>
                    <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "Error",
                                type: "error",
                                text: "El sistema no se encuentra habilitado, no se registrará. TURNO MAÑANA",
                                styling: "bootstrap3"
                            })
                        })
                    </script>
                    <?php 
                }
                
            }
        } else { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Incorrecto",
            type: "error",
            text: "El CI no existe",
            styling: "bootstrap3"
        })
    })
</script>
<?php }

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












<!-- //////////////REGISTRO DE SALIDA///////////////////// -->


<?php

if (!empty($_POST["btnsalida"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query(" select count(*) as 'total' from empleado where dni='$dni' ");
        $id = $conexion->query(" select id_empleado from empleado where dni='$dni' ");
        //Verifica si existe el CI del empleado
        if ($consulta->fetch_object()->total > 0) {

            $fecha = date("Y-m-d h:i:s");
            $id_empleado = $id->fetch_object()->id_empleado;
            $busqueda = $conexion->query(" select id_asistencia,entrada from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1");


            while ($datos = $busqueda->fetch_object()) {
                $id_asistencia = $datos->id_asistencia;
                $entradaBD = $datos->entrada;
            }
            //Verifica si existe entrada para introducir salida
            if (substr($fecha, 0, 10) != substr($entradaBD, 0, 10)) { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Incorrecto",
            type: "error",
            text: "Primero debe registrar su entrada",
            styling: "bootstrap3"
        })
    })
</script>
<?php
            } else {
                $consultaFecha = $conexion->query(" select salida from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1 ");
                $fechaBD = $consultaFecha->fetch_object()->salida;
                //verifica si ya registro la salida
                if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Incorrecto",
            type: "error",
            text: "Ya se registro su salida de la mañana",
            styling: "bootstrap3"
        })
    })
</script>
<?php
                } else {

                    $consultaSalida = $conexion->query(" select cargo.hora_salida_am from empleado inner join cargo on empleado.cargo = cargo.id_cargo where dni= $dni");
                    $horaSalida = $consultaSalida->fetch_object()->hora_salida_am;
                    $marcarS=date("H:i");

                    if ($marcarS>=$horaSalida) {
                        $sql = $conexion->query(" update asistencia set salida='$fecha' where id_asistencia=$id_asistencia");
                        //$sql = $conexion->query(" select * from empleado");
                    if ($sql == true) { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Correcto",
            type: "success",
            text: "Hasta luego",
            styling: "bootstrap3"
        })
    })
</script>
<?php } else { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Incorrecto",
            type: "error",
            text: "Error al registrar su salida",
            styling: "bootstrap3"
        })
    })
</script>
<?php }
                    } else {
                        ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Incorrecto",
            type: "error",
            text: "Aún no es hora de su salida",
            styling: "bootstrap3"
        })
    })
</script>
<?php 
                    }
                    


                }

            }


        } else { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Incorrecto",
            type: "error",
            text: "El CI no existe",
            styling: "bootstrap3"
        })
    })
</script>
<?php }

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