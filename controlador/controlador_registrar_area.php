<?php
    if (!empty($_POST["btnregistrar"])) {
        if (!empty($_POST["txtnombre"]) and !empty($_POST["txtcontinuo"]) ) {
            $nombre=$_POST["txtnombre"];
            $continuo=$_POST["txtcontinuo"];


            $sql = $conexion->query(" select count(*) as 'total' from area where nombre='$nombre' ");
            if ($sql->fetch_object()->total > 0) {?>
                <script>
                $(function notificacion() {
                    new PNotify({
                        title: "Error",
                        type: "error",
                        text: "El area <?= $nombre ?> ya existe",
                        styling: "bootstrap3"
                    })
                })
            </script>
            <?php } else {
            $registro = $conexion->query(" insert into area(nombre,continuo) values('$nombre','$continuo') ");
                if ($registro==true) {?>
                <script>
                $(function notificacion() {
                    new PNotify({
                        title: "Correcto",
                        type: "success",
                        text: "El área se registro correctamente",
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