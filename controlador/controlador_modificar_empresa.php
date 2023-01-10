<?php

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtid"]) ) {
        $id=$_POST["txtid"];
        $nombre=$_POST["txtnombre"];
        $telefono=$_POST["txttelefono"];
        $ubicacion=$_POST["txtubicacion"];
        $ruc=$_POST["txtruc"];
        $sql = $conexion->query(" update empresa set nombre='$nombre', telefono='$telefono', ubicacion='$ubicacion', ruc='$ruc' where id_empresa=$id ");
        if ($sql==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "Los datos se modificaron correctamente",
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
                    text: "Error al modificar los datos",
                    styling: "bootstrap3"
                })
            })
        </script>
    <?php  }
        
        }  else { ?>
                <script>
                $(function notificacion() {
                    new PNotify({
                        title: "Incorrecto",
                        type: "error",
                        text: "No se envió el identificador",
                        styling: "bootstrap3"
                    })
                })
            </script>
<?php } ?>
    
    <script>
    //Esto es para que ya no mande alerta de volver a modificar (duplicado) cuando se recarga la pagina
    setTimeout(() => {
        window.history.replaceState(null,null,window.location.pathname);
    }, 0);
</script>

<?php }

?>