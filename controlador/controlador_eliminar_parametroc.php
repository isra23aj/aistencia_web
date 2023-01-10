<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $conexion->query(" delete from parametroc where id_parametroc=$id ");
    if ($sql == true) { ?>
        <script>
        $(function notificacion() {
            new PNotify({
                title: "Correcto",
                type: "success",
                text: "Parametro eliminado correctamente",
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
        text: "Error al eliminar parametro",
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
?>