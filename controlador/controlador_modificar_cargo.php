<?php

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtnombre"]) and !empty($_POST["txtentrada_am"]) and !empty($_POST["txtsalida_am"]) and !empty($_POST["txtentrada_pm"]) and !empty($_POST["txtsalida_pm"])
    and !empty($_POST["txttolerancia"]) and !empty($_POST["txthabilitar"]) and !empty($_POST["txtlimiteam"]) and !empty($_POST["txthabilitarpm"])
    and !empty($_POST["txtlimitepm"])) {
       
        $nombre=$_POST["txtnombre"];
        //$area=$_POST["txtarea"];
        $entrada_am=$_POST["txtentrada_am"];
        $salida_am=$_POST["txtsalida_am"];
        $habilitar=$_POST["txthabilitar"];
        $limiteam=$_POST["txtlimiteam"];
        $entrada_pm=$_POST["txtentrada_pm"];
        $salida_pm=$_POST["txtsalida_pm"];
        $habilitarpm=$_POST["txthabilitarpm"];
        $limitepm=$_POST["txtlimitepm"];
        $tolerancia=$_POST["txttolerancia"];
        
        $id=$_POST["txtid"];
        $sql = $conexion->query(" select count(*) as 'total' from cargo where nombre='$nombre' and id_cargo!=$id");
        if ($sql->fetch_object()->total > 0) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "El cargo <?= $nombre ?> ya existe",
                    styling: "bootstrap3"
                })
            })
        </script>
        <?php } else {
            $modificar=$conexion->query(" update cargo set nombre='$nombre',hora_entrada_am='$entrada_am',hora_salida_am='$salida_am',habilitar_am='$habilitar',limite_salam='$limiteam',habilitar_pm='$habilitarpm',hora_entrada_pm='$entrada_pm',
                                hora_salida_pm='$salida_pm',limite_salpm='$limitepm',tolerancia=$tolerancia where id_cargo=$id " );
            if ($modificar==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El cargo se modificó correctamente",
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
                        text: "Error al modificar cargo",
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