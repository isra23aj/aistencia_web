<?php

if (!empty($_POST["btnregistrar"])){
    if (!empty($_POST["txtnombre"]) and !empty($_POST["txtarea"]) and !empty($_POST["txtentrada_am"]) and !empty($_POST["txtsalida_am"]) and !empty($_POST["txtentrada_pm"]) and !empty($_POST["txtsalida_pm"])
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

        $verificarNombre=$conexion->query("select count(*) as 'total' from cargo where nombre='$nombre' ");
        if ($verificarNombre->fetch_object()->total > 0) {?>
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
        $sql = $conexion->query(" insert into cargo(nombre,hora_entrada_am,hora_salida_am,habilitar_am,limite_salam,habilitar_pm,hora_entrada_pm,hora_salida_pm,limite_salpm,tolerancia) 
                                values('$nombre','$entrada_am','$salida_am','$habilitar','$limiteam','$habilitarpm','$entrada_pm','$salida_pm','$limitepm',$tolerancia) ");
            if ($sql==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El cargo se registró correctamente",
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
                            text: "Error al registrar cargo",
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
            text: "El campo está vacío",
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
