<?php
if (!empty($_POST["btnregistro"])) {
    if (!empty($_POST["txtdni"])) {
        $dni = $_POST["txtdni"];
        $consulta = $conexion->query(" select count(*) as 'total' from empleado where dni='$dni' ");
        $id = $conexion->query(" select id_empleado from empleado where dni='$dni' ");
        $id_empleado = $id->fetch_object()->id_empleado;
        //$id_empleado = 12;
        
        $variable = false;

        for ($i = 1; $i <= 5; $i++) {
        if ($variable) {
            break;  // si la variable se ha convertido en true, salimos del ciclo
        }
        if ($i == 1) {
        //verifica si el CI ingresado esta registrado
        
        if ($consulta->fetch_object()->total > 0) {
            $conti = $conexion->query(" SELECT area.continuo FROM empleado INNER JOIN area ON empleado.area = area.id_area where id_empleado=$id_empleado"); 
            $continuo = $conti->fetch_object()->continuo;
            
            $areaa = $conexion->query(" SELECT empleado.area FROM empleado where id_empleado=$id_empleado"); 
            $area = $areaa->fetch_object()->area;
            //echo "<br>";
            //echo ("Horario Continuo? $continuo");
            
            
            //$carg = $conexion->query(" SELECT cargo.nombre FROM empleado INNER JOIN cargo ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
            //$cargo = $carg->fetch_object()->nombre;
            // echo("Hola");
            // echo "<br>";
            // echo("ID: $id_empleado");
            // echo "<br>";
            // echo("Continuo: $continuo");
            
            if ($continuo=="si") { 

                if ($area!=3) {

                    $fecha = date("Y-m-d H:i:s");
                    $marca= date("H:i");

                    $consultaFecha = $conexion->query(" select entrada from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1 ");
                    $fechaBD = $consultaFecha->fetch_object()->entrada;
        
                    $hab = $conexion->query(" SELECT habilitar  FROM continuo_adm INNER JOIN area ON continuo_adm.area = area.id_area INNER JOIN empleado ON empleado.area = area.id_area where id_empleado=$id_empleado "); 
                    $habilitar = $hab->fetch_object()->habilitar;
                    
                    $lim = $conexion->query(" SELECT limite  FROM continuo_adm INNER JOIN area ON continuo_adm.area = area.id_area INNER JOIN empleado ON empleado.area = area.id_area where id_empleado=$id_empleado "); 
                    $limite = $hab->fetch_object()->limite;
                    
                    $ent = $conexion->query(" SELECT entrada  FROM continuo_adm INNER JOIN area ON continuo_adm.area = area.id_area INNER JOIN empleado ON empleado.area = area.id_area where id_empleado=$id_empleado "); 
                    $entrada = $hab->fetch_object()->entrada;
                    
                    $sal = $conexion->query(" SELECT salida  FROM continuo_adm INNER JOIN area ON continuo_adm.area = area.id_area INNER JOIN empleado ON empleado.area = area.id_area where id_empleado=$id_empleado "); 
                    $salida = $sal->fetch_object()->salida;

                    //echo("Habilitar: $habilitar");
                            //echo("Marca: $marca");
                            //echo("Salida: $salida");
                    if ($marca >= $habilitar and $marca<=$salida) {//verifica si el sistema esta habilitado
                        //if ($marca>= $habilitar) {//verifica si el sistema esta habilitado
                            //echo("Habilitar: $habilitar");
                            //echo("Marca: $marca");
                            //echo("Salida: $salida");
                            
                            $tole = $conexion->query(" SELECT tolerancia FROM continuo_adm INNER JOIN area ON continuo_adm.area = area.id_area INNER JOIN empleado ON empleado.area = area.id_area WHERE id_empleado=$id_empleado "); 
                            $tolerancia = $tole->fetch_object()->tolerancia;
                            $seg_hora=strtotime($entrada);
                            $seg_minAnadir=$tolerancia*60;
                            $horaTol=date("H:i",$seg_hora+$seg_minAnadir);
                            
                            //echo("Tolerancia: $tolerancia");
                            //echo("Hora Tol: $horaTol");


                            //$consultaFecha = $conexion->query(" select entrada from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1 ");
                            //$fechaBD = $consultaFecha->fetch_object()->entrada;
                            
        

                            //SE VERIFICA SI MARCA  ANTES DE LA HORA DE TOLERANCIA
                            if ($marca <= $horaTol) {
                                if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) {
                                    //VERIFICA SI LA ENTRADA ESTA CON DATOS, SI NO ES ASI ACTUALIZA LA TABLA CON LA HORA?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Ya registró su Entrada",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php 
                                } else {
                                    //insertarsql
                                    $sqlAct = $conexion->query(" insert into asistencia_continuo (id_empleado,entrada) values ($id_empleado,'$fecha')");
                                    //$sqlAct = $conexion->query(" select * from asistencia_continuo");
                                    if ($sqlAct == true) { $variable = true;?>
                                        <script>
                                            $(function notificacion() {
                                                new PNotify({
                                                    title: "Correcto",
                                                    type: "success",
                                                    //text: "Bienvenido al turno de la MAÑANA < ?="HoraTOL:".$horaTol." Tolerancia:".$tolerancia." Hora am:".$seg_hora." Entrada:".$entrada?>",
                                                    text: "Bienvenido",
                                                    styling: "bootstrap3"
                                                })
                                            })
                                        </script>
                                        <?php
                                                        } else { ?>
                                        <script>
                                            $(function notificacion() {
                                                new PNotify({
                                                    title: "Error",
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
                                                text: "Ya Registró su entrada o aún no puede marcar salida.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php 
                                } else {
                                    //insertarsql
                                    $sqlAct = $conexion->query(" insert into asistencia_continuo (id_empleado,entrada) values ($id_empleado,'$fecha')");
                                    //$sqlAct = $conexion->query(" select * from asistencia_continuo");
                                    if ($sqlAct == true) { $variable = true;?>
                                        <script>
                                            $(function notificacion() {
                                                new PNotify({
                                                    title: "Correcto",
                                                    type: "alert",
                                                    //text: "Bienvenido, MARCÓ FUERA DE HORARIO < ?="Hora TOL:".$horaTol." $.Tolerancia:". $tolerancia ?>",
                                                    text: "Bienvenido, marcó fuera de hora.",
                                                    styling: "bootstrap3"
                                                })
                                            })
                                        </script>
                                        <?php
                                                        } else { ?>
                                        <script>
                                            $(function notificacion() {
                                                new PNotify({
                                                    title: "Error",
                                                    type: "error",
                                                    text: "Error al registrar su entrada",
                                                    styling: "bootstrap3"
                                                })
                                            })
                                        </script>
                                        <?php }
                                    
                                }
                            }
                            
                        } 
                        
                        else {
                            ?>
                            <script>
                                $(function notificacion() {
                                    new PNotify({
                                        title: "Error",
                                        type: "error",
                                        text: "El sistema no se encuentra habilitado.",
                                        styling: "bootstrap3"
                                    })
                                })
                            </script>
                            <?php 
                        }                
                
                } 
                






                
                else {
                                                    //echo("Hola2");
                
                $fecha = date("Y-m-d H:i:s");
                $marca= date("H:i");
                
                $consultaFecha = $conexion->query(" select entrada from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1 ");
                $fechaBD = $consultaFecha->fetch_object()->entrada;
    
                //$hab = $conexion->query(" select habilitar from parametroc"); 
                $hab = $conexion->query(" SELECT parametroc.habilitar FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado WHERE id_empleado=$id_empleado "); 
                $habilitar = $hab->fetch_object()->habilitar;
                //$lim = $conexion->query(" select limite from parametroc"); 
                $lim = $conexion->query(" SELECT parametroc.limite FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado WHERE id_empleado=$id_empleado "); 
                $limite = $lim->fetch_object()->limite;
                //$ent = $conexion->query(" select entrada from parametroc");
                $ent = $conexion->query(" SELECT parametroc.entrada FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado WHERE id_empleado=$id_empleado "); 
                $entrada = $ent->fetch_object()->entrada;

                $sali = $conexion->query(" SELECT parametroc.salida FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado WHERE id_empleado=$id_empleado "); 
                $salida = $sali->fetch_object()->salida; 
                

                // echo "<br>";
                // echo("Marca: $marca");
                // echo "<br>";
                // echo("Entrada: $entrada");
                // echo "<br>";
                // echo("Habilitar: $habilitar");
                // echo "<br>";
                // echo("Salida: $salida");

                $consultaNombre = $conexion->query("SELECT parametroc.nombre FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado where id_empleado=$id_empleado");
                $consul = $consultaNombre->fetch_object()->nombre; 
                
                $consultaTN = $conexion->query("SELECT nombre FROM parametroc 
                WHERE nombre LIKE '%pm_am' or nombre LIKE 'pm_am%' or nombre LIKE '%pm_am%'or 
                nombre LIKE '%pm am' or nombre LIKE 'pm am%' or nombre LIKE '%pm am%' or
                nombre LIKE '%pm-am' or nombre LIKE 'pm-am%' or nombre LIKE '%pm-am%' OR
                nombre LIKE '%noche' or nombre LIKE 'noche%' or nombre LIKE '%noche%' or
                nombre LIKE '%nocturno' or nombre LIKE 'nocturno%' or nombre LIKE '%nocturno%'");
                $consulTN = $consultaTN->fetch_object()->nombre;
                




                //CONSULTA SI EL TURNO DEL TRABAJADOR ES TURNO NOCTURNO
                if($consul==$consulTN){
                    //EN ESTE IF SOLO SE EJECUTA PARA LOS TURNOS QUE SEAN NOCTURNOS
                    if ($marca >= $habilitar or $marca<=$salida) {
                        $tole = $conexion->query(" SELECT parametroc.tolerancia FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado WHERE id_empleado=$id_empleado "); 
                        $tolerancia = $tole->fetch_object()->tolerancia;
                        $sal = $conexion->query(" SELECT parametroc.salida FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado WHERE id_empleado=$id_empleado "); 
                        $salida = $sal->fetch_object()->salida;
                        $seg_hora=strtotime($entrada);
                        
                        $seg_minAnadir=$tolerancia*60;
                        $horaTol=date("H:i",$seg_hora+$seg_minAnadir);
    
                        $consultaFecha = $conexion->query(" select entrada from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1 ");
                        $fechaBD = $consultaFecha->fetch_object()->entrada;
                        
                        //SE VERIFICA SI MARCA  ANTES DE LA HORA DE TOLERANCIA
                        if ($marca <= $horaTol) {
                            //VERIFICA SI LA ENTRADA ESTA CON DATOS, SI NO ES ASI ACTUALIZA LA TABLA CON LA HORA
                            if (substr($fechaBD, 0, 10) != substr($fecha, 0, 10) and $marca >= $salida ) {
                                //echo("Marca: $marca");
                                //echo("HoraTol: $horaTol");
                                //insertarsql
                                $sqlAct = $conexion->query(" insert into asistencia_continuo (id_empleado,entrada) values ($id_empleado,'$fecha')");
                                //$sqlAct = $conexion->query(" select * from asistencia_continuo");
                                if ($sqlAct == true) { $variable = true;?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Correcto",
                                                type: "success",
                                                //text: "Bienvenido al turno de la MAÑANA < ?="HoraTOL:".$horaTol." Tolerancia:".$tolerancia." Hora am:".$seg_hora." Entrada:".$entrada?>",
                                                text: "Bienvenido",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                                                    } else { ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Error al registrar su entrada",
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
                                            title: "Error",
                                            type: "error",
                                            text: "Ya Registró su Entrada",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php 
                            }
                            
                        } else {
                            //VERIFICA SI LA ENTRADA ESTA CON DATOS, SI NO ES ASI ACTUALIZA LA TABLA CON LA HORA
                            if (substr($fechaBD, 0, 10) != substr($fecha, 0, 10) and $marca >= $salida ) {
                                // echo("Marca: $marca");
                                // echo("HoraTol: $horaTol");
                                // echo("RETRASO");
                                //insertarsql
                                $sqlAct = $conexion->query(" insert into asistencia_continuo (id_empleado,entrada) values ($id_empleado,'$fecha')");
                                //$sqlAct = $conexion->query(" select * from asistencia_continuo");
                                if ($sqlAct == true) { $variable = true;?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Correcto",
                                                type: "alert",
                                                //text: "Bienvenido al turno de la MAÑANA < ?="HoraTOL:".$horaTol." Tolerancia:".$tolerancia." Hora am:".$seg_hora." Entrada:".$entrada?>",
                                                text: "Bienvenido, marcó fuera de hora.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                                                    } else { ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Error al registrar su entrada",
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
                                            title: "Error",
                                            type: "error",
                                            text: "Ya Registró su Entrada",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php 
                            }
                        
                        }

                        
                        } else {
                            ?>
                            <script>
                                $(function notificacion() {
                                    new PNotify({
                                        title: "Error",
                                        type: "error",
                                        text: "El sistema no se encuentra habilitado.",
                                        styling: "bootstrap3"
                                    })
                                })
                            </script>
                            <?php 
                        }

                }
                else{
                    //EN ESTE IF SOLO SE EJECUTA PARA LOS TURNOS QUE SEAN MAÑANA O TARDE
                    if ($marca>= $habilitar and $marca<=$salida) {//verifica si el sistema esta habilitado
                        //if ($marca>= $habilitar) {//verifica si el sistema esta habilitado
                            $tole = $conexion->query(" SELECT parametroc.tolerancia FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado WHERE id_empleado=$id_empleado "); 
                            $tolerancia = $tole->fetch_object()->tolerancia;
                            $seg_hora=strtotime($entrada);
                            $seg_minAnadir=$tolerancia*60;
                            $horaTol=date("H:i",$seg_hora+$seg_minAnadir);
        
                            $consultaFecha = $conexion->query(" select entrada from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1 ");
                            $fechaBD = $consultaFecha->fetch_object()->entrada;
                            
                            //SE VERIFICA SI MARCA  ANTES DE LA HORA DE TOLERANCIA
                            if ($marca <= $horaTol) {
                                if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) {
                                    //VERIFICA SI LA ENTRADA ESTA CON DATOS, SI NO ES ASI ACTUALIZA LA TABLA CON LA HORA?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Ya Registró su Entrada",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php 
                                } else {
                                    //insertarsql
                                    $sqlAct = $conexion->query(" insert into asistencia_continuo (id_empleado,entrada) values ($id_empleado,'$fecha')");
                                    //$sqlAct = $conexion->query(" select * from asistencia_continuo");
                                    if ($sqlAct == true) { $variable = true;?>
                                        <script>
                                            $(function notificacion() {
                                                new PNotify({
                                                    title: "Correcto",
                                                    type: "success",
                                                    //text: "Bienvenido al turno de la MAÑANA < ?="HoraTOL:".$horaTol." Tolerancia:".$tolerancia." Hora am:".$seg_hora." Entrada:".$entrada?>",
                                                    text: "Bienvenido",
                                                    styling: "bootstrap3"
                                                })
                                            })
                                        </script>
                                        <?php
                                                        } else { ?>
                                        <script>
                                            $(function notificacion() {
                                                new PNotify({
                                                    title: "Error",
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
                                                text: "Ya registró su entrada o aún no puede marcar salida.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php 
                                } else {
                                    //insertarsql
                                    $sqlAct = $conexion->query(" insert into asistencia_continuo (id_empleado,entrada) values ($id_empleado,'$fecha')");
                                    //$sqlAct = $conexion->query(" select * from asistencia_continuo");
                                    if ($sqlAct == true) { $variable = true;?>
                                        <script>
                                            $(function notificacion() {
                                                new PNotify({
                                                    title: "Correcto",
                                                    type: "alert",
                                                    //text: "Bienvenido, MARCÓ FUERA DE HORARIO < ?="Hora TOL:".$horaTol." $.Tolerancia:". $tolerancia ?>",
                                                    text: "Bienvenido, marcó fuera de hora",
                                                    styling: "bootstrap3"
                                                })
                                            })
                                        </script>
                                        <?php
                                                        } else { ?>
                                        <script>
                                            $(function notificacion() {
                                                new PNotify({
                                                    title: "Error",
                                                    type: "error",
                                                    text: "Error al registrar su entrada",
                                                    styling: "bootstrap3"
                                                })
                                            })
                                        </script>
                                        <?php }
                                    
                                }
                            }
                            
                        } 
                        
                        else {
                            ?>
                            <script>
                                $(function notificacion() {
                                    new PNotify({
                                        title: "Error",
                                        type: "error",
                                        text: "El sistema no se encuentra habilitado.",
                                        styling: "bootstrap3"
                                    })
                                })
                            </script>
                            <?php 
                        }
                    
                }
                }
                }
                else{
                $cargo = $conexion->query(" select cargo.nombre FROM empleado INNER JOIN cargo ON empleado.cargo = cargo.id_cargo where dni=$dni");
                $nombreCargo = $cargo->fetch_object()->nombre;
                $hora = $conexion->query(" select cargo FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado  ");
                $horaHabilitado = $hora->fetch_object()->habilitar_am;
                //echo("Holi");
                $lim_am = $conexion->query(" select limite_salam from cargo where nombre='$nombreCargo' ");
                $limAM = $lim_am->fetch_object()->limite_salam;
                $consultaFecha = $conexion->query(" select entrada from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1 ");
                $fechaBD = $consultaFecha->fetch_object()->entrada;

                $entrada = date("H:i");
                $marca = date("H:i");
                $fecha = date("Y-m-d H:i:s");
                //verifica si marca en el turno de la mañana o de la tarde
                if ($marca >= $limAM) { 
                                //////////DE AQUI PARA ADELANTE ES EJECUTAR SI INGRESA EN EL HORARIO DE LA TARDE...!!!//////////
                                //////////DE AQUI PARA ADELANTE ES EJECUTAR SI INGRESA EN EL HORARIO DE LA TARDE...!!!//////////
                                //////////DE AQUI PARA ADELANTE ES EJECUTAR SI INGRESA EN EL HORARIO DE LA TARDE...!!!//////////
                                
                    $hab_pm = $conexion->query(" select cargo.habilitar_pm FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                    $habilitarPM = $hab_pm->fetch_object()->habilitar_pm;
                    $lim_pm = $conexion->query(" select cargo.limite_salpm FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                    $limPM = $lim_pm->fetch_object()->limite_salpm;
                    
                    //verifica si se esta marcando despues de la hora habilitada y antes de la hora limite de salida
                    if($marca>= $habilitarPM and $marca<=$limPM){
                        
                        $ent_pm = $conexion->query(" select cargo.hora_entrada_pm FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                        $entradaPM = $ent_pm->fetch_object()->hora_entrada_pm;
                        $tole = $conexion->query(" select cargo.tolerancia FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                        $tolerancia = $tole->fetch_object()->tolerancia;
                        $consultaEntradaPM = $conexion->query(" select entrada_pm from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1 ");
                        $consultaEntPM = $consultaEntradaPM->fetch_object()->entrada_pm;
                        
                        $seg_horaPM=strtotime($entradaPM);
                        $seg_minAnadir=$tolerancia*60;
                        $horaTolPM=date("H:i",$seg_horaPM+$seg_minAnadir);
                        //SE VERIFICA SI MARCA  ANTES DE LA HORA DE TOLERANCIA
                        //echo("MARCA: $marca");
                        //echo("HORA TOL: $horaTolPM");
                        if ($marca <= $horaTolPM) {
                            //echo("ID Empleado: $id_empleado");
                            
                            if ($consultaEntPM != null) {//VERIFICA SI LA ENTRADA ESTA CON DATOS, SI NO ES ASI ACTUALIZA LA TABLA CON LA HORA?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Error",
                                            type: "error",
                                            text: "Ya registró su entrada de la TARDE.",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php 
                            } else{
                                //insertarsql
                                $sqlActPM = $conexion->query(" update asistencia set entrada_pm ='$fecha' where id_empleado=$id_empleado and entrada='$fechaBD' ");
                                //$sqlActAM = $conexion->query(" select * from asistencia");
                                if ($sqlActAM == true) {$variable = true; ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                //text: "Bienvenido al turno de la MAÑANA < ?="HoraTOL:".$horaTolAM." Tolerancia:".$tolerancia." Hora am:".$seg_horaAM." EntradaAM:".$entradaAM?>",
                                                text: "Error al registrar su entrada de la TARDE.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                                                    } else { ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Correcto",
                                                type: "success",
                                                text: "Bienvenido al turno de la TARDE",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php }                            
                            }
                            
                        } else {
                            if ($consultaEntPM != null) {//VERIFICA SI LA ENTRADA ESTA CON DATOS, SI NO ES ASI ACTUALIZA LA TABLA CON LA HORA?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Error",
                                            type: "error",
                                            text: "Ya registro su entrada de la TARDE",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php 
                            } else{
                                //insertarsql
                                $sqlActPM = $conexion->query(" update asistencia set entrada_pm ='$fecha' where id_empleado=$id_empleado and entrada='$fechaBD' ");
                                //$sqlActAM = $conexion->query(" select * from asistencia");
                                if ($sqlActAM == true) { $variable = true;?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Error al registrar su entrada",
                                                styling: "bootstrap3"
                                            })
                                        })
                                        </script>
                                    <?php
                                                    } else { ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Correcto",
                                                type: "alert",
                                                //text: "Bienvenido al turno de la TARDE < ?="HoraTOL:".$horaTolPM." Tolerancia:".$tolerancia." EntradaAM:".$entradaPM?>",
                                                text: "Bienvenido al turno de la TARDE, con retraso",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php }                            
                            }
                        }
                        
                    } else{?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "Error",
                                    type: "error",
                                    //text: "El sistema no se encuentra habilitado, no se registrará. TURNO TARDE < ?=" Hora Marca:".$marca." HabPM:".$habilitarPM. " LimPM:".$limPM?>",
                                    text: "El sistema no se encuentra habilitado.",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                        <?php }
                                    
                } 
            //}
                //////////DE AQUI PARA ADELANTE ES EJECUTAR SI INGRESA EN EL HORARIO DE LA MAÑANA...!!!//////////
                //////////DE AQUI PARA ADELANTE ES EJECUTAR SI INGRESA EN EL HORARIO DE LA MAÑANA...!!!//////////
                //////////DE AQUI PARA ADELANTE ES EJECUTAR SI INGRESA EN EL HORARIO DE LA MAÑANA...!!!//////////
                else { 
                    $hab_am = $conexion->query(" select cargo.habilitar_am FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                    $habilitarAM = $hab_am->fetch_object()->habilitar_am;
                    $lim_am = $conexion->query(" select cargo.limite_salam FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                    $limAM = $lim_am->fetch_object()->limite_salam;
                    $ent_am = $conexion->query(" select cargo.hora_entrada_am FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado");
                    $entradaAM = $ent_am->fetch_object()->hora_entrada_am; 
                    if ($marca >= $habilitarAM and $marca<=$limAM) {
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
                                            text: "Ya se registró su entrada de la MAÑANA",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php
                            } else {
                                //insertarsql
                                $sqlActAM = $conexion->query(" insert into asistencia (id_empleado,entrada) values ($id_empleado,'$fecha')");
                                //$sqlActAM = $conexion->query(" select * from asistencia");
                                if ($sqlActAM == true) { $variable = true;?>
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
                                                title: "Error",
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
                                            text: "Ya se registró su entrada de la MAÑANA.",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php
                            } else {
                                //insertarsql
                                $sqlActAM = $conexion->query(" insert into asistencia (id_empleado,entrada) values ($id_empleado,'$fecha')");
                                //$sqlActAM = $conexion->query(" select * from asistencia");
                                if ($sqlActAM == true) { $variable = true;?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Correcto",
                                                type: "alert",
                                                //text: "Bienvenido, MARCÓ FUERA DE HORARIO < ?="Hora TOL:".$horaTolAM." $.Tolerancia:". $tolerancia ?>",
                                                text: "Bienvenido, MARCÓ FUERA DE HORA",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                                                    } else { ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
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
                                    text: "El sistema no se encuentra habilitado",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                        <?php 
                    }
                    
                }
            
                //aqui va }del if else que verifica si es continuo
            }
        }
        
        
        
        else { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Error",
            type: "error",
            //text: "El CI Ingresado no Existe < ?="Hora TOL:".$horaTolAM." $.Tolerancia:". $tolerancia ?>",            
            text: "El CI no existe",
            styling: "bootstrap3"
        })
    })
</script>
<?php }

























        }elseif ($i == 2) {
            
            $dni = $_POST["txtdni"];
            $consulta = $conexion->query(" select count(*) as 'total' from empleado where dni='$dni' ");
            $id = $conexion->query(" select id_empleado from empleado where dni='$dni' ");
            $id_empleado = $id->fetch_object()->id_empleado;
    
            if ($consulta->fetch_object()->total > 0) {        //Verifica si existe el CI del empleado
                //echo ("Holi");
                $conti = $conexion->query(" SELECT area.continuo FROM area INNER JOIN empleado ON empleado.area = area.id_area where id_empleado=$id_empleado"); 
                $continuo = $conti->fetch_object()->continuo;
                //echo ("Continuo: $continuo");
                $areaa = $conexion->query(" SELECT empleado.area FROM empleado where id_empleado=$id_empleado"); 
                $area = $areaa->fetch_object()->area;
                if ($continuo == "si") {
                    $fecha = date("Y-m-d H:i:s");
                            //echo ("Holi3");
                            //echo ("$continuo");
                            //echo ("$id_empleado");
                            $busqueda = $conexion->query(" select id_asistenciac,entrada from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1");
                    //echo ("Area: $area");
                    if ($area != 3) {
                            while ($datos = $busqueda->fetch_object()) {
                                $id_asistenciac = $datos->id_asistenciac;
                                $entradaBD = $datos->entrada;
                            }
                            //echo ("Entrada: $entrada");
    
    
                            if (substr($fecha, 0, 10) != substr($entradaBD, 0, 10)) { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Error",
                                            type: "error",
                                            text: "Primero debe registrar su entrada.",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php
                                            } else {
                                                $consultaFecha = $conexion->query(" select salida from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1 ");
                                                $fechaBD = $consultaFecha->fetch_object()->salida;
                                                //verifica si ya registro la salida
                                                if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Error",
                                            type: "error",
                                            text: "Ya se registro su salida.",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php
                                                } else {
                                
                                                    $consultaSalida = $conexion->query(" SELECT continuo_adm.salida FROM continuo_adm INNER JOIN area ON continuo_adm.area = area.id_area INNER JOIN empleado ON empleado.area = area.id_area where id_empleado=$id_empleado ");
                                                    $horaSalida = $consultaSalida->fetch_object()->salida;
                                                    $lim = $conexion->query(" SELECT continuo_adm.limite FROM continuo_adm INNER JOIN area ON continuo_adm.area = area.id_area INNER JOIN empleado ON empleado.area = area.id_area where id_empleado=$id_empleado ");
                                                    $limite = $lim->fetch_object()->limite;
                                                    $marcarS=date("H:i");
                                
                                                    if ($marcarS>=$horaSalida and $marcarS <= $limite ) {
                                                        //insertarsql
                                                        $sql = $conexion->query(" update asistencia_continuo set salida='$fecha' where id_asistenciac=$id_asistenciac");
                                                        //$sql = $conexion->query(" select * from empleado");
                                                    if ($sql == true) { $variable = true;?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Correcto",
                                            type: "success",
                                            text: "Hasta luego.",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php } else { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Error",
                                            type: "error",
                                            text: "Error al registrar su salida.",
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
                                            title: "Error",
                                            type: "error",
                                            text: "No puede marcar su salida.",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php 
                                                    }
                                                }
                                            }
    
                        } else {
                    
                            $fecha = date("Y-m-d H:i:s");
                            //echo ("Holi3");
                            //echo ("$continuo");
                            //echo ("$id_empleado");
                            $busqueda = $conexion->query(" select id_asistenciac,entrada from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1");
                            
                            $consultaNombre = $conexion->query("SELECT parametroc.nombre FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado where id_empleado=$id_empleado");
                            $consul = $consultaNombre->fetch_object()->nombre; 
                            
                            $consultaTN = $conexion->query("SELECT nombre FROM parametroc 
                            WHERE nombre LIKE '%pm_am' or nombre LIKE 'pm_am%' or nombre LIKE '%pm_am%'or 
                            nombre LIKE '%pm am' or nombre LIKE 'pm am%' or nombre LIKE '%pm am%' or
                            nombre LIKE '%pm-am' or nombre LIKE 'pm-am%' or nombre LIKE '%pm-am%' OR
                            nombre LIKE '%noche' or nombre LIKE 'noche%' or nombre LIKE '%noche%' or
                            nombre LIKE '%nocturno' or nombre LIKE 'nocturno%' or nombre LIKE '%nocturno%'");
                            $consulTN = $consultaTN->fetch_object()->nombre;
            
                            while ($datos = $busqueda->fetch_object()) {
                                $id_asistenciac = $datos->id_asistenciac;
                                $entradaBD = $datos->entrada;
                            }
                
            
                            /*echo "<br>";
                            $a=substr($fecha, 0, 10);
                            echo("Fecha salida: $a");
                            echo "<br>";
                            $b=substr($entradaBD, 0, 10);
                            echo("Fecha ultima Entrada: $b");*/
            
                            if($consul==$consulTN){
                                //REGISTRA SALIDAS DEL TURNO NOCTURNO
                                //SI LA FECHA DE LA ULTIMA ENTRADA ES DISTINTA A LA DE SALIDA, PASA A REGISTRARSE
                                if (substr($fecha, 0, 10) != substr($entradaBD, 0, 10)) {
                                            $consultaFecha = $conexion->query(" select salida from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1 ");
                                            $fechaBD = $consultaFecha->fetch_object()->salida;
                                            
            
                                                    //verifica si ya registro la salida
                                                    if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) { 
                                                        
                                                        ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Ya se registró su salida.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                                                    } else {
                                    
                                                        $consultaSalida = $conexion->query(" SELECT parametroc.salida FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado where id_empleado=$id_empleado ");
                                                        $horaSalida = $consultaSalida->fetch_object()->salida;
                                                        $lim = $conexion->query(" SELECT parametroc.limite FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado where id_empleado=$id_empleado ");
                                                        $limite = $lim->fetch_object()->limite;
                                                        $marcarS=date("H:i");
                                                        
                                                        //echo("$marcarS  $horaSalida   $limite");
                                                        if ($marcarS >= $horaSalida and $marcarS <= $limite ) {
                                                            //insertarsql
                                                            $sql = $conexion->query(" update asistencia_continuo set salida='$fecha' where id_asistenciac=$id_asistenciac");
                                                            //$sql = $conexion->query(" select * from empleado");
                                                        if ($sql == true) { $variable = true;?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Correcto",
                                                type: "success",
                                                text: "Hasta luego.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php } else { ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Error al registrar su salida.",
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
                                                title: "Error",
                                                type: "error",
                                                text: "No puede marcar su salida.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php 
                                                        }
                                                    }
                                } else {
                                    ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "No puede marcar.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                                }
                            }
                            //REGISTRA SALIDA DE LOS TURNOS MAÑANA O TARDE
                            else{
                                if (substr($fecha, 0, 10) != substr($entradaBD, 0, 10)) { ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Primero debe registrar su entrada.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                                                } else {
                                                    $consultaFecha = $conexion->query(" select salida from asistencia_continuo where id_empleado=$id_empleado order by id_asistenciac desc limit 1 ");
                                                    $fechaBD = $consultaFecha->fetch_object()->salida;
                                                    //verifica si ya registro la salida
                                                    if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) { ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Ya se registro su salida.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php
                                                    } else {
                                    
                                                        $consultaSalida = $conexion->query(" SELECT parametroc.salida FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado where id_empleado=$id_empleado ");
                                                        $horaSalida = $consultaSalida->fetch_object()->salida;
                                                        $lim = $conexion->query(" SELECT parametroc.limite FROM parametroc INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado where id_empleado=$id_empleado ");
                                                        $limite = $lim->fetch_object()->limite;
                                                        $marcarS=date("H:i");
                                    
                                                        if ($marcarS>=$horaSalida and $marcarS <= $limite ) {
                                                            //insertarsql
                                                            $sql = $conexion->query(" update asistencia_continuo set salida='$fecha' where id_asistenciac=$id_asistenciac");
                                                            //$sql = $conexion->query(" select * from empleado");
                                                        if ($sql == true) { $variable = true;?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Correcto",
                                                type: "success",
                                                text: "Hasta luego.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php } else { ?>
                                    <script>
                                        $(function notificacion() {
                                            new PNotify({
                                                title: "Error",
                                                type: "error",
                                                text: "Error al registrar su salida.",
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
                                                title: "Error",
                                                type: "error",
                                                text: "No puede marcar su salida.",
                                                styling: "bootstrap3"
                                            })
                                        })
                                    </script>
                                    <?php 
                                                        }
                                                    }
                                                }
                            }                    
                        }
                        
                
                }
    
                                else {
                    $marcaS=date("H:i");
    
                    $fecha = date("Y-m-d H:i:s");
    
                    $id = $conexion->query(" select id_empleado from empleado where dni='$dni' ");
                    $id_empleado = $id->fetch_object()->id_empleado;
    
                    $busqueda = $conexion->query(" select id_asistencia,entrada,entrada_pm from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1");
                    $lim_am = $conexion->query(" select cargo.limite_salam FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                    $limAM = $lim_am->fetch_object()->limite_salam;
    
                    $lim_pm = $conexion->query(" select cargo.limite_salpm FROM cargo INNER JOIN empleado ON empleado.cargo = cargo.id_cargo where id_empleado=$id_empleado"); 
                    $limPM = $lim_pm->fetch_object()->limite_salpm;
    
    
                    while ($datos = $busqueda->fetch_object()) {
                        $id_asistencia = $datos->id_asistencia;
                        $entradaBD = $datos->entrada;
                        $entradaBDPM = $datos->entrada_pm;
                    }
    
                    //echo("entradaBD PM: $entradaBDPM");
                        if ($marcaS>=$limAM) { 
                            
                                    //////////DE AQUI PARA ADELANTE ES EJECUTAR SI SALE EN EL HORARIO DE LA TARDE...!!!//////////
                                    //////////DE AQUI PARA ADELANTE ES EJECUTAR SI SALE EN EL HORARIO DE LA TARDE...!!!//////////
                                    //////////DE AQUI PARA ADELANTE ES EJECUTAR SI SALE EN EL HORARIO DE LA TARDE...!!!//////////
                             //Verifica si existe entrada para introducir salida
                    if (substr($fecha, 0, 10) != substr($entradaBDPM, 0, 10)) { ?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "Error",
                                    type: "error",
                                    text: "Primero debe registrar su entrada de la TARDE",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                        <?php
                                    } else {
                                        $consultaFecha = $conexion->query(" select salida_pm from asistencia where id_empleado=$id_empleado order by id_asistencia desc limit 1 ");
                                        $fechaBD = $consultaFecha->fetch_object()->salida_pm;
                                        //verifica si ya registro la salida
                                        if (substr($fecha, 0, 10) == substr($fechaBD, 0, 10)) { ?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "Error",
                                    type: "error",
                                    text: "Ya se registro su salida de la TARDE",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                        <?php
                                        } else {
                                            $consultaSalida = $conexion->query(" select cargo.hora_salida_pm from empleado inner join cargo on empleado.cargo = cargo.id_cargo where dni= $dni");
                                            $horaSalida = $consultaSalida->fetch_object()->hora_salida_pm;
                                            $marcarS=date("H:i");
                        
                                            if ($marcarS>=$horaSalida and $marcarS <= $limPM ) {
                                                $sql = $conexion->query(" update asistencia set salida_pm='$fecha' where id_asistencia=$id_asistencia");
                                                //insertarsql
                                                //$sql = $conexion->query(" select * from empleado");
                                            if ($sql == true) { $variable = true;?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "Correcto",
                                    type: "success",
                                    text: "Hasta luego.",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                        <?php } else { ?>
                        <script>
                            $(function notificacion() {
                                new PNotify({
                                    title: "Error",
                                    type: "error",
                                    text: "Error al registrar su salida de la TARDE.",
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
                                    title: "Error",
                                    type: "error",
                                    text: "No puede marcar salida.",
                                    styling: "bootstrap3"
                                })
                            })
                        </script>
                        <?php 
                                            }
                                        }
                                    }
                        } else {
        
                                    //////////DE AQUI PARA ADELANTE ES EJECUTAR SI SALE EN EL HORARIO DE LA MAÑANA...!!!//////////
                                    //////////DE AQUI PARA ADELANTE ES EJECUTAR SI SALE EN EL HORARIO DE LA MAÑANA...!!!//////////
                                    //////////DE AQUI PARA ADELANTE ES EJECUTAR SI SALE EN EL HORARIO DE LA MAÑANA...!!!//////////
                                    //////////DE AQUI PARA ADELANTE ES EJECUTAR SI SALE EN EL HORARIO DE LA MAÑANA...!!!//////////
                                    //////////DE AQUI PARA ADELANTE ES EJECUTAR SI SALE EN EL HORARIO DE LA MAÑANA...!!!//////////
                            
                             //Verifica si existe entrada para introducir salida
                            if (substr($fecha, 0, 10) != substr($entradaBD, 0, 10)) { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Error",
                                            type: "error",
                                            text: "Primero debe registrar su entrada.",
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
                                            title: "Error",
                                            type: "error",
                                            text: "Ya se registro su salida de la MAÑANA.",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php
                                                } else {
                                
                                                    $consultaSalida = $conexion->query(" select cargo.hora_salida_am from empleado inner join cargo on empleado.cargo = cargo.id_cargo where dni= $dni");
                                                    $horaSalida = $consultaSalida->fetch_object()->hora_salida_am;
                                                    $marcarS=date("H:i");
                                
                                                    if ($marcarS>=$horaSalida and $marcarS <= $limAM ) {
                                                        //insertarsql
                                                        $sql = $conexion->query(" update asistencia set salida='$fecha' where id_asistencia=$id_asistencia");
                                                        //$sql = $conexion->query(" select * from empleado");
                                                    if ($sql == true) {$variable = true; ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Correcto",
                                            type: "success",
                                            text: "Hasta luego.",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php } else { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Error",
                                            type: "error",
                                            text: "Error al registrar su salida.",
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
                                            title: "Error",
                                            type: "error",
                                            text: "No puede marcar salida.",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php 
                                                    }
                                                    
                                
                                
                                                }
                                
                                            }
                                }
                                    
                        }
                    } else { ?>
                                <script>
                                    $(function notificacion() {
                                        new PNotify({
                                            title: "Error",
                                            type: "error",
                                            text: "El CI no existe",
                                            styling: "bootstrap3"
                                        })
                                    })
                                </script>
                                <?php }














        } elseif ($i == 3) {
                $variable = true;
        }
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