<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $conexion->query(" delete from asistencia where id_asistencia=$id ");
    if ($sql == true) { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Correcto",
            type: "success",
            text: "Asistencia Eliminada Correctamente",
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
            text: "Error al Eliminar",
            styling: "bootstrap3"
        })
    })
</script>
<?php } ?>

<script>
    //Esto es para que ya no mande alerta de eliminacion cuando se recarga la pagina
    setTimeout(() => {
        window.history.replaceState(null,null,window.location.pathname);
    }, 0);
</script>

<?php }
