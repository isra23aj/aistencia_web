<?php

if (!empty($_POST["btnregistrar"])){
    if (!empty($_POST["txtnombre"]) and !empty($_POST["txtentrada"]) and !empty($_POST["txtsalida"])
    and !empty($_POST["txttolerancia"]) and !empty($_POST["txthabilitar"]) and !empty($_POST["txtarea"])
    and !empty($_POST["txtempleado"])) {
        $nombre=$_POST["txtnombre"];
        $entrada=$_POST["txtentrada"];
        $salida=$_POST["txtsalida"];
        $habilitar=$_POST["txthabilitar"];
        $limite=$_POST["txtlimite"];
        $tolerancia=$_POST["txttolerancia"]; 
        $area=$_POST["txtarea"];
        $empleado=$_POST["txtempleado"];
        
        
        $verificarNombre=$conexion->query("select count(*) as 'total' from parametroc where nombre='$nombre' ");
        if ($verificarNombre->fetch_object()->total > 0) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "El parametro <?= $nombre ?> ya existe",
                    styling: "bootstrap3"
                })
            })
        </script>
        <?php } else {
        $sql = $conexion->query(" insert into parametroc(nombre,entrada,salida,habilitar,limite,tolerancia,area,empleado) 
                                values('$nombre','$entrada','$salida','$habilitar','$limite',$tolerancia,$area,$empleado) ");
            if ($sql==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El parametro se registró correctamente",
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
                            text: "Error al registrar parametro",
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
