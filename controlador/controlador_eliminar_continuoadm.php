<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $conexion->query(" delete from continuo_adm where id_continuo_adm=$id ");
    if ($sql == true) { ?>
        <script>
        $(function notificacion() {
            new PNotify({
                title: "Correcto",
                type: "success",
                text: "Horario eliminado correctamente",
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
        text: "Error al eliminar Horario",
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