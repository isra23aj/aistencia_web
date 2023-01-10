<?php
    if (!empty($_POST["btnregistrar"])) {
        if (!empty($_POST["txtnombre"]) and !empty($_POST["txtapellido"]) and !empty($_POST["txtdni"]) and !empty($_POST["txtcargo"])) {
            $nombre=$_POST["txtnombre"];
            $apellido=$_POST["txtapellido"];
            $dni=$_POST["txtdni"];
            $cargo=$_POST["txtcargo"];
            $area=$_POST["txtarea"];

            $sql = $conexion->query(" select count(*) as 'total' from empleado where dni='$dni' ");
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
            $registro = $conexion->query(" insert into empleado(nombre,apellido,dni,cargo,area) values('$nombre','$apellido',$dni,$cargo,$area) ");
                if ($registro==true) {?>
                <script>
                $(function notificacion() {
                    new PNotify({
                        title: "Correcto",
                        type: "success",
                        text: "El empleado se registro correctamente",
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