<?php

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtid"]) and !empty($_POST["txtnombre"]) and !empty($_POST["txtcontinuo"])) {
        $id=$_POST["txtid"];
        $nombre=$_POST["txtnombre"];
        $continuo=$_POST["txtcontinuo"];
        $sql = $conexion->query(" select count(*) as 'total' from area where nombre='$nombre' and id_area!=$id");
        if ($sql->fetch_object()->total > 0) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "El área <?= $nombre ?> ya existe",
                    styling: "bootstrap3"
                })
            }) 
        </script>
        <?php } else {
            $modificar=$conexion->query(" update area set nombre='$nombre',continuo='$continuo' where id_area=$id " );
            if ($modificar==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El área se modificó correctamente",
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