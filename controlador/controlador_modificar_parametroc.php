<?php
if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtnombre"]) and !empty($_POST["txtentrada"]) and !empty($_POST["txtsalida"]) 
    and !empty($_POST["txthabilitar"]) and !empty($_POST["txtlimite"]) and !empty($_POST["txttolerancia"]) 
    and !empty($_POST["txtarea"]) and !empty($_POST["txtempleado"])) {            
        $nombre=$_POST["txtnombre"];
        $entrada=$_POST["txtentrada"];
        $salida=$_POST["txtsalida"];
        $habilitar=$_POST["txthabilitar"];
        $limite=$_POST["txtlimite"];
        $tolerancia=$_POST["txttolerancia"]; 
        $area=$_POST["txtarea"];
        $empleado=$_POST["txtempleado"];
        $id=$_POST["txtid"];
        
        $sql = $conexion->query(" select count(*) as 'total' from parametroc where nombre='$nombre' and id_parametroc!=$id");
        if ($sql->fetch_object()->total > 0) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "El parámetro <?= $nombre ?> ya existe",
                    styling: "bootstrap3"
                })
            })
        </script>
        <?php } else {
            $modificar=$conexion->query(" update parametroc set nombre='$nombre',entrada='$entrada',salida='$salida',habilitar='$habilitar',limite='$limite'
            ,tolerancia=$tolerancia, area=$area,empleado=$empleado  where id_parametroc=$id " );
            if ($modificar==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El parametro se modificó correctamente",
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
                        text: "Error al modificar parametro",
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