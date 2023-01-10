<?php

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtnombre"]) and !empty($_POST["txtapellido"] ) and !empty($_POST["txtusuario"])) {
        $nombre=$_POST["txtnombre"];
        $apellido=$_POST["txtapellido"];
        $usuario=$_POST["txtusuario"];
        $id=$_POST["txtid"];
        $sql = $conexion->query(" select count(*) as 'total' from usuario where usuario='$usuario' and id_usuario!=$id");
        if ($sql->fetch_object()->total > 0) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "El usuario <?= $usuario ?> ya existe",
                    styling: "bootstrap3"
                })
            })
        </script>
        <?php } else {
            $modificar=$conexion->query(" update usuario set nombre='$nombre',apellido='$apellido',usuario='$usuario' where id_usuario=$id " );
            if ($modificar==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El usuario se modificó correctamente",
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
                        text: "Error al modificar usuario",
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
    //Esto es para que ya no mande alerta de volver a modificar (duplicado) cuando se recarga la pagina
    setTimeout(() => {
        window.history.replaceState(null,null,window.location.pathname);
    }, 0);
</script>

<?php }

?>