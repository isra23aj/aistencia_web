<?php

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtnombre"]) and !empty($_POST["txtapellido"] ) and !empty($_POST["txtusuario"])) {
        $nombre=$_POST["txtnombre"];
        $apellido=$_POST["txtapellido"];
        $usuario=$_POST["txtusuario"];
        $id=$_POST["txtid"];
        $sql = $conexion->query(" update usuario set nombre='$nombre',apellido='$apellido',usuario='$usuario' where id_usuario=$id");
   
        if ($sql==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "Datos modificados correctamente",
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
                        text: "Error al modificar datos",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php }
        

   } else {?>
        <script>
    $(function notificacion() {
        new PNotify({
            title: "Incorrecto",
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