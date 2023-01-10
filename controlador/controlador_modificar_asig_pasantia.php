<?php

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtnombre"]) and !empty($_POST["txtarea"] ) and !empty($_POST["txtcontinuo_adm"])) {
        $id=$_POST["txtid"];
        $nombre=$_POST["txtnombre"];
        $area=$_POST["txtarea"];
        $continuo_adm=$_POST["txtcontinuo_adm"];

        
        $sql = $conexion->query(" select count(*) as 'total' from asig_pasantia where id_asig_pasantia=$id");
        echo ("$id");
        if ($sql->fetch_object()->total > 0) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "Ya existe con CI <?= $dni ?> ya existe",
                    styling: "bootstrap3"
                })
            })
        </script>
        <?php } else {
            $modificar=$conexion->query(" update asig_pasantia set empleado=$nombre,area=$area,continuo_adm=$continuo_adm where id_asig_pasantia=$id " );
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