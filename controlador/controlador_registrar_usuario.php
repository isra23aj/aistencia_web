<?php

if (!empty($_POST["btnregistrar"])){
    if (!empty($_POST["txtnombre"]) and !empty($_POST["txtapellido"] ) and !empty($_POST["txtusuario"]) and !empty($_POST["txtpassword"])){
        $nombre=$_POST["txtnombre"];
        $apellido=$_POST["txtapellido"];
        $usuario=$_POST["txtusuario"];
        $password=md5($_POST["txtpassword"]);

        $sql = $conexion->query(" select count(*) as 'total' from usuario where usuario='$usuario' ");
        if ($sql->fetch_object()->total > 0) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "El usuario <?= $usuario ?> ya existe",
                    styling: "bootstrap3"
                })
            })
        </script>
        <?php } else {
        $registro = $conexion->query(" insert into usuario(nombre,apellido,usuario,password) values('$nombre','$apellido','$usuario','$password') ");
            if ($registro==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El usuario se registro correctamente",
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
                            text: "Error al registrar usuario",
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
    //Esto es para que ya no mande alerta de volver a ingresar (duplicado) cuando se recarga la pagina
    setTimeout(() => {
        window.history.replaceState(null,null,window.location.pathname);
    }, 0);
</script>

<?php }
