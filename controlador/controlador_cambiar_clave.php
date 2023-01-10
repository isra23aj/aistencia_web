<?php

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["txtclaveactual"]) and !empty($_POST["txtclavenueva"] ) and !empty($_POST["txtid"] )) {
        //md5() para encriptar
        $claveactual=md5($_POST["txtclaveactual"]);
        $clavenueva=md5($_POST["txtclavenueva"]);
        $id=$_POST["txtid"];
        $verificarClaveActual=$conexion->query(" select password from usuario where id_usuario=$id");
        if ($verificarClaveActual->fetch_object()->password==$claveactual) {    
            $sql = $conexion->query(" update usuario set password='$clavenueva' where id_usuario=$id");
            if ($sql==true) {?>
                <script>
                $(function notificacion() {
                    new PNotify({
                        title: "Correcto",
                        type: "success",
                        text: "La contraseña se modifico correctamente",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php 
            } else {?>
                <script>
                $(function notificacion() {
                    new PNotify({
                        title: "Incorrecto",
                        type: "error",
                        text: "Error al modificar la contraseña",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php 
            }
            
        } else { ?>
                <script>
                $(function notificacion() {
                    new PNotify({
                        title: "Incorrecto",
                        type: "error",
                        text: "La contraseña actual es incorrecta",
                        styling: "bootstrap3"
                    })
                })
            </script>
        <?php }
        

   } else {?>
        <script>
    $(function notificacion() {
        new PNotify({
            title: "Incorrecto",
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