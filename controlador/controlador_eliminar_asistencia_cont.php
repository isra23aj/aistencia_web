<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $conexion->query(" delete from asistencia_continuo where id_asistenciac=$id ");
    if ($sql == true) { ?>
<script>
    $(function notificacion() {
        new PNotify({
            title: "Correcto",
            type: "success",
            text: "Registro Eliminado Correctamente",
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
