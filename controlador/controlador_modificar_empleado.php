<?php

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtid"]) and !empty($_POST["txtnombre"]) and !empty($_POST["txtapellido"] ) and !empty($_POST["txtdni"]) and !empty($_POST["txtcargo"])) {
        $id=$_POST["txtid"];
        $nombre=$_POST["txtnombre"];
        $apellido=$_POST["txtapellido"];
        $dni=$_POST["txtdni"];
        $cargo=$_POST["txtcargo"];
        $area=$_POST["txtarea"];
        
        $sql = $conexion->query(" select count(*) as 'total' from empleado where dni=$dni and id_empleado!=$id");
        if ($sql->fetch_object()->total > 0) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "El empleado con CI <?= $dni ?> ya existe",
                    styling: "bootstrap3"
                })
            })
        </script>
        <?php } else {
            $modificar=$conexion->query(" update empleado set nombre='$nombre',apellido='$apellido',dni=$dni, cargo=$cargo, area=$area where id_empleado=$id " );
            if ($modificar==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El empleado se modificó correctamente",
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
                        text: "Error al modificar empleado",
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