<?php
    if (!empty($_POST["btnregistrar"])) {
        if (!empty($_POST["txtnombre"]) and !empty($_POST["txtarea"]) and !empty($_POST["txtcontinuo_adm"])) {
            $nombre=$_POST["txtnombre"];
            $area=$_POST["txtarea"];
            $id=$_POST["txtid"];
            $continuo_adm=$_POST["txtcontinuo_adm"];
           
            $sql = $conexion->query(" select count(*) as 'total' from asig_pasantia where id_asig_pasantia='$id' ");
            if ($sql->fetch_object()->total > 0) {?>
                <script>
                $(function notificacion() {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "El empleado con DNI <?= $dni ?> ya existe",
                        styling: "bootstrap3"
                    })
                })
            </script>
            <?php } else {
            //echo ("$nombre ... $area ... $continuo_adm");
            $registro = $conexion->query(" insert into asig_pasantia(empleado,area,continuo_adm) values($nombre,$area,$continuo_adm) ");
                if ($registro==true) {?>
                <script>
                $(function notificacion() {
                    new PNotify({
                        title: "Correcto",
                        type: "success",
                        text: "se asigno correctamente",
                        styling: "bootstrap3"
                    })
                })
            </script>
                    <?php } else {?>
                        <script>
                        $(function notificacion() {
                            new PNotify({
                                title: "Incorrecto",
                                type: "error",
                                text: "Error al registrar usuario",
                                styling: "bootstrap3"
                            })
                        })
                    </script>
                    
                <?php }
        }

        } else {?>
            <script>
        $(function notificacion() {
            new PNotify({
                title: "Error",
                type: "error",
                text: "Los Campos estan Vacíos",
                styling: "bootstrap3"
            })
        })
    </script>
        <?php }?>
    
        <script>
        //Esto es para que ya no mande alerta de volver a ingresar (duplicado) cuando se recarga la pagina
        setTimeout(() => {
            window.history.replaceState(null,null,window.location.pathname);
        }, 0);
    </script>
    
    <?php 
}